@extends('layouts.cms-admin')

@include('cms-admin.partials.wysiwyg-scripts')

@section('panel')
<form class="kiel-cms-form" method="post" action="{{ route('admin.cms.pages.update', $cmsPage) }}">
@csrf
@method('PUT')
<label>Titre<input name="title" required value="{{ old('title', $cmsPage->title) }}"/></label>
<label>Chapô<textarea name="lead" data-wysiwyg="basic" data-wysiwyg-height="180" rows="2">{{ old('lead', $cmsPage->lead) }}</textarea></label>
<label>Contenu<textarea name="body" class="kiel-cms-form__body" data-wysiwyg="full" data-wysiwyg-height="480" rows="16">{{ old('body', $cmsPage->body) }}</textarea></label>
<label>Image hero (chemin assets)<input name="hero_image" value="{{ old('hero_image', $cmsPage->hero_image) }}" placeholder="assets/img/..."/></label>
<label>Meta title<input name="meta_title" value="{{ old('meta_title', $cmsPage->meta_title) }}"/></label>
<label>Meta description<textarea name="meta_description" rows="2">{{ old('meta_description', $cmsPage->meta_description) }}</textarea></label>
<label>Meta keywords<input name="meta_keywords" value="{{ old('meta_keywords', $cmsPage->meta_keywords) }}"/></label>
<label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $cmsPage->is_published))/> Publié</label>
<div class="kiel-cms-form__actions">
<button class="kiel-cms-btn" type="submit">Enregistrer</button>
<a class="kiel-cms-btn kiel-cms-btn--ghost" href="{{ route('admin.cms.pages.index') }}">Retour</a>
</div>
</form>
@endsection
