@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-actualites.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface kiel-actu-page">

@include('layouts.partials.page-subhero', [
  'heroTitle' => 'Chroniques du Borgou et de la boutique',
  'heroLead' => 'Récoltes, innovation OAPI, impact social et nouveautés en ligne : la vie de KIEL INDUSTRIES.',
  'heroCurrent' => 'Actualités',
])

<section class="kiel-actu-section">
<div class="kiel-wrap">

<div class="kiel-actu-intro">
@include('partials.kiel-section-eyebrow', ['label' => 'Actualités KIEL', 'centered' => true])
<p class="kiel-actu-intro__lead">Filière baobab, boutique, coopératives et innovation : retrouvez nos dernières nouvelles depuis Parakou.</p>
</div>

@if($featuredPost)
<a class="kiel-actu-featured" href="{{ route('actualites.show', $featuredPost) }}">
<div class="kiel-actu-featured__media">
<span class="kiel-actu-featured__badge">À la une</span>
<img alt="" loading="eager" src="{{ $featuredPost->resolved_image_url ?? asset('assets/img/brand/logo-kiel.svg') }}"/>
</div>
<div class="kiel-actu-featured__body">
<p class="kiel-actu-featured__meta">
<time datetime="{{ $featuredPost->published_at->format('Y-m-d') }}">{{ $featuredPost->published_at->translatedFormat('d F Y') }}</time>
<span aria-hidden="true">·</span>
<span>{{ $featuredPost->category }}</span>
</p>
<h2 class="kiel-actu-featured__title">{{ $featuredPost->title }}</h2>
<p class="kiel-actu-featured__excerpt">{{ $featuredPost->excerpt }}</p>
<span class="kiel-actu-featured__cta">Lire l’article <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span></span>
</div>
</a>
@endif

@if($posts->count() > 0 || ! $featuredPost)
<div class="kiel-actu-grid-head">
<h2>Toutes les chroniques</h2>
@if($posts->total() > 0)
<span>{{ $posts->total() }} article{{ $posts->total() > 1 ? 's' : '' }}</span>
@endif
</div>
@endif

<div class="kiel-actu-grid">
@forelse($posts as $post)
<a class="kiel-actu-card" href="{{ route('actualites.show', $post) }}">
<div class="kiel-actu-card__media">
<img alt="" loading="lazy" src="{{ $post->resolved_image_url ?? asset('assets/img/sections/about/about-1.jpg') }}"/>
</div>
<div class="kiel-actu-card__body">
<p class="kiel-actu-card__meta">{{ $post->published_at->translatedFormat('M Y') }} · {{ $post->category }}</p>
<h3 class="kiel-actu-card__title">{{ $post->title }}</h3>
<p class="kiel-actu-card__excerpt">{{ $post->excerpt }}</p>
<span class="kiel-actu-card__more">Lire la suite <span class="material-symbols-outlined">arrow_forward</span></span>
</div>
</a>
@empty
@if(! $featuredPost)
<div class="kiel-actu-empty">
<p>Aucune actualité publiée pour le moment.</p>
<a class="kiel-btn kiel-btn--primary" href="{{ route('boutique') }}" style="margin-top:1rem;display:inline-flex">Découvrir la boutique</a>
</div>
@endif
@endforelse
</div>

@if($posts->hasPages())
<div class="kiel-actu-pagination">{{ $posts->links() }}</div>
@endif

</div>
</section>
</main>
@endsection
