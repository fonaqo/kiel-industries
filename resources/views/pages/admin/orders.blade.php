@extends('layouts.admin')

@push('head')
<link href="{{ asset('assets/css/account/kiel-admin-orders.css') }}" rel="stylesheet"/>
@endpush

@section('heroTitle', 'Commandes')
@section('heroLead', 'Suivi des commandes boutique KIEL INDUSTRIES.')
@section('heroCurrent', 'Admin · Commandes')

@section('panel')
<div class="mt-2">
@if($orders->isEmpty())
@include('pages.account.partials.empty-state', ['message' => 'Aucune commande à afficher.'])
@else
@include('pages.account.partials.orders-table', ['orders' => $orders, 'variant' => 'admin'])
<div class="kiel-account-orders-pagination">{{ $orders->links() }}</div>
@endif
</div>
@endsection
