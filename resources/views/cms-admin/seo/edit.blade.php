@extends('layouts.cms-admin')

@section('panel')
<form class="kiel-cms-form" method="post" action="{{ route('admin.cms.seo.update') }}">
@csrf
@method('PUT')
<label>Nom du site<input name="site_name" required value="{{ old('site_name', $seo['site_name'] ?? '') }}"/></label>
<label>Titre par défaut<input name="default_title" required value="{{ old('default_title', $seo['default_title'] ?? '') }}"/></label>
<label>Description par défaut<textarea name="default_description" rows="3" required>{{ old('default_description', $seo['default_description'] ?? '') }}</textarea></label>
<label>Mots-clés<input name="default_keywords" value="{{ old('default_keywords', $seo['default_keywords'] ?? '') }}"/></label>
<label>Image Open Graph (chemin)<input name="default_image" value="{{ old('default_image', $seo['default_image'] ?? '') }}" placeholder="assets/img/ressources/home-1.png"/></label>
<div class="kiel-cms-form__actions">
<button class="kiel-cms-btn" type="submit">Mettre à jour le SEO</button>
</div>
</form>
@endsection
