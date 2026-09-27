@php
  $seoMeta = (is_array($seo ?? null) && isset($seo['title'])) ? $seo : app(\App\Support\SeoResolver::class)->resolve([]);
@endphp
<title>{{ $seoMeta['title'] ?? 'KIEL INDUSTRIES' }}</title>
<meta name="description" content="{{ $seoMeta['description'] ?? '' }}"/>
@if(! empty($seoMeta['keywords']))
<meta name="keywords" content="{{ $seoMeta['keywords'] }}"/>
@endif
<meta name="robots" content="{{ $seoMeta['robots'] ?? 'index,follow' }}"/>
<meta name="author" content="KIEL INDUSTRIES"/>
<meta name="publisher" content="KIEL INDUSTRIES"/>
<link rel="canonical" href="{{ $seoMeta['canonical'] ?? url('/') }}"/>
<link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap') }}"/>
<link rel="alternate" hreflang="fr-bj" href="{{ $seoMeta['canonical'] ?? url('/') }}"/>
<link rel="alternate" hreflang="fr" href="{{ $seoMeta['canonical'] ?? url('/') }}"/>
<link rel="alternate" hreflang="x-default" href="{{ $seoMeta['canonical'] ?? url('/') }}"/>
@if(! empty($seoMeta['geo']['country_code']))
<meta name="geo.country" content="{{ $seoMeta['geo']['country_code'] }}"/>
@endif
@if(! empty($seoMeta['geo']['region']))
<meta name="geo.region" content="{{ $seoMeta['geo']['region'] }}"/>
@endif
@if(! empty($seoMeta['geo']['country_name']))
<meta name="geo.countryname" content="{{ $seoMeta['geo']['country_name'] }}"/>
@endif
@if(! empty($seoMeta['geo']['city']))
<meta name="geo.placename" content="{{ $seoMeta['geo']['city'] }}, {{ $seoMeta['geo']['region_name'] ?? 'Borgou' }}, Bénin"/>
@endif
@if(! empty($seoMeta['geo']['latitude']) && ! empty($seoMeta['geo']['longitude']))
<meta name="geo.position" content="{{ $seoMeta['geo']['latitude'] }};{{ $seoMeta['geo']['longitude'] }}"/>
<meta name="ICBM" content="{{ $seoMeta['geo']['latitude'] }}, {{ $seoMeta['geo']['longitude'] }}"/>
@endif
<meta property="og:locale" content="{{ $seoMeta['locale'] ?? 'fr_BJ' }}"/>
<meta property="og:type" content="{{ ($seoMeta['og_type'] ?? 'website') === 'product' ? 'product' : (($seoMeta['og_type'] ?? '') === 'article' ? 'article' : 'website') }}"/>
<meta property="og:site_name" content="{{ $seoMeta['site_name'] ?? 'KIEL INDUSTRIES' }}"/>
<meta property="og:title" content="{{ $seoMeta['title'] ?? 'KIEL INDUSTRIES' }}"/>
<meta property="og:description" content="{{ $seoMeta['description'] ?? '' }}"/>
<meta property="og:url" content="{{ $seoMeta['canonical'] ?? url('/') }}"/>
@php
  $ogImage = $seoMeta['image'] ?? asset('assets/img/brand/logo-kiel.svg');
@endphp
<meta property="og:image" content="{{ $ogImage }}"/>
<meta property="og:image:secure_url" content="{{ $ogImage }}"/>
<meta property="og:image:alt" content="{{ $seoMeta['site_name'] ?? 'KIEL INDUSTRIES' }} — Parakou, Borgou, Bénin"/>
@if(! empty($seoMeta['og_image_width']))
<meta property="og:image:width" content="{{ $seoMeta['og_image_width'] }}"/>
@endif
@if(! empty($seoMeta['og_image_height']))
<meta property="og:image:height" content="{{ $seoMeta['og_image_height'] }}"/>
@endif
<meta name="twitter:card" content="{{ $seoMeta['twitter_card'] ?? 'summary_large_image' }}"/>
<meta name="twitter:title" content="{{ $seoMeta['title'] ?? 'KIEL INDUSTRIES' }}"/>
<meta name="twitter:description" content="{{ $seoMeta['description'] ?? '' }}"/>
<meta name="twitter:image" content="{{ $seoMeta['image'] ?? asset('assets/img/brand/logo-kiel.svg') }}"/>
<meta name="application-name" content="{{ $seoMeta['site_name'] ?? 'KIEL INDUSTRIES' }}"/>
<meta name="apple-mobile-web-app-title" content="KIEL"/>
<meta name="theme-color" content="#2c000a"/>
@foreach($seoMeta['json_ld'] ?? [] as $graph)
<script type="application/ld+json">@json($graph)</script>
@endforeach
