<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@include('layouts.partials.seo')
<link rel="icon" type="image/png" href="{{ asset('assets/img/brand/favicon.png') }}"/>
<link rel="apple-touch-icon" href="{{ asset('assets/img/brand/favicon.png') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link rel="preconnect" href="https://cdn.tailwindcss.com" crossorigin/>
<link rel="preload" href="{{ asset('assets/img/brand/logo-kiel.svg') }}" as="image" type="image/svg+xml"/>
<link href="{{ asset('assets/css/core/kiel-loader.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-site-styles.css') }}" rel="stylesheet"/>
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" as="style"/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'"/>
<noscript><link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet"/></noscript>
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" as="style"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet" media="print" onload="this.media='all'"/>
<noscript><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet"/></noscript>
<link href="{{ asset('assets/css/pages/kiel-pages.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-theme-wine.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-brand.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-icons.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/shop/kiel-shop.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-pagination.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-mobile.css') }}" rel="stylesheet"/>
@if(in_array($page ?? '', ['accueil', 'a-propos'], true))
<link href="{{ asset('assets/css/core/kiel-filigrane-laptop.css') }}" rel="stylesheet"/>
@endif
<link href="{{ asset('assets/css/core/kiel-layout.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-logos.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-scrollbar.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-responsive.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-mobile-nav.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-header-nav-compact.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-header-mobile-tablet.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-mobile-global.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-perf.css') }}" rel="stylesheet"/>
@if(($page ?? '') === 'accueil')
<link href="{{ asset('assets/css/core/kiel-hero-orbit-logo.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-baobab-hub-title.css') }}" rel="stylesheet"/>
<style>@layer base{html,body{margin:0;padding:0;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}h1,h2{font-family:"Playfair Display",serif;font-weight:700;letter-spacing:-0.02em;}#hero-section h1{color:inherit;}}</style>
@endif
@include('layouts.partials.cms-integrations-head')
