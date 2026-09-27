@extends('layouts.app')

@section('content')
@php
  $cms = $cms ?? app(\App\Services\CmsBlocks::class);
  $b = fn (string $k, string $d = '') => (string) ($p[$k] ?? $d);
  $types = $cms->json('partner.types', []);
@endphp
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface">

@include('layouts.partials.page-subhero', [
  'heroTitle' => $b('hero.title', 'Faites grandir la filière baobab avec KIEL'),
  'heroLead' => $b('hero.lead', ''),
  'heroCurrent' => 'Partenaire',
])

<section class="kiel-section">
<div class="kiel-wrap">
<div class="kiel-partner-types">
@foreach($types as $type)
<article class="kiel-partner-type">
@include('partials.kiel-ui-icon', ['name' => 'handshake', 'size' => 26, 'class' => 'text-secondary'])
<h3>{{ $type['title'] ?? '' }}</h3>
<p style="font-size:14px;line-height:1.55;color:#211a17">{{ $type['text'] ?? '' }}</p>
</article>
@endforeach
</div>
</div>
</section>
<section class="kiel-section" style="background:#fff">
<div class="kiel-wrap kiel-split">
<div>
<h2 class="kiel-section__title">{{ $b('form.title', 'Proposer un partenariat') }}</h2>
<p style="color:#211a17;line-height:1.6">{{ $b('form.lead', '') }}</p>
<form class="kiel-form" data-mailto data-subject="Demande de partenariat KIEL INDUSTRIES" style="margin-top:1.5rem">
<label>E-mail<input name="email" required type="email" placeholder="contact@organisation.com"/></label>
<label>Organisation<input name="organisation" required type="text"/></label>
<label>Type de partenariat<select name="type"><option>Distribution / retail</option><option>B2B / industrie</option><option>Projet institutionnel</option><option>Autre</option></select></label>
<label>Message<textarea name="message" required placeholder="Votre projet, volumes, zones géographiques…"></textarea></label>
<button class="kiel-btn kiel-btn--primary" type="submit">Envoyer la demande</button>
</form>
</div>
<div>
<img alt="Baobab KIEL" style="width:100%;border-radius:1.35rem;box-shadow:0 20px 48px rgba(44,0,10,.12)" src="{{ $cms->assetUrl($b('image', 'assets/img/ressources/partenariat.png')) }}"/>
<p class="quote-serif" style="margin-top:1.25rem;font-size:1.15rem;color:#74313d;line-height:1.5">{{ $b('quote', '') }}</p>
</div>
</div>
</section>
</main>
@endsection
