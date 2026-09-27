<!DOCTYPE html>
<html lang="fr">
<head>
@include('layouts.partials.head')
@stack('head')
</head>
<body class="bg-surface font-body-md text-on-surface antialiased @yield('body-class')" data-page="{{ $page ?? 'accueil' }}" data-panier-url="{{ route('panier') }}" data-cart-add-url="{{ route('cart.add') }}" data-cart-sync-url="{{ route('cart.sync') }}" data-cart-url="{{ route('cart.show') }}" data-commande-url="{{ route('commande') }}" data-boutique-url="{{ route('boutique') }}" data-currency-rates="{{ json_encode(config('kiel.currency')) }}" @auth data-wishlist-auth="1" data-wishlist-items-url="{{ route('wishlist.items') }}" data-wishlist-sync-url="{{ route('wishlist.sync') }}" data-wishlist-toggle-url="{{ route('wishlist.toggle') }}" @endauth>
@include('layouts.partials.cms-integrations-body')
@include('layouts.partials.kiel-page-loader')
@include('layouts.partials.site-header')
@yield('content')
@php
  $showJoinCta = ! in_array($page ?? '', ['accueil', 'boutique', 'compte', 'admin', 'connexion', 'inscription', 'contact', 'actualites', 'nos-astuces', 'nos-documents', 'expertises'], true)
    && ! request()->routeIs('account.*', 'admin.*');
@endphp
@if($showJoinCta)
@include('layouts.partials.kiel-join-cta')
@endif
@include('layouts.partials.site-footer')
@include('layouts.partials.site-drawers')
@include('layouts.partials.cart-toast')
@include('layouts.partials.scripts')
@stack('scripts')
</body>
</html>
