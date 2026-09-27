@extends('layouts.admin')

@push('head')
<link href="{{ asset('assets/css/account/kiel-admin-orders.css') }}" rel="stylesheet"/>
@endpush

@section('heroTitle')
Commande {{ $order->reference }}
@endsection
@section('heroLead')
{{ $order->customer_name }} · {{ number_format($order->total_fcfa, 0, ',', ' ') }} FCFA
@endsection
@section('heroCurrent', 'Admin · Commande')

@section('panel')
<div class="mt-2 kiel-admin-order-detail">
@if(session('status'))<p class="text-secondary font-bold">{{ session('status') }}</p>@endif

<div class="kiel-admin-order-detail__head">
<div class="kiel-admin-order-detail__meta">
<strong>{{ $order->reference }}</strong>
<span>Créée le {{ $order->created_at->format('d/m/Y à H:i') }}</span>
<span>Paiement : {{ str_replace('_', ' ', $order->payment_method) }}</span>
@if($order->user)
<span>Compte client : {{ $order->user->name }} ({{ $order->user->email }})</span>
@endif
</div>
<div class="flex flex-wrap items-center gap-3">
@include('partials.order-status', ['status' => $order->status])
<form method="post" action="{{ route('admin.orders.status', $order) }}" class="flex flex-wrap items-center gap-2" data-turbo="false">
@csrf
@method('PATCH')
<label class="sr-only" for="order-status">Statut</label>
<select id="order-status" name="status">
@foreach($statuses as $value => $label)
<option value="{{ $value }}" @selected(\App\Support\OrderStatus::normalize($order->status) === $value)>{{ $label }}</option>
@endforeach
</select>
<button class="kiel-btn kiel-btn--primary" type="submit">Mettre à jour</button>
</form>
</div>
</div>

<div class="kiel-admin-order-cards">
<div class="kiel-admin-order-card">
<h3>Client &amp; contact</h3>
<p>
<strong>{{ $order->customer_name }}</strong><br/>
<a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a>
@if($order->customer_phone)<br/><a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a>@endif
</p>
</div>
<div class="kiel-admin-order-card">
<h3>Livraison</h3>
<p>
@if($order->shipping_address){{ $order->shipping_address }}<br/>@endif
{{ $order->shipping_city ?: 'Ville non renseignée' }}
</p>
</div>
@if($order->notes)
<div class="kiel-admin-order-card" style="grid-column:1/-1">
<h3>Notes client</h3>
<p>{{ $order->notes }}</p>
</div>
@endif
</div>

<div class="kiel-admin-order-items">
<h3>Articles commandés</h3>
@foreach($order->items as $item)
<div class="kiel-admin-order-item">
@if($item->image_url)
<img alt="" loading="lazy" src="{{ $item->image_url }}"/>
@else
<div style="width:56px;height:56px;border-radius:.65rem;background:#ede0db" aria-hidden="true"></div>
@endif
<div>
<p class="kiel-admin-order-item__name">{{ $item->product_name }}</p>
<p class="kiel-admin-order-item__sub">{{ $item->quantity }} × {{ number_format($item->unit_price_fcfa, 0, ',', ' ') }} FCFA@if($item->product_id) · Produit #{{ $item->product_id }}@endif</p>
</div>
<div class="kiel-admin-order-item__price">{{ number_format($item->line_total_fcfa, 0, ',', ' ') }} FCFA</div>
</div>
@endforeach
<div class="kiel-admin-order-totals">
<p><span>Sous-total</span><strong>{{ number_format($order->subtotal_fcfa, 0, ',', ' ') }} FCFA</strong></p>
<p><span>Livraison</span><strong>{{ $order->shipping_fcfa ? number_format($order->shipping_fcfa, 0, ',', ' ').' FCFA' : 'Offerte' }}</strong></p>
<p><span>Total</span><strong>{{ number_format($order->total_fcfa, 0, ',', ' ') }} FCFA</strong></p>
</div>
</div>

<p><a href="{{ route('admin.orders') }}" data-turbo-frame="admin-main">← Retour aux commandes</a></p>
</div>
@endsection
