<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminExportController extends Controller
{
    public function orders(string $format): Response|BinaryFileResponse
    {
        abort_unless(in_array($format, ['pdf', 'excel'], true), 404);

        if ($format === 'excel') {
            return Excel::download(new OrdersExport, 'commandes-kiel-'.now()->format('Y-m-d').'.xlsx');
        }

        $orders = Order::query()->withCount('items')->latest()->get();

        return Pdf::loadView('cms-admin.exports.orders-pdf', [
            'orders' => $orders,
            'generatedAt' => now(),
        ])->download('commandes-kiel-'.now()->format('Y-m-d').'.pdf');
    }

    public function products(string $format): Response|BinaryFileResponse
    {
        abort_unless(in_array($format, ['pdf', 'excel'], true), 404);

        if ($format === 'excel') {
            return Excel::download(new ProductsExport, 'produits-kiel-'.now()->format('Y-m-d').'.xlsx');
        }

        $products = Product::query()->with('category')->orderBy('name')->get();

        return Pdf::loadView('cms-admin.exports.products-pdf', [
            'products' => $products,
            'generatedAt' => now(),
        ])->download('produits-kiel-'.now()->format('Y-m-d').'.pdf');
    }
}
