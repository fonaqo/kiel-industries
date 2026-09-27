<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Support\CmsSeoRules;
use App\Support\CmsUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CmsProductController extends Controller
{
    public function index(Request $request): View
    {
        $categoryIds = Category::query()->pluck('id')->map(fn ($id) => (string) $id)->all();
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', Rule::in(array_merge([''], $categoryIds))],
            'active' => ['nullable', 'string', Rule::in(['', '1', '0'])],
            'stock' => ['nullable', 'string', Rule::in(['', 'in', 'out'])],
        ]);

        $query = Product::query()->with('category')->orderByDesc('updated_at');

        if (! empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($builder) use ($term) {
                $builder->where('name', 'like', '%'.$term.'%')
                    ->orWhere('slug', 'like', '%'.$term.'%')
                    ->orWhere('description', 'like', '%'.$term.'%');
            });
        }

        if (! empty($filters['category'])) {
            $query->where('category_id', (int) $filters['category']);
        }

        if (($filters['active'] ?? '') === '1') {
            $query->where('is_active', true);
        } elseif (($filters['active'] ?? '') === '0') {
            $query->where('is_active', false);
        }

        if (($filters['stock'] ?? '') === 'in') {
            $query->where('stock', '>', 0);
        } elseif (($filters['stock'] ?? '') === 'out') {
            $query->where('stock', '<=', 0);
        }

        return view('cms-admin.products.index', [
            'page' => 'admin',
            'title' => 'Produits',
            'products' => $query->paginate(24)->withQueryString(),
            'categories' => Category::query()->orderBy('sort_order')->orderBy('name')->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('cms-admin.products.edit', [
            'page' => 'admin',
            'title' => 'Nouveau produit',
            'product' => new Product(['is_active' => true, 'stock' => 0]),
            'categories' => Category::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $product = $this->saveProduct(new Product, $request);

        return redirect()->route('admin.cms.products.edit', $product)->with('status', 'Produit créé.');
    }

    public function edit(Product $product): View
    {
        return view('cms-admin.products.edit', [
            'page' => 'admin',
            'title' => $product->name,
            'product' => $product,
            'categories' => Category::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->saveProduct($product, $request);

        return back()->with('status', 'Produit enregistré.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.cms.products.index')->with('status', 'Produit supprimé.');
    }

    public function adjustStock(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'action' => ['required', 'string', 'in:in,out'],
        ]);

        if ($data['action'] === 'in') {
            $product->update([
                'stock' => max(1, (int) $product->stock ?: 10),
                'is_active' => true,
            ]);

            return back()->with('status', 'Produit remis en stock.');
        }

        $product->update(['stock' => 0]);

        return back()->with('status', 'Produit marqué en rupture de stock.');
    }

    private function saveProduct(Product $product, Request $request): Product
    {
        $data = $request->validate(array_merge([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'price_fcfa' => ['required', 'integer', 'min:0'],
            'price_eur' => ['nullable', 'numeric', 'min:0'],
            'price_usd' => ['nullable', 'numeric', 'min:0'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:8192'],
            'gallery_lines' => ['nullable', 'string'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'badge' => ['nullable', 'string', 'max:80'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_best_seller' => ['sometimes', 'boolean'],
            'on_sale' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ], CmsSeoRules::rules()));

        $benefits = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $data['benefits'] ?? ''))));

        $imagePath = CmsUploads::resolvePath(
            $request,
            'image_url',
            'image_file',
            $product->exists ? ($product->getAttributes()['image_url'] ?? null) : null,
        );

        if ($imagePath === null || $imagePath === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'image_url' => 'Indiquez un lien d’image ou téléversez la photo principale.',
            ]);
        }

        $gallery = CmsUploads::resolveGallery(
            $request,
            'gallery_lines',
            'gallery_files',
            $product->gallery,
        );

        $product->fill([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'] ?: Str::slug($data['name']),
            'description' => $data['description'],
            'benefits' => $benefits !== [] ? $benefits : null,
            'price_fcfa' => $data['price_fcfa'],
            'price_eur' => $data['price_eur'],
            'price_usd' => $data['price_usd'],
            'discount_percent' => filled($data['discount_percent'] ?? null) ? (int) $data['discount_percent'] : null,
            'compare_price_fcfa' => null,
            'compare_price_eur' => null,
            'compare_price_usd' => null,
            'image_url' => $imagePath ?? '',
            'gallery' => $gallery !== [] ? $gallery : null,
            'badge' => $data['badge'],
            'stock' => $data['stock'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_best_seller' => $request->boolean('is_best_seller'),
            'on_sale' => $request->boolean('on_sale'),
            'is_active' => $request->boolean('is_active'),
            ...CmsSeoRules::onlyMeta($data),
        ]);
        $product->save();

        return $product;
    }
}
