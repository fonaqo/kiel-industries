@extends('layouts.cms-admin')

@php
  $org = $seoSettings['organization'] ?? [];
  $geo = $seoSettings['geo'] ?? [];
  $pages = $seoSettings['pages'] ?? config('kiel.seo.pages', []);
  $integrations = $integrationSettings ?? [];
  $tabLabels = [
    'referencement' => 'Référencement',
    'organisation' => 'Organisation',
    'geo' => 'Géolocalisation',
    'reseaux' => 'Réseaux sociaux',
    'pages' => 'SEO des pages',
    'integrations' => 'Intégrations & codes',
  ];
@endphp

@section('panel')
<nav class="kiel-cms-settings-tabs" aria-label="Paramètres du site">
@foreach($tabs as $t)
<a href="{{ route('admin.cms.settings.edit', ['tab' => $t]) }}" @class(['is-active' => $tab === $t])>{{ $tabLabels[$t] ?? $t }}</a>
@endforeach
</nav>

@if($tab === 'referencement')
<form class="kiel-cms-form kiel-cms-form--wide" method="post" action="{{ route('admin.cms.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="referencement"/>
<section class="kiel-cms-editor__section">
<h3>Balises par défaut (site entier)</h3>
<label>Nom du site<input name="site_name" required value="{{ old('site_name', $seoSettings['site_name'] ?? '') }}"/></label>
<label>Titre par défaut<input name="default_title" required value="{{ old('default_title', $seoSettings['default_title'] ?? '') }}"/></label>
<label>Description par défaut<textarea name="default_description" rows="3" required>{{ old('default_description', $seoSettings['default_description'] ?? '') }}</textarea></label>
<label>Mots-clés globaux<input name="default_keywords" value="{{ old('default_keywords', $seoSettings['default_keywords'] ?? '') }}"/></label>
<label>Image Open Graph par défaut<input name="default_image" value="{{ old('default_image', $seoSettings['default_image'] ?? '') }}" placeholder="assets/img/…"/></label>
<label>Locale<input name="locale" value="{{ old('locale', $seoSettings['locale'] ?? 'fr_BJ') }}"/></label>
</section>
<div class="kiel-cms-form__actions"><button class="kiel-cms-btn" type="submit">Enregistrer</button></div>
</form>
@endif

@if($tab === 'organisation')
<form class="kiel-cms-form kiel-cms-form--wide" method="post" action="{{ route('admin.cms.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="organisation"/>
<section class="kiel-cms-editor__section">
<h3>Entité légale (Schema.org)</h3>
<label>Raison sociale<input name="legal_name" required value="{{ old('legal_name', $org['legal_name'] ?? '') }}"/></label>
<label>E-mail<input type="email" name="email" required value="{{ old('email', $org['email'] ?? '') }}"/></label>
<label>Téléphone<input name="phone" value="{{ old('phone', $org['phone'] ?? '') }}"/></label>
<label>IFU<input name="ifu" value="{{ old('ifu', $org['ifu'] ?? '') }}"/></label>
<label>Liens sameAs (un URL par ligne)<textarea name="same_as" rows="4">{{ old('same_as', implode("\n", $org['same_as'] ?? [])) }}</textarea></label>
</section>
<div class="kiel-cms-form__actions"><button class="kiel-cms-btn" type="submit">Enregistrer</button></div>
</form>
@endif

@if($tab === 'geo')
<form class="kiel-cms-form kiel-cms-form--wide" method="post" action="{{ route('admin.cms.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="geo"/>
<section class="kiel-cms-editor__section">
<h3>Coordonnées &amp; SEO local</h3>
<div class="kiel-cms-editor__row-2">
<label>Ville<input name="city" value="{{ old('city', $geo['city'] ?? '') }}"/></label>
<label>Région (nom)<input name="region_name" value="{{ old('region_name', $geo['region_name'] ?? '') }}"/></label>
</div>
<label>Code région ISO<input name="region" value="{{ old('region', $geo['region'] ?? '') }}" placeholder="BJ-BO"/></label>
<label>Pays (code)<input name="country_code" value="{{ old('country_code', $geo['country_code'] ?? 'BJ') }}"/></label>
<label>Adresse<input name="street" value="{{ old('street', $geo['street'] ?? '') }}"/></label>
<label>Code postal<input name="postal_code" value="{{ old('postal_code', $geo['postal_code'] ?? '') }}"/></label>
<div class="kiel-cms-editor__row-2">
<label>Latitude<input name="latitude" value="{{ old('latitude', $geo['latitude'] ?? '') }}"/></label>
<label>Longitude<input name="longitude" value="{{ old('longitude', $geo['longitude'] ?? '') }}"/></label>
</div>
</section>
<div class="kiel-cms-form__actions"><button class="kiel-cms-btn" type="submit">Enregistrer</button></div>
</form>
@endif

@if($tab === 'reseaux')
<form class="kiel-cms-form kiel-cms-form--wide" method="post" action="{{ route('admin.cms.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="reseaux"/>
<section class="kiel-cms-editor__section">
<h3>Réseaux sociaux (header &amp; footer)</h3>
@php
  $baseSocial = array_values($socialLinks ?: config('kiel.social', []));
  $socialRows = array_pad($baseSocial, 6, ['label' => '', 'url' => '', 'icon' => 'instagram']);
@endphp
@foreach($socialRows as $i => $link)
<div class="kiel-cms-social-row">
<label>Libellé<input name="label[]" value="{{ old('label.'.$i, $link['label'] ?? '') }}"/></label>
<label>URL<input name="url[]" value="{{ old('url.'.$i, $link['url'] ?? '') }}"/></label>
<label>Icône<input name="icon[]" value="{{ old('icon.'.$i, $link['icon'] ?? 'instagram') }}" placeholder="instagram, facebook…"/></label>
</div>
@endforeach
</section>
<div class="kiel-cms-form__actions"><button class="kiel-cms-btn" type="submit">Enregistrer</button></div>
</form>
@endif

@if($tab === 'pages')
<form class="kiel-cms-form kiel-cms-form--wide" method="post" action="{{ route('admin.cms.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="pages"/>
<section class="kiel-cms-editor__section">
<h3>SEO par route Laravel</h3>
<p class="kiel-cms-seo-panel__hint">Route = nom dans routes/web.php (ex. home, boutique, contact).</p>
@foreach($pages as $route => $meta)
<div class="kiel-cms-page-seo-row">
<input type="hidden" name="page_route[]" value="{{ $route }}"/>
<strong class="kiel-cms-page-seo-row__route">{{ $route }}</strong>
<label>Titre<input name="page_title[]" value="{{ old('page_title.'.$loop->index, $meta['title'] ?? '') }}"/></label>
<label>Description<textarea name="page_description[]" rows="2">{{ old('page_description.'.$loop->index, $meta['description'] ?? '') }}</textarea></label>
<label>Mots-clés<input name="page_keywords[]" value="{{ old('page_keywords.'.$loop->index, $meta['keywords'] ?? '') }}"/></label>
</div>
@endforeach
</section>
<div class="kiel-cms-form__actions"><button class="kiel-cms-btn" type="submit">Enregistrer</button></div>
</form>
@endif

@if($tab === 'integrations')
<form class="kiel-cms-form kiel-cms-form--wide" method="post" action="{{ route('admin.cms.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="integrations"/>
<section class="kiel-cms-editor__section">
<h3>Scripts &amp; pixels</h3>
<p class="kiel-cms-seo-panel__hint">Les identifiants génèrent automatiquement les balises Google Analytics (GA4), Google Tag Manager et Meta Pixel. Les champs HTML permettent d’ajouter d’autres snippets (chat, CRM, etc.).</p>
<label>Google Analytics (ID mesure GA4, ex. G-XXXXXXXX)<input name="google_analytics_id" value="{{ old('google_analytics_id', $integrations['google_analytics_id'] ?? '') }}" placeholder="G-XXXXXXXX"/></label>
<label>Google Tag Manager (ex. GTM-XXXXXXX)<input name="google_tag_manager_id" value="{{ old('google_tag_manager_id', $integrations['google_tag_manager_id'] ?? '') }}" placeholder="GTM-XXXXXXX"/></label>
<label>Meta Pixel (Facebook)<input name="meta_pixel_id" value="{{ old('meta_pixel_id', $integrations['meta_pixel_id'] ?? '') }}" placeholder="1234567890"/></label>
<label>Code additionnel &lt;head&gt;<textarea name="head_html" rows="6" class="kiel-cms-form__body" placeholder="&lt;script&gt;…&lt;/script&gt;">{{ old('head_html', $integrations['head_html'] ?? '') }}</textarea></label>
<label>Code avant la fin du &lt;body&gt;<textarea name="body_html" rows="6" class="kiel-cms-form__body" placeholder="Widgets, scripts différés…">{{ old('body_html', $integrations['body_html'] ?? '') }}</textarea></label>
</section>
<div class="kiel-cms-form__actions"><button class="kiel-cms-btn" type="submit">Enregistrer</button></div>
</form>
@endif
@endsection
