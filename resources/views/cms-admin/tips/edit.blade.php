@extends('layouts.cms-admin')

@include('cms-admin.partials.wysiwyg-scripts')

@section('panel')
@php $isNew = ! $video->exists; @endphp
<form class="kiel-cms-editor" method="post" action="{{ $isNew ? route('admin.cms.tips.store') : route('admin.cms.tips.update', $video) }}">
@csrf
@if(! $isNew) @method('PUT') @endif
<header class="kiel-cms-editor__head">
<div>
<p class="kiel-cms-editor__eyebrow">{{ $isNew ? 'Création' : 'Édition' }}</p>
<h2 class="kiel-cms-editor__title">{{ $isNew ? 'Nouvelle vidéo' : $video->title }}</h2>
</div>
<div class="kiel-cms-editor__head-actions">
<a class="kiel-cms-btn kiel-cms-btn--secondary" href="{{ route('admin.cms.tips.index') }}">Retour</a>
<button class="kiel-cms-btn kiel-cms-btn--primary" type="submit">{{ $isNew ? 'Publier' : 'Enregistrer' }}</button>
</div>
</header>
<div class="kiel-cms-editor__grid">
<div class="kiel-cms-editor__main">
<section class="kiel-cms-editor__section">
<h3>Vidéo YouTube</h3>
<label>Titre<input name="title" required value="{{ old('title', $video->title) }}"/></label>
<label>Slug<input name="slug" value="{{ old('slug', $video->slug) }}"/></label>
<label>Catégorie
<select name="category">
@foreach($categories as $key => $label)
<option value="{{ $key }}" @selected(old('category', $video->category) === $key)>{{ $label }}</option>
@endforeach
</select>
</label>
<label>ID YouTube<input name="youtube_id" required value="{{ old('youtube_id', $video->youtube_id) }}" placeholder="dQw4w9WgXcQ"/></label>
<label>Description<textarea name="description" data-wysiwyg="basic" data-wysiwyg-height="240" rows="4">{{ old('description', $video->description) }}</textarea></label>
<label>Durée (secondes)<input type="number" name="duration_seconds" min="0" value="{{ old('duration_seconds', $video->duration_seconds) }}"/></label>
<label>Ordre d’affichage<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $video->sort_order) }}"/></label>
</section>
</div>
<aside class="kiel-cms-editor__aside">
<section class="kiel-cms-editor__section kiel-cms-editor__section--card">
<h3>Publication</h3>
<label>Date<input type="datetime-local" name="published_at" value="{{ old('published_at', optional($video->published_at)->format('Y-m-d\TH:i')) }}"/></label>
<label class="kiel-cms-check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $video->is_published))/> Visible sur le site</label>
</section>
@if(! $isNew)
<button type="submit" form="delete-tip" class="kiel-cms-btn kiel-cms-btn--danger kiel-cms-btn--block">Supprimer</button>
@endif
</aside>
</div>
</form>
@if(! $isNew)
<form id="delete-tip" method="post" action="{{ route('admin.cms.tips.destroy', $video) }}" onsubmit="return confirm('Supprimer cette vidéo ?');">
@csrf @method('DELETE')
</form>
@endif
@endsection
