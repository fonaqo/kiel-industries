<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@include('layouts.partials.seo')
<link rel="icon" type="image/png" href="{{ asset('assets/img/brand/favicon.png') }}"/>
<link rel="apple-touch-icon" href="{{ asset('assets/img/brand/favicon.png') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link rel="preload" href="{{ asset('assets/img/brand/logo-kiel.svg') }}" as="image" type="image/svg+xml"/>
<link href="{{ asset('assets/css/core/kiel-loader.css') }}" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-site-styles.css') }}" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>
<script src="{{ asset('assets/js/core/kiel-tailwind-config.js') }}"></script>
<link href="{{ asset('assets/css/pages/kiel-pages.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-theme-wine.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-brand.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-icons.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/shop/kiel-shop.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-pagination.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-mobile.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-filigrane-laptop.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-layout.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-logos.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-scrollbar.css') }}" rel="stylesheet"/>
@if(($page ?? '') === 'accueil')
<link href="{{ asset('assets/css/core/kiel-hero-orbit-logo.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-baobab-hub-title.css') }}" rel="stylesheet"/>
<style>@layer base{html,body{margin:0;padding:0;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}h1,h2{font-family:"Playfair Display",serif;font-weight:700;letter-spacing:-0.02em;}#hero-section h1{color:inherit;}}</style>
@endif
@include('layouts.partials.cms-integrations-head')
