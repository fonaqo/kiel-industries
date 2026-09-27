@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/shop/kiel-shop.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface min-h-screen">

@include('layouts.partials.page-subhero', [
  'heroTitle' => 'Votre panier',
  'heroLead' => 'Produits KIEL INDUSTRIES : vérifiez votre sélection avant le paiement.',
  'heroCurrent' => 'Panier',
])

<section class="kiel-section">
<div class="kiel-wrap">
<div id="kiel-panier-root"><p class="text-center text-on-surface-variant">Chargement du panier…</p></div>
</div>
</section>
</main>
@endsection
