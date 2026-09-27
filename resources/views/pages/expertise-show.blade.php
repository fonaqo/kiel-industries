@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-expertises.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface">

@include('layouts.partials.page-subhero', [
  'heroTitle' => $pole['title'],
  'heroLead' => $pole['intro'],
  'heroCurrent' => 'Expertises',
])

<section class="kiel-section kiel-section--content">
<div class="kiel-wrap">
<div class="kiel-subpage-frame">
<p class="kiel-expertise-pole__tag">{{ $pole['tag'] }}</p>
<div class="kiel-expertise-pole__hero">
<img alt="" loading="lazy" src="{{ asset($pole['image']) }}"/>
</div>
<div class="kiel-expertise-pole__body font-body-md text-on-surface-variant leading-relaxed space-y-4">
@foreach($pole['paragraphs'] as $paragraph)
<p>{{ $paragraph }}</p>
@endforeach
</div>
</div>
</div>
</section>

@if(! empty($pole['highlights']))
<section class="kiel-expertise-pole-section kiel-expertise-pole-section--muted">
<div class="kiel-wrap">
<h2 class="kiel-expertise-pole-section__title">Points clés</h2>
<div class="kiel-expertise-highlights">
@foreach($pole['highlights'] as $item)
<article class="kiel-expertise-highlight">
<span class="kiel-expertise-highlight__icon material-symbols-outlined" aria-hidden="true">{{ $item['icon'] }}</span>
<h3>{{ $item['title'] }}</h3>
<p>{{ $item['text'] }}</p>
</article>
@endforeach
</div>
</div>
</section>
@endif

<section class="kiel-expertise-pole-section">
<div class="kiel-wrap">
<div class="kiel-expertise-split">
<div class="kiel-expertise-split__content">
<h2 class="kiel-expertise-pole-section__title">Notre engagement au Borgou</h2>
<p class="text-on-surface-variant leading-relaxed">Depuis Parakou, KIEL INDUSTRIES relie productrices, ateliers de transformation et clients en Bénin et à l’international. Chaque expertise s’inscrit dans une filière baobab intégrée, transparente et orientée impact.</p>
<ul class="kiel-expertise-checklist">
<li><span class="material-symbols-outlined">check_circle</span> Chaîne locale maîtrisée</li>
<li><span class="material-symbols-outlined">check_circle</span> Innovation et qualité OAPI</li>
<li><span class="material-symbols-outlined">check_circle</span> Boutique en ligne &amp; partenariats B2B</li>
</ul>
</div>
<div class="kiel-expertise-split__stats">
<div class="kiel-expertise-stat"><strong>500+</strong><span>Productrices associées</span></div>
<div class="kiel-expertise-stat"><strong>4</strong><span>Domaines d’intervention</span></div>
<div class="kiel-expertise-stat"><strong>0</strong><span>Déchet filière baobab</span></div>
</div>
</div>
</div>
</section>

@if(! empty($otherPoles))
<section class="kiel-expertise-pole-section kiel-expertise-pole-section--muted">
<div class="kiel-wrap">
<h2 class="kiel-expertise-pole-section__title">Explorer d’autres expertises</h2>
<div class="kiel-expertise-related">
@foreach($otherPoles as $related)
<a class="kiel-expertise-related__card" href="{{ route('expertises.show', $related['slug']) }}">
<img alt="" loading="lazy" src="{{ asset($related['image']) }}"/>
<div>
<p class="kiel-expertise-related__tag">{{ $related['tag'] }}</p>
<h3>{{ $related['title'] }}</h3>
<span class="kiel-expertise-related__link">En savoir plus <span class="material-symbols-outlined">arrow_forward</span></span>
</div>
</a>
@endforeach
</div>
<p class="kiel-expertise-related__all"><a href="{{ route('expertises') }}">Voir toutes les expertises</a></p>
</div>
</section>
@endif

<section class="kiel-section kiel-section--content">
<div class="kiel-wrap">
<div class="kiel-expertise-pole-cta">
<div class="flex flex-wrap gap-3">
@if(! empty($pole['boutique_category']))
<a class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-secondary text-on-secondary font-label-md uppercase tracking-wider" href="{{ route('boutique', ['categorie' => $pole['boutique_category']]) }}">Produits associés</a>
@endif
<a class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full border-2 border-primary text-primary font-label-md uppercase tracking-wider" href="{{ route('expertises') }}">Toutes les expertises</a>
<a class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-primary text-on-primary font-label-md uppercase tracking-wider" href="{{ route('contact') }}">Nous contacter</a>
</div>
</div>
</div>
</section>
</main>
@endsection
