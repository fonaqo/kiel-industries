@php
  $cms = app(\App\Services\CmsBlocks::class);
  $b = fn (string $k, string $d = '') => (string) $cms->get('about.'.$k, $d);
  $kielLead = config('kiel.team.0', []);
  $directorDisplayName = trim(($kielLead['first_name'] ?? 'Célia').' '.($kielLead['last_name'] ?? 'CHABI'));
@endphp
<section class="kiel-section kiel-section--cream" id="directrice">
<div class="kiel-wrap kiel-about-reveal">
<div class="kiel-director-v5">
<div class="kiel-director-v5__visual">
<img alt="Présidente directrice générale KIEL INDUSTRIES" loading="lazy" src="{{ $cms->assetUrl($b('director.image', 'assets/img/ressources/directrice.jpeg')) }}"/>
<div class="kiel-director-v5__visual-cap">
<span class="material-symbols-outlined">format_quote</span>
</div>
</div>
<div class="kiel-director-v5__panel">
<p class="kiel-director-v5__eyebrow">Mot de la direction</p>
<h2 class="kiel-director-v5__title">{{ $b('director.title', 'Une filière baobab guidée par la preuve et le terrain') }}</h2>
<blockquote class="kiel-director-v5__quote">
<p>{!! $b('director.quote', '') !!}</p>
</blockquote>
<div class="kiel-director-v5__author">
<p class="kiel-director-v5__name">{{ $directorDisplayName }}</p>
<p class="kiel-director-v5__role">{{ $b('director.role', 'Présidente directrice générale · KIEL INDUSTRIES') }}</p>
</div>
</div>
</div>
</div>
</section>
