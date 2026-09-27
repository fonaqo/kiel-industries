@extends('layouts.account')

@section('heroTitle', 'Mon espace client')
@section('heroLead')
Bonjour {{ auth()->user()->display_name }}, suivez vos commandes et votre activité KIEL INDUSTRIES.
@endsection
@section('heroCurrent', 'Mon compte')

@section('panel')
<div class="mt-2 kiel-account-dashboard">
<div class="kiel-account-dashboard__stats">
<div class="kiel-account-stat">
<span>Commandes</span>
<strong>{{ $ordersTotal }}</strong>
</div>
<div class="kiel-account-stat kiel-account-stat--accent">
<span>Favoris</span>
<strong id="kiel-account-wishlist-count">{{ $wishlistCount ?? 0 }}</strong>
</div>
<div class="kiel-account-stat">
<span>Boutique</span>
<a href="{{ route('boutique') }}">Continuer mes achats</a>
</div>
</div>

<h2 class="kiel-account-dashboard__title">
<span>Dernières commandes</span>
@if($ordersTotal > 0)
<a class="kiel-account-dashboard__title-link" href="{{ route('account.orders') }}" data-turbo-frame="account-main">Tout voir</a>
@endif
</h2>
@if($orders->isEmpty())
@include('pages.account.partials.empty-state', [
  'message' => 'Aucune commande pour le moment.',
  'ctaUrl' => route('boutique'),
  'ctaLabel' => 'Commander en ligne',
])
@else
@include('pages.account.partials.orders-table', ['orders' => $orders])
@if($ordersTotal > $orders->count())
<p class="kiel-account-dashboard__more">
<a href="{{ route('account.orders') }}" data-turbo-frame="account-main">Voir toutes mes commandes ({{ $ordersTotal }})</a>
</p>
@endif
@endif
</div>
@endsection
