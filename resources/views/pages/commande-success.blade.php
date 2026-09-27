@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/shop/kiel-shop.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface">
<section class="kiel-section kiel-order-success">
<div class="kiel-wrap max-w-2xl mx-auto text-center">
<span class="kiel-order-success__icon material-symbols-outlined text-secondary" aria-hidden="true">check_circle</span>
<h1 class="font-headline-lg text-primary mt-3">Commande enregistrée</h1>
<p class="text-on-surface-variant mt-2">Référence <strong>{{ $order->reference }}</strong> · Total {{ number_format($order->total_fcfa, 0, ',', ' ') }} FCFA</p>
<p class="text-sm mt-4 max-w-md mx-auto">Un e-mail avec votre <strong>facture</strong> a été envoyé à <strong>{{ \Illuminate\Support\Str::mask($order->customer_email, '*', 3, max(0, strlen($order->customer_email) - 6)) }}</strong>. Votre commande est <strong>payée</strong> et passe en préparation.</p>
@if(session('status'))
<p class="text-sm mt-3 text-secondary font-bold">{{ session('status') }}</p>
@endif
<div class="flex flex-wrap gap-3 justify-center mt-8">
<a class="kiel-btn kiel-btn--primary" href="{{ route('boutique') }}">Continuer mes achats</a>
@auth
<a class="kiel-btn kiel-btn--outline" href="{{ route('account.orders.show', $order) }}">Voir ma commande</a>
@endauth
</div>
</div>
</section>
</main>
@endsection

@push('scripts')
<script>
try { localStorage.removeItem('kiel_cart_v1'); } catch (e) {}
window.KielCart?.refresh?.();
</script>
@endpush
