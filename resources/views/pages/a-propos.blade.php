@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-about-v2.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pages/kiel-about-premium.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pages/kiel-documents.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
<script>
(function () {
  const els = document.querySelectorAll('.kiel-about-reveal');
  if (!els.length) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    els.forEach((el) => el.classList.add('is-visible'));
    return;
  }
  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          e.target.classList.add('is-visible');
          io.unobserve(e.target);
        }
      });
    },
    { rootMargin: '0px 0px -8% 0px', threshold: 0.12 }
  );
  els.forEach((el) => io.observe(el));
})();
</script>
@endpush

@section('content')
@php
  $cms = $cms ?? app(\App\Services\CmsBlocks::class);
  $b = fn (string $k, string $d = '') => (string) ($a[$k] ?? $d);
  $highlights = $cms->json('about.highlights', []);
  $missionCards = $cms->json('about.mission.cards', []);
  $timelineSteps = $cms->json('about.timeline.steps', []);
  $teamMembers = $cms->json('about.team.members', []);
  $aboutFaq = $cms->json('about.faq.items', []);
@endphp
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface kiel-about-v2">

@include('layouts.partials.page-subhero', [
  'heroTitle' => $b('hero.title', 'À propos de KIEL INDUSTRIES'),
  'heroLead' => $b('hero.lead', ''),
  'heroCurrent' => 'À propos de KIEL INDUSTRIES',
])

<section class="kiel-about-v2-split kiel-about-hero-band">
<div class="kiel-wrap kiel-about-v2-split__grid kiel-about-reveal">
<div class="kiel-about-v2-media">
<img alt="Atelier KIEL" class="kiel-about-v2-media__top" src="{{ $cms->assetUrl($b('intro.img_top', 'assets/img/sections/about/1.jpg')) }}"/>
<img alt="Productrices au Borgou" class="kiel-about-v2-media__bottom" src="{{ $cms->assetUrl($b('intro.img_bottom', 'assets/img/sections/about/2.webp')) }}"/>
<div class="kiel-about-v2-seal" aria-hidden="true">
<img alt="KIEL INDUSTRIES" class="kiel-logo-wordmark" src="{{ asset('assets/img/brand/logo-kiel.svg') }}"/>
</div>
</div>
<div class="kiel-about-v2-copy">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'KIEL INDUSTRIES · Parakou',
  'title' => 'À propos de KIEL INDUSTRIES',
  'lead' => $b('intro.title', 'Valoriser le baobab, transformer le Borgou'),
])
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $b('intro.body', '') }}</p>
<ul class="kiel-about-highlights">
@foreach($highlights as $item)
<li>
<span class="kiel-about-highlights__icon"><span class="material-symbols-outlined">{{ $item['icon'] ?? 'eco' }}</span></span>
<div><strong>{{ $item['title'] ?? '' }}</strong><p>{{ $item['text'] ?? '' }}</p></div>
</li>
@endforeach
</ul>
<div class="kiel-about-intro-actions">
<a class="kiel-about-btn--primary" href="{{ route('boutique') }}">Découvrir nos produits <span class="material-symbols-outlined" style="font-size:18px">shopping_bag</span></a>
<a class="kiel-about-btn--green" href="{{ route('contact') }}">Nous contacter</a>
</div>
</div>
</div>
</section>

<section class="kiel-section kiel-section--cream kiel-about-mission-band" id="mission">
<div class="kiel-about-mission-filigrane" aria-hidden="true">
@include('partials.kiel-baobab-silhouette', ['mono' => true])
</div>
<div class="kiel-wrap kiel-about-reveal">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'Mission · vision · rôle',
  'title' => $b('mission.title', 'Pourquoi KIEL INDUSTRIES existe'),
  'lead' => $b('mission.lead', ''),
  'leadClass' => 'kiel-section-head-lead-spaced',
])
<div class="kiel-about-mission-grid">
@foreach($missionCards as $card)
<article class="kiel-about-mission-card">
<span class="material-symbols-outlined" aria-hidden="true">{{ $card['icon'] ?? 'flag' }}</span>
<h3>{{ $card['title'] ?? '' }}</h3>
<p>{{ $card['text'] ?? '' }}</p>
</article>
@endforeach
</div>
<div class="kiel-about-intro-actions" style="margin-top:1.75rem">
<a class="kiel-about-btn--green" href="{{ route('partenaire') }}">Devenir partenaire</a>
<a class="kiel-about-btn--outline" href="{{ route('boutique') }}">Voir la boutique</a>
</div>
</div>
</section>

@include('layouts.partials.kiel-valorisation-zero')

<section class="kiel-about-v2-process" id="parcours">
<div class="kiel-wrap kiel-about-reveal">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'Notre parcours',
  'title' => $b('timeline.title', ''),
  'lead' => $b('timeline.lead', ''),
])
<div class="kiel-about-v2-wave">
<svg class="kiel-about-v2-wave__path" viewBox="0 0 1200 420" preserveAspectRatio="none" aria-hidden="true"><path d="M0,320 C200,280 280,120 480,180 S760,360 920,140 S1100,80 1200,60" fill="none"/></svg>
<ol class="kiel-about-v2-steps">
@foreach($timelineSteps as $i => $step)
<li style="--step-y:{{ [72,48,68,18][$i] ?? 50 }}%">
<time class="kiel-about-v2-step-year" datetime="{{ $step['year'] ?? '' }}">{{ $step['year'] ?? '' }}</time>
<img alt="" src="{{ $cms->assetUrl($step['image'] ?? 'assets/img/sections/about/about-1.jpg') }}"/>
<h3>{{ $step['title'] ?? '' }}</h3>
<p>{{ $step['text'] ?? '' }}</p>
</li>
@endforeach
</ol>
<img alt="" class="kiel-about-v2-process__leaves baobab-sil baobab-sil--mono" loading="lazy" src="{{ asset('assets/img/filigrane/baobab-leaves-deco.svg') }}"/>
</div>
</div>
</section>

@include('layouts.partials.kiel-director-message')

<section class="kiel-section" id="equipe">
<div class="kiel-wrap kiel-about-reveal">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'Notre équipe',
  'title' => $b('team.title', 'Des talents au cœur de la filière'),
  'lead' => $b('team.lead', ''),
  'leadClass' => 'kiel-section-head-lead-team',
])
<div class="kiel-about-team-v3">
@foreach($teamMembers as $member)
<article>
<img class="kiel-about-team-v3__photo" alt="{{ $member['first_name'] }} {{ $member['last_name'] }}" loading="lazy" src="{{ asset($member['photo']) }}"/>
<p class="kiel-about-team-v3__name">
<span class="kiel-about-team-v3__firstname">{{ $member['first_name'] }}</span>
<span class="kiel-about-team-v3__lastname">{{ $member['last_name'] }}</span>
</p>
<p class="kiel-about-team-v3__role">{{ $member['role'] }}</p>
</article>
@endforeach
</div>
</div>
</section>

@if(($highlightDocuments ?? collect())->isNotEmpty())
<section class="kiel-section kiel-docs-section" id="documents-officiels">
<div class="kiel-wrap kiel-about-reveal">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'Conformité & confiance',
  'title' => 'Agréments et certifications',
  'lead' => 'Un aperçu de nos documents officiels. La liste complète est sur la page Nos documents.',
  'centered' => true,
])
@include('partials.kiel-documents-grid', ['documents' => $highlightDocuments, 'showAllLink' => true])
</div>
</section>
@endif

<section class="kiel-section kiel-section--cream kiel-about-faq" id="faq-a-propos">
<div class="kiel-wrap kiel-about-reveal max-w-3xl mx-auto">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'FAQ',
  'title' => $b('faq.title', 'Questions sur KIEL INDUSTRIES'),
  'lead' => $b('faq.lead', ''),
  'centered' => true,
])
<div class="faq-list">
@foreach($aboutFaq as $faq)
<details class="faq-item">
<summary>{{ $faq['q'] ?? '' }} <span class="material-symbols-outlined">expand_more</span></summary>
<div class="faq-answer">{{ $faq['a'] ?? '' }}</div>
</details>
@endforeach
</div>
<div class="text-center mt-8">
<a class="kiel-about-v2-cta" href="{{ route('contact') }}">Une autre question ? Écrivez-nous <span class="material-symbols-outlined">arrow_forward</span></a>
</div>
</div>
</section>

</main>
@endsection
