<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'body' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'body.min' => 'Votre avis doit contenir au moins 10 caractères.',
        ]);

        ProductReview::query()->updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
            ],
            [
                'rating' => $data['rating'],
                'body' => $data['body'],
                'is_published' => true,
            ]
        );

        $this->syncProductRating($product);

        return redirect()
            ->route('boutique.show', $product)
            ->withFragment('avis')
            ->with('review_status', 'Merci ! Votre avis a bien été enregistré.');
    }

    private function syncProductRating(Product $product): void
    {
        $avg = ProductReview::query()
            ->where('product_id', $product->id)
            ->where('is_published', true)
            ->avg('rating');

        $product->update([
            'rating' => $avg !== null ? round((float) $avg, 1) : null,
        ]);
    }
}
