@extends('layouts.account')

@push('head')
<link href="{{ asset('assets/css/account/kiel-admin-orders.css') }}" rel="stylesheet"/>
@endpush

@section('heroTitle')
Commande {{ $order->reference }}
@endsection
@section('heroLead')
@include('partials.order-status', ['status' => $order->status]) · {{ $order->paymentMethodLabel() }}
@endsection
@section('heroCurrent', 'Détail commande')

@section('panel')
<div class="mt-2 kiel-admin-order-detail">
<div class="kiel-admin-order-detail__head">
<div class="kiel-admin-order-detail__meta">
<strong>{{ $order->reference }}</strong>
<span>Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</span>
<span>{{ $order->paymentMethodLabel() }}</span>
</div>
@include('partials.order-status', ['status' => $order->status])
</div>

<div class="kiel-admin-order-cards">
<div class="kiel-admin-order-card">
<h3>Contact</h3>
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
<h3>Vos notes</h3>
<p>{{ $order->notes }}</p>
</div>
@endif
</div>

<div class="kiel-admin-order-items">
<h3>Articles</h3>
@foreach($order->items as $item)
<div class="kiel-admin-order-item">
@if($item->image_url)
<img alt="" loading="lazy" src="{{ $item->image_url }}"/>
@else
<div class="kiel-admin-order-item__placeholder" aria-hidden="true"></div>
@endif
<div>
<p class="kiel-admin-order-item__name">{{ $item->product_name }}</p>
<p class="kiel-admin-order-item__sub">{{ $item->quantity }} × {{ number_format($item->unit_price_fcfa, 0, ',', ' ') }} FCFA</p>
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

<p class="kiel-account-order-actions">
<a href="{{ route('commande.success', $order) }}">Voir la confirmation de commande</a>
<span aria-hidden="true">·</span>
<a href="{{ route('account.orders') }}" data-turbo-frame="account-main">← Retour à mes commandes</a>
</p>
</div>
@endsection
