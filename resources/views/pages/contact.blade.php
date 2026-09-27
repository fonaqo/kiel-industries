@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-contact-page.css') }}" rel="stylesheet"/>
@endpush

@section('content')
@php
  $cms = $cms ?? app(\App\Services\CmsBlocks::class);
  $b = fn (string $k, string $d = '') => (string) ($c[$k] ?? $d);
@endphp
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface kiel-contact-v3">

@include('layouts.partials.page-subhero', [
  'heroTitle' => $b('hero.title', 'Contactez KIEL INDUSTRIES'),
  'heroLead' => $b('hero.lead', ''),
  'heroCurrent' => 'Contact',
])

<section class="kiel-section kiel-contact-v3__body">
<div class="kiel-wrap kiel-contact-v3-stack">
<div class="kiel-contact-v3-info-block">
<h2>{{ $b('coords.title', 'Nos coordonnées') }}</h2>
<p>{{ $b('coords.lead', '') }}</p>
<div class="kiel-contact-v3-chips kiel-contact-v3-chips--row kiel-contact-v3-chips--cols-3">
<div class="kiel-contact-v3-chip">
<span class="kiel-contact-v3-chip__icon kiel-contact-v3-chip__icon--wine">@include('partials.kiel-ui-icon', ['name' => 'call', 'size' => 22])</span>
<div>
<strong>Téléphone</strong>
<a href="tel:+2290165728584">{{ $b('phone', '+229 0165728584') }}</a>
<p>Lundi – vendredi · 8h – 18h (GMT+1)</p>
</div>
</div>
<div class="kiel-contact-v3-chip">
<span class="kiel-contact-v3-chip__icon kiel-contact-v3-chip__icon--green">@include('partials.kiel-ui-icon', ['name' => 'mail', 'size' => 22])</span>
<div>
<strong>E-mail</strong>
<a href="mailto:{{ $b('email', 'kielbienetre@gmail.com') }}">{{ $b('email', 'kielbienetre@gmail.com') }}</a>
<p>Réponse sous 48 h ouvrées en moyenne.</p>
</div>
</div>
<div class="kiel-contact-v3-chip">
<span class="kiel-contact-v3-chip__icon kiel-contact-v3-chip__icon--wine">@include('partials.kiel-ui-icon', ['name' => 'location_on', 'size' => 22])</span>
<div>
<strong>Adresse</strong>
<span class="kiel-contact-v3-chip__val">{{ $b('address', 'Parakou, Borgou, Bénin') }}</span>
<p>IFU 0201710192397 · visite sur rendez-vous.</p>
</div>
</div>
</div>
</div>

<div class="kiel-contact-v3-form-row">
<div class="kiel-contact-v3-form">
@include('partials.kiel-section-eyebrow', ['label' => 'Écrivez-nous'])
<h2>{{ $b('form.title', 'Envoyer un message') }}</h2>
<p>{{ $b('form.lead', '') }}</p>
@if(session('contact_success'))
<div class="kiel-contact-v3-flash kiel-contact-v3-flash--success" role="status">{{ session('contact_success') }}</div>
@endif
@if($errors->any())
<div class="kiel-contact-v3-flash kiel-contact-v3-flash--error" role="alert">
<ul class="kiel-contact-v3-flash__list">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<form class="kiel-form" method="post" action="{{ route('contact.store') }}">
@csrf
<div class="kiel-form-row kiel-form-row--2">
<label>Prénom<input name="prenom" required type="text" autocomplete="given-name" value="{{ old('prenom') }}"/></label>
<label>Nom<input name="nom" required type="text" autocomplete="family-name" value="{{ old('nom') }}"/></label>
</div>
<label>E-mail<input name="email" required type="email" autocomplete="email" value="{{ old('email') }}"/></label>
<label>Message<textarea name="message" required rows="5" placeholder="Décrivez votre demande…">{{ old('message') }}</textarea></label>
<button class="kiel-btn kiel-btn--primary" type="submit"><span class="material-symbols-outlined" style="font-size:18px">send</span> Envoyer</button>
</form>
<div class="kiel-contact-v3-links">
<a href="{{ route('boutique') }}"><span class="material-symbols-outlined" style="font-size:16px">shopping_bag</span> Boutique</a>
<a href="{{ route('partenaire') }}"><span class="material-symbols-outlined" style="font-size:16px">handshake</span> Partenaire</a>
<a href="{{ route('expertises') }}"><span class="material-symbols-outlined" style="font-size:16px">menu_book</span> Expertises</a>
<a href="{{ route('panier') }}"><span class="material-symbols-outlined" style="font-size:16px">shopping_cart</span> Panier</a>
</div>
</div>
<div class="kiel-contact-v3-visual">
<img alt="Ateliers et filière baobab KIEL à Parakou" loading="lazy" src="{{ $cms->assetUrl($b('visual_image', 'assets/img/sections/about/about-1.jpg')) }}"/>
</div>
</div>
</div>
</section>

<section class="kiel-section kiel-section--cream kiel-contact-v3-map" id="carte-parakou">
<div class="kiel-wrap">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'Plan & accès',
  'title' => $b('map.title', 'Nous trouver à Parakou'),
  'lead' => $b('map.lead', ''),
])
<div class="kiel-contact-map-wrap">
<div class="kiel-contact-v3-map-pin">
<strong>KIEL INDUSTRIES</strong>
Parakou, Borgou, Bénin<br/>
Siège &amp; ateliers
</div>
<iframe
  title="Carte : KIEL INDUSTRIES, Parakou, Bénin"
  loading="lazy"
  referrerpolicy="no-referrer-when-downgrade"
  src="https://maps.google.com/maps?q=Parakou,+Benin&amp;z=13&amp;output=embed"
  allowfullscreen
></iframe>
</div>
</div>
</section>

</main>
@endsection
