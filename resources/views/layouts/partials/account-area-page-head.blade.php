@php
  $heroTitle = $heroTitle ?? '';
  $heroLead = $heroLead ?? '';
  $heroCurrent = $heroCurrent ?? $heroTitle;
  $useSubhero = $useSubhero ?? false;
@endphp
@if($useSubhero)
@include('layouts.partials.page-subhero', [
  'heroTitle' => $heroTitle,
  'heroLead' => $heroLead,
  'heroCurrent' => $heroCurrent,
  'heroPlain' => false,
  'heroImage' => asset(config('kiel.subhero_image')),
  'subheroExtraClass' => 'kiel-subhero--account',
  'showBreadcrumb' => $showBreadcrumb ?? true,
])
@elseif($heroTitle !== '')
<header class="kiel-account-page-head">
<h1 class="kiel-account-page-head__title">{{ $heroTitle }}</h1>
@if($heroLead !== '')
<p class="kiel-account-page-head__lead">{{ $heroLead }}</p>
@endif
</header>
@endif
