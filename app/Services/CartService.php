<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const SESSION_KEY = 'kiel_cart';

    /** @return array<int, array{product_id: int, name: string, price: int, qty: int, image: string}> */
    public function all(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function save(array $lines): void
    {
        session([self::SESSION_KEY => array_values($lines)]);
    }

    public function add(int $productId, int $qty = 1): array
    {
        $product = Product::query()->where('is_active', true)->findOrFail($productId);
        $qty = max(1, min($qty, (int) $product->stock));
        $lines = $this->all();
        $found = false;

        foreach ($lines as &$line) {
            if ($line['product_id'] === $product->id) {
                $line['qty'] = min($product->stock, $line['qty'] + $qty);
                $found = true;
                break;
            }
        }
        unset($line);

        if (! $found) {
            $lines[] = $this->lineFromProduct($product, $qty);
        }

        $this->save($lines);

        return $lines;
    }

    public function update(int $productId, int $qty): array
    {
        $product = Product::query()->find($productId);
        $lines = $this->all();

        if ($qty <= 0) {
            $lines = array_values(array_filter($lines, fn ($l) => $l['product_id'] !== $productId));
            $this->save($lines);

            return $lines;
        }

        $max = $product ? (int) $product->stock : $qty;
        $qty = min($qty, max(1, $max));

        foreach ($lines as &$line) {
            if ($line['product_id'] === $productId) {
                $line['qty'] = $qty;
                break;
            }
        }
        unset($line);

        $this->save($lines);

        return $lines;
    }

    public function remove(int $productId): array
    {
        return $this->update($productId, 0);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * Fusionne le panier client (localStorage) avec la session serveur.
     *
     * @param  array<int, array{product_id: int, qty?: int}>  $clientLines
     */
    public function mergeFromClient(array $clientLines): void
    {
        foreach ($clientLines as $row) {
            $productId = (int) ($row['product_id'] ?? 0);
            $qty = (int) ($row['qty'] ?? 1);
            if ($productId <= 0 || $qty <= 0) {
                continue;
            }
            if (! Product::query()->where('is_active', true)->whereKey($productId)->exists()) {
                continue;
            }

            $existing = collect($this->all())->firstWhere('product_id', $productId);
            if ($existing === null) {
                $this->add($productId, $qty);

                continue;
            }

            if ($qty > (int) $existing['qty']) {
                $this->update($productId, $qty);
            }
        }
    }

    public function count(): int
    {
        return array_sum(array_column($this->all(), 'qty'));
    }

    public function subtotal(): int
    {
        return array_sum(array_map(
            fn ($line) => $line['price'] * $line['qty'],
            $this->all()
        ));
    }

    /** @return Collection<int, Product> */
    public function productsForLines(): Collection
    {
        $ids = array_column($this->all(), 'product_id');

        return Product::query()->whereIn('id', $ids)->get()->keyBy('id');
    }

    /** @return array{product_id: int, name: string, price: int, qty: int, image: string} */
    private function lineFromProduct(Product $product, int $qty): array
    {
        return [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => (int) $product->price_fcfa,
            'qty' => $qty,
            'image' => $product->image_url,
        ];
    }
}
