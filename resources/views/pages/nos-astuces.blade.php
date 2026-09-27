@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-astuces.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pages/kiel-documents.css') }}" rel="stylesheet"/>
@endpush

@section('content')
@php
  $active = $featuredVideo;
  $videoCount = $videos->count();
@endphp
<main class="w-full pt-[118px] sm:pt-[122px] kiel-astuces-page">

<section class="kiel-astuces-hero" aria-labelledby="kiel-astuces-hero-title">
<div class="kiel-wrap kiel-astuces-hero__inner">
<div class="kiel-astuces-hero__copy">
<div class="kiel-astuces-hero__eyebrow">
<span class="material-symbols-outlined">play_circle</span>
<span>Studio vidéo KIEL</span>
</div>
<h1 id="kiel-astuces-hero-title" class="kiel-astuces-hero__title">Nos astuces baobab</h1>
<p class="kiel-astuces-hero__lead">Recettes, filière, soins et coulisses de KIEL INDUSTRIES. Une expérience proche de YouTube, pensée pour mobile et grand écran.</p>
@if($videoCount > 0)
<p class="kiel-astuces-hero__stat"><strong>{{ $videoCount }}</strong> vidéo{{ $videoCount > 1 ? 's' : '' }} · Borgou &amp; Parakou</p>
@endif
</div>
<div class="kiel-astuces-hero__badge" aria-hidden="true">
@include('partials.kiel-logo-filigrane', ['variant' => 'hero', 'class' => 'kiel-logo--hero'])
</div>
</div>
</section>

<section class="kiel-section kiel-astuces-section">
<div class="kiel-wrap">
<div class="kiel-astuces-toolbar">
<form class="kiel-astuces-search" method="get" action="{{ route('nos-astuces') }}">
@if($activeCategory ?? null)<input type="hidden" name="cat" value="{{ $activeCategory }}"/>@endif
<label class="sr-only" for="kiel-astuces-q">Rechercher une astuce</label>
<input id="kiel-astuces-q" type="search" name="q" value="{{ $searchQuery ?? '' }}" placeholder="Rechercher par titre ou description…" maxlength="120" autocomplete="off"/>
<button type="submit" class="kiel-astuces-search__btn" aria-label="Rechercher"><span class="material-symbols-outlined">search</span></button>
</form>
@if(! empty($categories))
<nav class="kiel-astuces-cats" aria-label="Catégories de vidéos">
@php
  $catQuery = collect(['q' => $searchQuery ?? null])->filter()->all();
@endphp
<a href="{{ route('nos-astuces', $catQuery) }}" @class(['is-active' => ! ($activeCategory ?? null)])>Toutes</a>
@foreach($categories as $key => $label)
<a href="{{ route('nos-astuces', array_merge($catQuery, ['cat' => $key])) }}" @class(['is-active' => ($activeCategory ?? null) === $key])>{{ $label }}</a>
@endforeach
</nav>
@endif
</div>
@if($videos->isEmpty())
<p class="kiel-astuces-empty">Les vidéos seront bientôt disponibles. Revenez prochainement ou suivez-nous sur nos réseaux.</p>
@else
<div class="kiel-astuces-studio">
<div class="kiel-astuces-theater" data-kiel-astuces-player>
@if($active)
<div class="kiel-astuces-theater__screen">
<div class="kiel-astuces-player__frame">
<iframe
  title="{{ $active->title }}"
  src="{{ $active->embedUrl() }}"
  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
  allowfullscreen
  loading="lazy"
  data-kiel-astuces-iframe
></iframe>
</div>
</div>
<div class="kiel-astuces-theater__meta">
<div class="kiel-astuces-theater__head">
<h2 class="kiel-astuces-player__title" data-kiel-astuces-title>{{ $active->title }}</h2>
<a class="kiel-astuces-theater__yt" href="{{ $active->watchUrl() }}" target="_blank" rel="noopener noreferrer" data-kiel-astuces-yt>
<span class="material-symbols-outlined">smart_display</span> YouTube
</a>
</div>
@if($active->description)
<p class="kiel-astuces-player__desc" data-kiel-astuces-desc>{{ $active->description }}</p>
@else
<p class="kiel-astuces-player__desc" data-kiel-astuces-desc hidden></p>
@endif
</div>
@endif
</div>

<aside class="kiel-astuces-queue" aria-label="File de lecture">
<div class="kiel-astuces-queue__head">
<h2 class="kiel-astuces-queue__title">À la suite</h2>
<span class="kiel-astuces-queue__count">{{ $videoCount }}</span>
</div>
<ul class="kiel-astuces-list">
@foreach($videos as $video)
<li>
<button
  type="button"
  class="kiel-astuces-card @if($active && $active->id === $video->id) is-active @endif"
  data-kiel-astuces-pick
  data-youtube-id="{{ $video->youtube_id }}"
  data-title="{{ e($video->title) }}"
  data-desc="{{ e($video->description ?? '') }}"
  data-watch="{{ $video->watchUrl() }}"
  data-slug="{{ $video->slug }}"
>
<span class="kiel-astuces-card__thumb">
<img alt="" loading="lazy" src="{{ $video->thumbnailUrl() }}"/>
<span class="kiel-astuces-card__play material-symbols-outlined" aria-hidden="true">play_arrow</span>
@if($dur = $video->formattedDuration())<span class="kiel-astuces-card__dur">{{ $dur }}</span>@endif
</span>
<span class="kiel-astuces-card__body">
<span class="kiel-astuces-card__cat">{{ $video->categoryLabel() }}</span>
<span class="kiel-astuces-card__name">{{ $video->title }}</span>
@if($video->description)
<span class="kiel-astuces-card__excerpt">{{ Str::limit($video->description, 80) }}</span>
@endif
</span>
</button>
</li>
@endforeach
</ul>
</aside>
</div>

<div class="kiel-astuces-playlist">
<div class="kiel-astuces-playlist__head">
<h2 class="kiel-astuces-playlist__title">Explorer toute la playlist</h2>
<p class="kiel-astuces-playlist__lead">Astuces nutrition, cosmétique, filière et impact. Sélection KIEL INDUSTRIES.</p>
</div>
<div class="kiel-astuces-grid">
@foreach($videos as $video)
<button
  type="button"
  class="kiel-astuces-tile @if($active && $active->id === $video->id) is-active @endif"
  data-kiel-astuces-pick
  data-youtube-id="{{ $video->youtube_id }}"
  data-title="{{ e($video->title) }}"
  data-desc="{{ e($video->description ?? '') }}"
  data-watch="{{ $video->watchUrl() }}"
  data-slug="{{ $video->slug }}"
>
<span class="kiel-astuces-tile__media">
<img alt="" loading="lazy" src="{{ $video->thumbnailUrl('mqdefault') }}"/>
@if($dur = $video->formattedDuration())<span class="kiel-astuces-tile__dur">{{ $dur }}</span>@endif
</span>
<span class="kiel-astuces-tile__body">
<span class="kiel-astuces-card__cat">{{ $video->categoryLabel() }}</span>
<span class="kiel-astuces-tile__name">{{ $video->title }}</span>
@if($video->description)
<span class="kiel-astuces-tile__excerpt">{{ Str::limit($video->description, 96) }}</span>
@endif
</span>
</button>
@endforeach
</div>
</div>
@endif
</div>
</section>
</main>
@endsection

@push('scripts')
<script>
(function () {
  const root = document.querySelector('[data-kiel-astuces-player]');
  if (!root) return;
  const iframe = root.querySelector('[data-kiel-astuces-iframe]');
  const titleEl = root.querySelector('[data-kiel-astuces-title]');
  const descEl = root.querySelector('[data-kiel-astuces-desc]');
  const ytEl = root.querySelector('[data-kiel-astuces-yt]');
  const base = window.location.pathname;

  const pickVideo = (btn) => {
    const id = btn.getAttribute('data-youtube-id');
    if (!id || !iframe) return;
    iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1';
    if (titleEl) titleEl.textContent = btn.getAttribute('data-title') || '';
    const desc = btn.getAttribute('data-desc') || '';
    if (descEl) {
      descEl.textContent = desc;
      descEl.hidden = desc === '';
    }
    if (ytEl) ytEl.href = btn.getAttribute('data-watch') || '#';
    document.querySelectorAll('[data-kiel-astuces-pick]').forEach((b) => b.classList.toggle('is-active', b === btn));
    const slug = btn.getAttribute('data-slug');
    if (slug && window.history && window.history.replaceState) {
      window.history.replaceState(null, '', base + '?v=' + encodeURIComponent(slug));
    }
    root.scrollIntoView({ behavior: 'smooth', block: 'start' });
  };

  document.querySelectorAll('[data-kiel-astuces-pick]').forEach((btn) => {
    btn.addEventListener('click', () => pickVideo(btn));
  });
})();
</script>
@endpush
