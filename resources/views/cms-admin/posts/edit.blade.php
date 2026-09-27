@extends('layouts.cms-admin')

@include('cms-admin.partials.wysiwyg-scripts')

@section('panel')
@php $isNew = ! $post->exists; @endphp
<form class="kiel-cms-editor" method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.cms.posts.store') : route('admin.cms.posts.update', $post) }}">
@csrf
@if(! $isNew) @method('PUT') @endif
<header class="kiel-cms-editor__head">
<div>
<p class="kiel-cms-editor__eyebrow">{{ $isNew ? 'Création' : 'Édition' }}</p>
<h2 class="kiel-cms-editor__title">{{ $isNew ? 'Nouvelle actualité' : $post->title }}</h2>
</div>
<div class="kiel-cms-editor__head-actions">
<a class="kiel-cms-btn kiel-cms-btn--secondary" href="{{ route('admin.cms.posts.index') }}">Retour</a>
<button class="kiel-cms-btn kiel-cms-btn--primary" type="submit">{{ $isNew ? 'Publier' : 'Enregistrer' }}</button>
</div>
</header>
<div class="kiel-cms-editor__grid">
<div class="kiel-cms-editor__main">
<section class="kiel-cms-editor__section">
<h3>Contenu</h3>
<label>Titre<input name="title" required value="{{ old('title', $post->title) }}"/></label>
<label>Slug<input name="slug" value="{{ old('slug', $post->slug) }}"/></label>
<label>Rubrique<input name="category" value="{{ old('category', $post->category) }}" placeholder="Actualités"/></label>
<label>Chapô / extrait<textarea name="excerpt" data-wysiwyg="basic" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea></label>
<label>Corps<textarea name="body" class="kiel-cms-form__body" data-wysiwyg="full" data-wysiwyg-height="420" rows="12">{{ old('body', $post->body) }}</textarea></label>
</section>
<section class="kiel-cms-editor__section">
<h3>Image</h3>
@include('cms-admin.partials.image-field', ['label' => 'Visuel principal', 'value' => old('image_url', $post->exists ? ($post->getAttributes()['image_url'] ?? '') : '')])
</section>
</div>
<aside class="kiel-cms-editor__aside">
<section class="kiel-cms-editor__section kiel-cms-editor__section--card">
<h3>Publication</h3>
<label>Date et heure<input type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}"/></label>
<label class="kiel-cms-check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $post->is_featured))/> À la une</label>
</section>
@include('cms-admin.partials.entity-seo', ['entity' => $post])
@if(! $isNew)
<button type="submit" form="delete-post" class="kiel-cms-btn kiel-cms-btn--danger kiel-cms-btn--block">Supprimer l’actualité</button>
@endif
</aside>
</div>
</form>
@if(! $isNew)
<form id="delete-post" method="post" action="{{ route('admin.cms.posts.destroy', $post) }}" onsubmit="return confirm('Supprimer cette actualité ?');">
@csrf
@method('DELETE')
</form>
@endif
@endsection

@push('scripts')
<script src="{{ asset('assets/js/admin/kiel-cms-media.js') }}" defer></script>
@endpush
