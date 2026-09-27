@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/account/kiel-account.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/account/kiel-admin-orders.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/account/kiel-account-orders.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.12/dist/turbo.es2017-umd.js" defer></script>
<script src="{{ asset('assets/js/account/kiel-account.js') }}" defer></script>
<script src="{{ asset('assets/js/shop/kiel-wishlist-page.js') }}" defer></script>
@endpush

@section('content')
@auth
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface kiel-account-app">
<section class="kiel-section">
<div class="kiel-wrap kiel-account-layout">
@include('pages.account.partials.nav')
<div class="kiel-account-main">
<turbo-frame id="account-main">
@include('layouts.partials.account-area-page-head', [
  'heroTitle' => trim($__env->yieldContent('heroTitle')),
  'heroLead' => trim($__env->yieldContent('heroLead')),
  'heroCurrent' => trim($__env->yieldContent('heroCurrent')),
  'useSubhero' => request()->routeIs('account.dashboard'),
  'showBreadcrumb' => true,
])
@yield('panel')
</turbo-frame>
</div>
</div>
</section>
</main>
@else
<script>window.location.replace(@json(route('login')));</script>
@endauth
@endsection
