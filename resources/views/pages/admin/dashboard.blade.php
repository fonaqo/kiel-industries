@extends('layouts.admin')

@push('head')
<link href="{{ asset('assets/css/account/kiel-admin-orders.css') }}" rel="stylesheet"/>
@endpush

@section('heroTitle', 'Administration KIEL')
@section('heroLead', 'Vue d’ensemble boutique, commandes et comptes clients.')
@section('heroCurrent', 'Admin')

@section('panel')
<div class="grid sm:grid-cols-3 gap-4 mb-8 mt-2">
<div class="kiel-admin-stat"><span>Commandes</span><strong>{{ $ordersCount }}</strong></div>
<div class="kiel-admin-stat"><span>Produits</span><strong>{{ $productsCount }}</strong></div>
<div class="kiel-admin-stat"><span>Utilisateurs</span><strong>{{ $usersCount }}</strong></div>
</div>
<h2 class="kiel-account-dashboard__title">Dernières commandes</h2>
@if($recentOrders->isEmpty())
@include('pages.account.partials.empty-state', ['message' => 'Aucune commande enregistrée pour le moment.'])
@else
@include('pages.account.partials.orders-table', ['orders' => $recentOrders, 'variant' => 'admin'])
<p class="kiel-account-dashboard__more">
<a href="{{ route('admin.orders') }}" data-turbo-frame="admin-main">Voir toutes les commandes</a>
</p>
@endif
@endsection
