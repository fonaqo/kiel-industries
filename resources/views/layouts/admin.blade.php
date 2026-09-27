@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/account/kiel-account.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.12/dist/turbo.es2017-umd.js" defer></script>
<script src="{{ asset('assets/js/account/kiel-account.js') }}" defer></script>
<script src="{{ asset('assets/js/shop/kiel-wishlist-page.js') }}" defer></script>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface kiel-admin-app">
<section class="kiel-section kiel-section--content">
<div class="kiel-wrap kiel-admin-layout">
@include('pages.admin.partials.nav')
<div class="kiel-admin-main">
<turbo-frame id="admin-main">
@include('layouts.partials.account-area-page-head', [
  'heroTitle' => trim($__env->yieldContent('heroTitle')),
  'heroLead' => trim($__env->yieldContent('heroLead')),
  'heroCurrent' => trim($__env->yieldContent('heroCurrent')),
  'useSubhero' => request()->routeIs('admin.dashboard'),
  'showBreadcrumb' => true,
])
@yield('panel')
</turbo-frame>
</div>
</div>
</section>
</main>
@endsection
