@php
  $heroTitle = $heroTitle ?? ($title ?? 'KIEL INDUSTRIES');
  $heroLead = $heroLead ?? '';
  $heroImage = $heroImage ?? asset(config('kiel.subhero_image'));
  $heroCurrent = $heroCurrent ?? $heroTitle;
  $heroPlain = $heroPlain ?? false;
  $showBreadcrumb = $showBreadcrumb ?? true;
  $subheroExtraClass = $subheroExtraClass ?? '';
  $subheroClasses = ['kiel-subhero'];
  if ($heroPlain) {
      $subheroClasses[] = 'kiel-subhero--plain';
  }
  if ($subheroExtraClass !== '') {
      $subheroClasses[] = $subheroExtraClass;
  }
@endphp
<section class="{{ implode(' ', $subheroClasses) }}" @unless($heroPlain) style="--kiel-subhero-image: url('{{ $heroImage }}')" @endunless>
@if(! $heroPlain)<div class="kiel-subhero__overlay" aria-hidden="true"></div>@endif
<div class="kiel-wrap kiel-subhero__inner">
@if($showBreadcrumb)
<nav class="kiel-breadcrumb-jewel" aria-label="Fil d'Ariane">
<a class="kiel-breadcrumb-jewel__home" href="{{ route('home') }}" aria-label="Accueil"><span class="material-symbols-outlined">home</span></a>
<ol class="kiel-breadcrumb-jewel__trail">
<li><a href="{{ route('home') }}">Accueil</a></li>
<li class="kiel-breadcrumb-jewel__sep" aria-hidden="true"></li>
<li><span class="kiel-breadcrumb-jewel__current">{{ $heroCurrent }}</span></li>
</ol>
</nav>
@endif
<h1 class="kiel-subhero__title">{{ $heroTitle }}</h1>
@if($heroLead !== '')
<p class="kiel-subhero__lead">{{ $heroLead }}</p>
@endif
</div>
</section>
