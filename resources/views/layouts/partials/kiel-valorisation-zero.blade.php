@php
  $cms = app(\App\Services\CmsBlocks::class);
  $b = fn (string $k, string $d = '') => (string) $cms->get('about.'.$k, $d);
  $flows = $cms->json('about.zero.flows', []);
@endphp
<section class="kiel-zero-waste kiel-zero-waste--wide" id="valorisation-zero-dechet" aria-labelledby="kiel-zero-waste-title">
<div class="kiel-wrap">
<p class="kiel-zero-waste__eyebrow">Valorisation intégrale sans déchet</p>
<h2 class="kiel-zero-waste__title" id="kiel-zero-waste-title">{!! $b('zero.title', '100&nbsp;% de la gousse valorisée') !!}</h2>
<p class="kiel-zero-waste__lead">{!! $b('zero.lead', '') !!}</p>
<div class="kiel-zero-waste__flows kiel-zero-waste__flows--inline">
@foreach($flows as $row)
<p class="kiel-zero-waste__flow"><strong>{{ $row['pct'] ?? '' }}</strong> {{ $row['text'] ?? '' }}</p>
@endforeach
</div>
<div class="kiel-zero-tandem">
<div class="kiel-zero-tandem__copy">
<h3 class="kiel-zero-tandem__heading">{{ $b('zero.tandem_title', '') }}</h3>
<p class="kiel-zero-tandem__text">{!! $b('zero.tandem_text', '') !!}</p>
</div>
<div class="kiel-zero-tandem__profiles">
<figure class="kiel-zero-tandem__profile">
<img alt="" loading="lazy" src="{{ $cms->assetUrl($b('zero.tandem_img1', 'assets/img/sections/about/about-2.jpg')) }}"/>
</figure>
<figure class="kiel-zero-tandem__profile">
<img alt="" loading="lazy" src="{{ $cms->assetUrl($b('zero.tandem_img2', 'assets/img/sections/about/about-3.jpg')) }}"/>
</figure>
</div>
</div>
</div>
</section>
