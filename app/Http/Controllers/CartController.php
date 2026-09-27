<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function show(): JsonResponse
    {
        return response()->json($this->payload());
    }

    public function add(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'qty' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $this->cart->add((int) $data['product_id'], (int) ($data['qty'] ?? 1));

        return response()->json($this->payload());
    }

    public function update(Request $request, int $productId): JsonResponse
    {
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $this->cart->update($productId, (int) $data['qty']);

        return response()->json($this->payload());
    }

    public function remove(int $productId): JsonResponse
    {
        $this->cart->remove($productId);

        return response()->json($this->payload());
    }

    public function sync(Request $request): JsonResponse
    {
        $data = $request->validate([
            'lines' => ['nullable', 'array'],
            'lines.*.product_id' => ['required', 'integer'],
            'lines.*.qty' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $this->cart->mergeFromClient($data['lines'] ?? []);

        return response()->json($this->payload());
    }

    /** @return array<string, mixed> */
    private function payload(): array
    {
        $lines = $this->cart->all();
        $subtotal = $this->cart->subtotal();

        return [
            'lines' => $lines,
            'count' => $this->cart->count(),
            'subtotal_fcfa' => $subtotal,
            'shipping_fcfa' => $subtotal >= 40000 ? 0 : ($lines ? 2500 : 0),
            'total_fcfa' => $subtotal + ($subtotal >= 40000 || ! $lines ? 0 : 2500),
        ];
    }
}
