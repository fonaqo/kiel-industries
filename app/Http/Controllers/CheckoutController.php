<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Support\KielMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    private const CHECKOUT_FORM_KEYS = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_city',
        'shipping_address',
        'notes',
    ];

    public function __construct(private CartService $cart) {}

    public function show(): View|RedirectResponse
    {
        if (! count($this->cart->all())) {
            return redirect()->route('boutique')->with('status', 'Votre panier est vide.');
        }

        $payload = $this->cartPayload();
        $user = auth()->user();
        $checkoutForm = session('checkout.form', []);

        return view('pages.commande', [
            'page' => 'boutique',
            'title' => 'Finalisation commande',
            'cart' => $payload,
            'user' => $user,
            'checkoutForm' => $checkoutForm,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (! count($this->cart->all())) {
            return redirect()->route('boutique');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:120'],
            'customer_phone' => ['nullable', 'string', 'max:40'],
            'shipping_city' => ['nullable', 'string', 'max:80'],
            'shipping_address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if (! auth()->check()) {
            session([
                'checkout.form' => $request->only(self::CHECKOUT_FORM_KEYS),
                'url.intended' => route('commande'),
            ]);

            return redirect()
                ->route('login')
                ->with('status', 'Connectez-vous ou créez un compte pour enregistrer votre commande. Vos informations de livraison sont conservées.');
        }

        $lines = $this->cart->all();
        $subtotal = $this->cart->subtotal();
        $shipping = $subtotal >= 40000 ? 0 : 2500;
        $total = $subtotal + $shipping;

        try {
            $order = DB::transaction(function () use ($data, $lines, $subtotal, $shipping, $total) {
                $order = Order::query()->create([
                    'user_id' => auth()->id(),
                    'reference' => 'KIEL-'.strtoupper(Str::random(8)),
                    'access_token' => Str::random(48),
                    'status' => 'processing',
                    'subtotal_fcfa' => $subtotal,
                    'shipping_fcfa' => $shipping,
                    'total_fcfa' => $total,
                    'customer_name' => $data['customer_name'],
                    'customer_email' => $data['customer_email'],
                    'customer_phone' => $data['customer_phone'] ?? null,
                    'shipping_city' => $data['shipping_city'] ?? null,
                    'shipping_address' => $data['shipping_address'] ?? null,
                    'payment_method' => 'en_ligne',
                    'notes' => $data['notes'] ?? null,
                ]);

                foreach ($lines as $line) {
                    OrderItem::query()->create([
                        'order_id' => $order->id,
                        'product_id' => $line['product_id'],
                        'product_name' => $line['name'],
                        'unit_price_fcfa' => $line['price'],
                        'quantity' => $line['qty'],
                        'line_total_fcfa' => $line['price'] * $line['qty'],
                        'image_url' => $line['image'],
                    ]);
                }

                return $order;
            });
        } catch (\Throwable) {
            return back()
                ->withInput()
                ->withErrors(['customer_email' => 'Impossible d’enregistrer la commande. Réessayez dans un instant ou contactez-nous.']);
        }

        $this->cart->clear();
        session()->forget('checkout.form');

        $order->load('items');
        KielMail::sendAfterResponse($order->customer_email, new OrderConfirmation($order));

        return redirect()
            ->route('commande.success', $order)
            ->with('status', 'Commande payée. Votre facture vous est envoyée par e-mail.');
    }

    public function success(Order $order): View
    {
        $user = auth()->user();
        abort_unless(
            $user !== null && $order->canBeViewedBy($user),
            403,
            'Accès refusé à cette confirmation de commande.'
        );

        $order->attachToUserIfEligible($user);

        return view('pages.commande-success', [
            'page' => 'boutique',
            'title' => 'Commande confirmée',
            'order' => $order->load('items'),
        ]);
    }

    /** @return array<string, mixed> */
    private function cartPayload(): array
    {
        $subtotal = $this->cart->subtotal();
        $lines = $this->cart->all();

        return [
            'lines' => $lines,
            'count' => $this->cart->count(),
            'subtotal_fcfa' => $subtotal,
            'shipping_fcfa' => $subtotal >= 40000 ? 0 : ($lines ? 2500 : 0),
            'total_fcfa' => $subtotal + ($subtotal >= 40000 || ! $lines ? 0 : 2500),
        ];
    }
}
