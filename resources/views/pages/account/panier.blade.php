@extends('layouts.account')

@push('head')
<link href="{{ asset('assets/css/shop/kiel-shop.css') }}" rel="stylesheet"/>
@endpush

@section('heroTitle', 'Votre panier')
@section('heroLead', 'Produits KIEL INDUSTRIES : vérifiez votre sélection avant le paiement.')
@section('heroCurrent', 'Panier')

@section('panel')
<div id="kiel-panier-root" class="mt-2"><p class="text-center text-on-surface-variant">Chargement du panier…</p></div>
@endsection
