<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $categories = Category::query()->orderBy('sort_order')->get();
        $filters = $request->only(['categorie', 'promo', 'best', 'stock', 'tri', 'q', 'prix_min', 'prix_max']);
        $products = $this->filteredProducts($request)->paginate(9)->withQueryString();
        $priceBounds = Product::query()->where('is_active', true)->selectRaw('MIN(price_fcfa) as min_p, MAX(price_fcfa) as max_p')->first();

        if ($request->header('X-Kiel-Shop-Partial')) {
            return response()->json([
                'html' => view('partials.boutique-results', compact('products', 'filters', 'categories'))->render(),
            ]);
        }

        return view('pages.boutique', [
            'page' => 'boutique',
            'title' => 'Boutique',
            'categories' => $categories,
            'products' => $products,
            'priceBounds' => $priceBounds,
            'filters' => $filters,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load('category');

        $related = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->when(
                $product->category_id,
                fn ($q) => $q->where('category_id', $product->category_id)
            )
            ->orderByDesc('is_best_seller')
            ->limit(4)
            ->get();

        $reviews = $product->publishedReviews()->with('user')->get();

        $userReview = auth()->check()
            ? $product->reviews()->where('user_id', auth()->id())->first()
            : null;

        return view('pages.boutique-product', [
            'page' => 'boutique',
            'title' => $product->name,
            'product' => $product,
            'related' => $related,
            'reviews' => $reviews,
            'userReview' => $userReview,
        ]);
    }

    private function filteredProducts(Request $request): Builder
    {
        $query = Product::query()->with('category')->where('is_active', true);

        if ($slug = $request->string('categorie')->toString()) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
        }

        if ($q = trim($request->string('q')->toString())) {
            $query->where(function ($builder) use ($q) {
                $builder
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('prix_min')) {
            $query->where('price_fcfa', '>=', (int) $request->input('prix_min'));
        }
        if ($request->filled('prix_max')) {
            $query->where('price_fcfa', '<=', (int) $request->input('prix_max'));
        }

        if ($request->boolean('promo')) {
            $query->where('on_sale', true);
        }
        if ($request->boolean('best')) {
            $query->where('is_best_seller', true);
        }
        if ($request->boolean('stock')) {
            $query->where('stock', '>', 0);
        }

        $sort = $request->string('tri', 'default')->toString();
        match ($sort) {
            'price_asc' => $query->orderBy('price_fcfa'),
            'price_desc' => $query->orderByDesc('price_fcfa'),
            'rating' => $query->orderByDesc('rating'),
            default => $query->orderByDesc('is_best_seller')->orderBy('name'),
        };

        return $query;
    }
}
