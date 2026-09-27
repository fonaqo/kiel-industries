@extends('layouts.cms-admin')

@section('panel')
<div class="kiel-cms-home">
<section class="kiel-cms-home__welcome">
<div class="kiel-cms-home__welcome-text">
<p class="kiel-cms-home__date">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
<h2 class="kiel-cms-home__hello">Bonjour, {{ auth()->user()->display_name }}</h2>
<p class="kiel-cms-home__lead">Gérez la boutique, le contenu et les paramètres du site KIEL en quelques clics.</p>
</div>
<div class="kiel-cms-home__welcome-actions">
@if($pendingOrders > 0)
<a class="kiel-cms-home__alert" href="{{ route('admin.orders') }}">
<span class="material-symbols-outlined" aria-hidden="true">notifications_active</span>
{{ $pendingOrders }} commande{{ $pendingOrders > 1 ? 's' : '' }} à traiter
</a>
@endif
<a class="kiel-cms-btn kiel-cms-btn--primary" href="{{ route('admin.cms.products.create') }}">
<span class="material-symbols-outlined" aria-hidden="true">add</span>
Créer un produit
</a>
</div>
</section>

<div class="kiel-cms-home__stats">
@foreach($statCards as $card)
<a href="{{ $card['href'] }}" class="kiel-cms-stat-card kiel-cms-stat-card--{{ $card['tone'] }}">
<span class="kiel-cms-stat-card__icon material-symbols-outlined" aria-hidden="true">{{ $card['icon'] }}</span>
<span class="kiel-cms-stat-card__value">{{ $card['value'] }}</span>
<span class="kiel-cms-stat-card__label">{{ $card['label'] }}</span>
<span class="kiel-cms-stat-card__hint">{{ $card['hint'] }}</span>
</a>
@endforeach
</div>

<div class="kiel-cms-home__grid">
<section class="kiel-cms-surface kiel-cms-surface--flush">
<header class="kiel-cms-surface__head">
<div>
<h2 class="kiel-cms-surface__title">Activité récente</h2>
<p class="kiel-cms-surface__sub">Dernières commandes clients</p>
</div>
<a class="kiel-cms-surface__link" href="{{ route('admin.orders') }}">Voir toutes</a>
</header>
@if($recentOrders->isEmpty())
<div class="kiel-cms-empty">
<span class="material-symbols-outlined" aria-hidden="true">inbox</span>
<p>Aucune commande pour le moment.</p>
<a class="kiel-cms-btn kiel-cms-btn--soft" href="{{ route('boutique') }}" target="_blank" rel="noopener">Ouvrir la boutique</a>
</div>
@else
<ul class="kiel-cms-order-feed">
@foreach($recentOrders as $order)
<li>
<a class="kiel-cms-order-feed__row" href="{{ route('admin.orders.show', $order) }}">
<span class="kiel-cms-order-feed__main">
<strong>{{ $order->reference }}</strong>
<span>{{ $order->customer_name }}</span>
</span>
<span class="kiel-cms-order-feed__side">
@include('partials.order-status', ['status' => $order->status])
<span class="kiel-cms-order-feed__amount">{{ number_format($order->total_fcfa, 0, ',', ' ') }} FCFA</span>
</span>
<span class="material-symbols-outlined kiel-cms-order-feed__chev" aria-hidden="true">chevron_right</span>
</a>
</li>
@endforeach
</ul>
@endif
</section>

<section class="kiel-cms-surface">
<h2 class="kiel-cms-surface__title">Actions fréquentes</h2>
<p class="kiel-cms-surface__sub kiel-cms-surface__sub--spaced">Raccourcis vers les tâches du quotidien</p>
<div class="kiel-cms-quick-grid">
@foreach($quickActions as $action)
<a class="kiel-cms-quick-tile" href="{{ $action['href'] }}">
<span class="kiel-cms-quick-tile__icon material-symbols-outlined" aria-hidden="true">{{ $action['icon'] }}</span>
<span class="kiel-cms-quick-tile__text">
<strong>{{ $action['title'] }}</strong>
<span>{{ $action['desc'] }}</span>
</span>
<span class="material-symbols-outlined kiel-cms-quick-tile__arrow" aria-hidden="true">arrow_forward</span>
</a>
@endforeach
</div>
</section>
</div>
</div>
@endsection
