<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WishlistItem;
use App\Support\UserWishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = auth()->id();
        $this->purgeInactive($userId);

        return response()->json(['items' => UserWishlist::itemsFor($userId)]);
    }

    public function sync(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer', 'exists:products,id'],
        ]);

        $userId = auth()->id();
        $incoming = collect($data['product_ids'] ?? [])->unique()->values();

        $activeProductIds = Product::query()->where('is_active', true)->pluck('id');

        if ($incoming->isNotEmpty()) {
            $validIds = $activeProductIds->intersect($incoming);
            foreach ($validIds as $productId) {
                WishlistItem::query()->firstOrCreate([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);
            }
        }

        WishlistItem::query()
            ->where('user_id', $userId)
            ->whereNotIn('product_id', $activeProductIds)
            ->delete();

        return response()->json(['items' => UserWishlist::itemsFor($userId)]);
    }

    public function toggle(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $userId = auth()->id();
        $existing = WishlistItem::query()
            ->where('user_id', $userId)
            ->where('product_id', $data['product_id'])
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            WishlistItem::query()->create([
                'user_id' => $userId,
                'product_id' => $data['product_id'],
            ]);
            $added = true;
        }

        $this->purgeInactive($userId);

        return response()->json([
            'added' => $added,
            'items' => UserWishlist::itemsFor($userId),
        ]);
    }

    private function purgeInactive(int $userId): void
    {
        $activeIds = Product::query()->where('is_active', true)->pluck('id');

        WishlistItem::query()
            ->where('user_id', $userId)
            ->whereNotIn('product_id', $activeIds)
            ->delete();
    }
}
