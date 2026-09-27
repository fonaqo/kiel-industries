<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderDelivered;
use App\Models\Order;
use App\Models\OrderManagementLog;
use App\Models\Product;
use App\Models\User;
use App\Support\KielMail;
use App\Support\OrderManagementLogger;
use App\Support\OrderStatus;
use App\Support\UserWishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.dashboard', [
            'page' => 'admin',
            'title' => 'Administration',
            'ordersCount' => Order::query()->count(),
            'productsCount' => Product::query()->count(),
            'usersCount' => User::query()->count(),
            'recentOrders' => Order::query()->withCount('items')->latest()->take(8)->get(),
        ]);
    }

    public function orders(): View
    {
        return view('cms-admin.orders.index', [
            'page' => 'admin',
            'title' => 'Commandes',
            'orders' => Order::query()->withCount('items')->latest()->paginate(20),
        ]);
    }

    public function users(): View
    {
        return view('cms-admin.users.index', [
            'page' => 'admin',
            'title' => 'Utilisateurs',
            'users' => User::query()->latest()->paginate(20),
        ]);
    }

    public function wishlist(): View
    {
        return view('pages.admin.wishlist', [
            'page' => 'admin',
            'title' => 'Mes favoris',
            'wishlistItems' => UserWishlist::itemsFor(auth()->user()),
        ]);
    }

    public function orderShow(Order $order): View
    {
        $user = auth()->user();
        if ($user !== null) {
            OrderManagementLogger::orderViewed($order, $user);
        }

        return view('cms-admin.orders.show', [
            'page' => 'admin',
            'title' => 'Commande '.$order->reference,
            'order' => $order->load('items', 'user'),
            'statuses' => OrderStatus::labels(),
        ]);
    }

    public function ordersHistory(): View
    {
        $logs = OrderManagementLog::query()
            ->with(['user', 'order'])
            ->latest()
            ->paginate(40);

        return view('cms-admin.orders.history', [
            'page' => 'admin',
            'title' => 'Historique commandes',
            'logs' => $logs,
        ]);
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $statuses = OrderStatus::keys();
        $data = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', $statuses)],
        ]);

        $previous = OrderStatus::normalize($order->status);
        $order->update(['status' => $data['status']]);

        $user = auth()->user();
        if ($user !== null && $previous !== $data['status']) {
            OrderManagementLogger::statusChanged($order, $user, $previous, $data['status']);
        }

        if ($data['status'] === 'delivered' && $previous !== 'delivered' && $order->customer_email) {
            $order->load('items');
            KielMail::send($order->customer_email, new OrderDelivered($order));
        }

        return back()->with('status', 'Statut de commande mis à jour.');
    }
}
