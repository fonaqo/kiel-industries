@extends('layouts.account')

@section('heroTitle', 'Mes commandes')
@section('heroLead', 'Historique complet de vos achats KIEL INDUSTRIES.')
@section('heroCurrent', 'Commandes')

@section('panel')
<div class="mt-2">
@if($orders->isEmpty())
@include('pages.account.partials.empty-state', [
  'message' => 'Vous n’avez pas encore passé de commande.',
  'ctaUrl' => route('boutique'),
  'ctaLabel' => 'Découvrir la boutique',
])
@else
@include('pages.account.partials.orders-table', ['orders' => $orders])
<div class="kiel-account-orders-pagination">{{ $orders->links() }}</div>
@endif
</div>
@endsection
