@extends('layouts.cms-admin')

@include('cms-admin.partials.wysiwyg-scripts')

@section('panel')
@php $isNew = ! $document->exists; @endphp
<form class="kiel-cms-editor" method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.cms.documents.store') : route('admin.cms.documents.update', $document) }}">
@csrf
@if(! $isNew) @method('PUT') @endif
<header class="kiel-cms-editor__head">
<div>
<p class="kiel-cms-editor__eyebrow">{{ $isNew ? 'Création' : 'Édition' }}</p>
<h2 class="kiel-cms-editor__title">{{ $isNew ? 'Nouveau document' : $document->title }}</h2>
</div>
<div class="kiel-cms-editor__head-actions">
<a class="kiel-cms-btn kiel-cms-btn--secondary" href="{{ route('admin.cms.documents.index') }}">Retour</a>
<button class="kiel-cms-btn kiel-cms-btn--primary" type="submit">{{ $isNew ? 'Publier' : 'Enregistrer' }}</button>
</div>
</header>
<div class="kiel-cms-editor__grid">
<div class="kiel-cms-editor__main">
<section class="kiel-cms-editor__section">
<h3>Informations</h3>
<label>Titre<input name="title" required value="{{ old('title', $document->title) }}"/></label>
<label>Slug<input name="slug" value="{{ old('slug', $document->slug) }}"/></label>
<label>Catégorie
<select name="category">
@foreach($categories as $key => $label)
<option value="{{ $key }}" @selected(old('category', $document->category) === $key)>{{ $label }}</option>
@endforeach
</select>
</label>
<label>Résumé<textarea name="summary" data-wysiwyg="basic" rows="3">{{ old('summary', $document->summary) }}</textarea></label>
<label>Organisme / émetteur<input name="issuer" value="{{ old('issuer', $document->issuer) }}"/></label>
<label>Date du document<input type="date" name="issued_at" value="{{ old('issued_at', optional($document->issued_at)->format('Y-m-d')) }}"/></label>
<label>Ordre d’affichage<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $document->sort_order) }}"/></label>
</section>
<section class="kiel-cms-editor__section">
<h3>Fichier (PDF ou image)</h3>
@if($document->file_path)
<p class="kiel-cms-hint">Fichier actuel : <a href="{{ $document->fileUrl() }}" target="_blank" rel="noopener">{{ $document->file_path }}</a></p>
@endif
<label>URL du fichier<input name="file_url" value="{{ old('file_url', str_starts_with((string) $document->file_path, 'http') ? $document->file_path : '') }}" placeholder="https://… ou laisser vide si upload"/></label>
<label>Upload<input type="file" name="file_upload" accept=".pdf,.jpg,.jpeg,.png,.webp"/></label>
</section>
</div>
<aside class="kiel-cms-editor__aside">
<section class="kiel-cms-editor__section kiel-cms-editor__section--card">
<h3>Publication</h3>
<label>Date<input type="datetime-local" name="published_at" value="{{ old('published_at', optional($document->published_at)->format('Y-m-d\TH:i')) }}"/></label>
<label class="kiel-cms-check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $document->is_published))/> Visible sur le site</label>
</section>
@if(! $isNew)
<button type="submit" form="delete-doc" class="kiel-cms-btn kiel-cms-btn--danger kiel-cms-btn--block">Supprimer</button>
@endif
</aside>
</div>
</form>
@if(! $isNew)
<form id="delete-doc" method="post" action="{{ route('admin.cms.documents.destroy', $document) }}" onsubmit="return confirm('Supprimer ce document ?');">
@csrf @method('DELETE')
</form>
@endif
@endsection
