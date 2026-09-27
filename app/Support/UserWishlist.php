<?php

namespace App\Support;

use App\Models\Product;
use App\Models\User;
use App\Models\WishlistItem;

class UserWishlist
{
    /**
     * @return list<array{product_id: int, name: string, price: int, image: string, url: string}>
     */
    public static function itemsFor(User|int $user): array
    {
        $userId = $user instanceof User ? $user->id : $user;

        $products = Product::query()
            ->whereIn('id', WishlistItem::query()->where('user_id', $userId)->pluck('product_id'))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        return WishlistItem::query()
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get()
            ->map(function (WishlistItem $row) use ($products) {
                $product = $products->get($row->product_id);
                if (! $product) {
                    return null;
                }

                return [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price_fcfa,
                    'image' => $product->image_url,
                    'url' => route('boutique.show', $product),
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
