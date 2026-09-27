@extends('layouts.admin')

@section('heroTitle', 'Mes favoris')
@section('heroLead', 'Les mêmes favoris que sur la boutique et dans votre espace client.')
@section('heroCurrent', 'Favoris')

@section('panel')
@include('pages.account.partials.wishlist-panel')
@endsection

@push('scripts')
<script src="{{ asset('assets/js/shop/kiel-wishlist-page.js') }}" defer></script>
@endpush

@push('head')
<meta name="turbo-cache-control" content="no-cache"/>
@endpush
