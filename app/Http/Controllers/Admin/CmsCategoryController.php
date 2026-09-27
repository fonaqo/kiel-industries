<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Support\CmsSeoRules;
use App\Support\CmsUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CmsCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'usage' => ['nullable', 'string', Rule::in(['', 'used', 'empty'])],
        ]);

        $query = Category::query()->withCount('products')->orderBy('sort_order')->orderBy('name');

        if (! empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($builder) use ($term) {
                $builder->where('name', 'like', '%'.$term.'%')
                    ->orWhere('slug', 'like', '%'.$term.'%');
            });
        }

        if (($filters['usage'] ?? '') === 'used') {
            $query->has('products');
        } elseif (($filters['usage'] ?? '') === 'empty') {
            $query->doesntHave('products');
        }

        return view('cms-admin.categories.index', [
            'page' => 'admin',
            'title' => 'Catégories produits',
            'categories' => $query->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('cms-admin.categories.edit', [
            'page' => 'admin',
            'title' => 'Nouvelle catégorie',
            'category' => new Category(['sort_order' => (Category::query()->max('sort_order') ?? 0) + 1]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $category = $this->saveCategory(new Category, $request);

        return redirect()->route('admin.cms.categories.edit', $category)->with('status', 'Catégorie créée.');
    }

    public function edit(Category $category): View
    {
        return view('cms-admin.categories.edit', [
            'page' => 'admin',
            'title' => $category->name,
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->saveCategory($category, $request);

        return back()->with('status', 'Catégorie enregistrée.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('status', 'Impossible de supprimer : des produits utilisent cette catégorie.');
        }

        $category->delete();

        return redirect()->route('admin.cms.categories.index')->with('status', 'Catégorie supprimée.');
    }

    private function saveCategory(Category $category, Request $request): Category
    {
        $data = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120'],
            'image' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:8192'],
            'nav_teaser' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ], CmsSeoRules::rules(false)));

        $imagePath = CmsUploads::resolvePath($request, 'image', 'image_file', $category->image);

        $category->fill([
            'name' => $data['name'],
            'slug' => $data['slug'] ?: Str::slug($data['name']),
            'image' => $imagePath,
            'nav_teaser' => filled($data['nav_teaser'] ?? null) ? $data['nav_teaser'] : null,
            'sort_order' => $data['sort_order'] ?? 0,
            ...CmsSeoRules::onlyMeta($data, false),
        ]);
        $category->save();

        return $category;
    }
}
