@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-expertises.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface">

@include('layouts.partials.page-subhero', [
  'heroTitle' => 'Quatre domaines d’intervention',
  'heroLead' => 'Valorisation du baobab (marque KIEL), conseil nutritionnel, gestion de projets et mentorat, depuis Parakou au service du Borgou.',
  'heroCurrent' => 'Expertises',
])

<section class="kiel-section kiel-section--cream">
<div class="kiel-wrap">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'Nos expertises · Parakou',
  'title' => 'Ce que fait KIEL INDUSTRIES',
  'lead' => 'Une entreprise béninoise qui restaure les paysages par le baobab et en assure la valorisation intégrale en économie circulaire.',
  'class' => 'kiel-expertises-list-head',
])
<div class="kiel-expertise-hero-grid">
@foreach($poles as $pole)
<a class="kiel-expertise-card" href="{{ route('expertises.show', $pole['slug']) }}">
<img alt="" src="{{ asset($pole['image']) }}"/>
<div class="kiel-expertise-card__shade"></div>
<div class="kiel-expertise-card__body">
<span class="kiel-expertise-card__tag">{{ $pole['tag'] }}</span>
<h3>{{ $pole['title'] }}</h3>
<p>{{ $pole['intro'] }}</p>
<span class="kiel-expertise-card__link">En savoir plus <span class="material-symbols-outlined text-[14px]">arrow_forward</span></span>
</div>
</a>
@endforeach
</div>
<div class="flex flex-wrap items-center justify-center gap-3 mt-10 kiel-expertises-cta-row">
<a class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-secondary text-on-secondary font-label-md uppercase tracking-wider hover:opacity-95 transition-opacity" href="{{ route('partenaire') }}">Collaborer avec KIEL</a>
<a class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full border-2 border-primary text-primary hover:bg-primary/5 font-label-md uppercase tracking-wider transition-colors" href="{{ route('boutique') }}">Voir la boutique</a>
</div>
</div>
</section>
</main>
@endsection
