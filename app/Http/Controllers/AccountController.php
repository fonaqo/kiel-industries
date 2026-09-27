<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Support\UserWishlist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function dashboard(): View
    {
        $this->linkOrdersToCurrentUser();

        $orders = $this->ordersForCurrentUser()
            ->withCount('items')
            ->latest()
            ->take(5)
            ->get();

        $ordersTotal = $this->ordersForCurrentUser()->count();
        $wishlistCount = count(UserWishlist::itemsFor(auth()->user()));

        return view('pages.account.dashboard', [
            'page' => 'compte',
            'title' => 'Mon espace client',
            'orders' => $orders,
            'ordersTotal' => $ordersTotal,
            'wishlistCount' => $wishlistCount,
        ]);
    }

    public function orders(): View
    {
        $this->linkOrdersToCurrentUser();

        $orders = $this->ordersForCurrentUser()
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view('pages.account.orders', [
            'page' => 'compte',
            'title' => 'Mes commandes',
            'orders' => $orders,
        ]);
    }

    public function orderShow(Order $order): View
    {
        abort_unless($order->canBeViewedBy(auth()->user()), 403);

        $order->attachToUserIfEligible(auth()->user());

        return view('pages.account.order-show', [
            'page' => 'compte',
            'title' => 'Commande '.$order->reference,
            'order' => $order->load('items'),
        ]);
    }

    public function profile(): View
    {
        return view('pages.account.profile', [
            'page' => 'compte',
            'title' => 'Mon profil',
            'user' => auth()->user(),
        ]);
    }

    public function wishlist(): View
    {
        return view('pages.account.wishlist', [
            'page' => 'compte',
            'title' => 'Mes favoris',
            'wishlistItems' => UserWishlist::itemsFor(auth()->user()),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email,'.auth()->id()],
            'phone' => ['nullable', 'string', 'max:40'],
            'city' => ['nullable', 'string', 'max:80'],
            'address' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        unset($data['avatar']);
        $user->update($data);

        return back()->with('status', 'Profil mis à jour.');
    }

    private function linkOrdersToCurrentUser(): void
    {
        $user = auth()->user();
        if ($user === null) {
            return;
        }

        Order::query()
            ->whereNull('user_id')
            ->where('customer_email', $user->email)
            ->update(['user_id' => $user->id]);
    }

    /** @return Builder<Order> */
    private function ordersForCurrentUser(): Builder
    {
        $user = auth()->user();
        assert($user instanceof User);

        return Order::query()->where(function (Builder $query) use ($user): void {
            $query->where('user_id', $user->id)
                ->orWhere('customer_email', $user->email);
        });
    }
}
