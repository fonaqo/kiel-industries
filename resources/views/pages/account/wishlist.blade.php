@extends('layouts.account')

@section('heroTitle', 'Mes favoris')
@section('heroLead', 'Retrouvez les produits que vous avez enregistrés.')
@section('heroCurrent', 'Favoris')

@section('panel')
@include('pages.account.partials.wishlist-panel')
@endsection

@push('scripts')
<script src="{{ asset('assets/js/shop/kiel-wishlist-page.js') }}" defer></script>
@endpush
