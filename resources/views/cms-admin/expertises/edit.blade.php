@extends('layouts.cms-admin')

@include('cms-admin.partials.wysiwyg-scripts')

@section('panel')
@php $isNew = ! $pole->exists; @endphp
<form class="kiel-cms-editor" method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.cms.expertises.store') : route('admin.cms.expertises.update', $pole) }}">
@csrf
@if(! $isNew) @method('PUT') @endif
<header class="kiel-cms-editor__head">
<div>
<p class="kiel-cms-editor__eyebrow">{{ $isNew ? 'Création' : 'Édition' }}</p>
<h2 class="kiel-cms-editor__title">{{ $isNew ? 'Nouvelle expertise' : $pole->title }}</h2>
</div>
<div class="kiel-cms-editor__head-actions">
<a class="kiel-cms-btn kiel-cms-btn--ghost" href="{{ route('admin.cms.expertises.index') }}">Retour</a>
<button class="kiel-cms-btn" type="submit">{{ $isNew ? 'Créer' : 'Enregistrer' }}</button>
</div>
</header>
<div class="kiel-cms-editor__grid">
<div class="kiel-cms-editor__main">
<section class="kiel-cms-editor__section">
<h3>Présentation</h3>
<label>Slug URL<input name="slug" value="{{ old('slug', $pole->slug) }}" placeholder="filiere-baobab-kiel"/></label>
<label>Tag court<input name="tag" required value="{{ old('tag', $pole->tag) }}"/></label>
<label>Titre<input name="title" required value="{{ old('title', $pole->title) }}"/></label>
<label>Introduction<textarea name="intro" rows="3" required>{{ old('intro', $pole->intro) }}</textarea></label>
<label>Paragraphes (un par ligne)<textarea name="paragraphs" rows="8" required>{{ old('paragraphs', implode("\n", $pole->paragraphs ?? [])) }}</textarea></label>
</section>
<section class="kiel-cms-editor__section">
<h3>Lien boutique</h3>
@include('cms-admin.partials.image-field', ['label' => 'Image de l’expertise', 'urlName' => 'image', 'fileName' => 'image_file', 'value' => old('image', $pole->image)])
<label>Catégorie boutique (slug)<input name="boutique_category" value="{{ old('boutique_category', $pole->boutique_category) }}"/></label>
<label>Ordre d’affichage<input type="number" name="sort_order" value="{{ old('sort_order', $pole->sort_order) }}"/></label>
</section>
</div>
<aside class="kiel-cms-editor__aside">
<section class="kiel-cms-editor__section kiel-cms-editor__section--card">
<h3>Statut</h3>
<label class="kiel-cms-check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $pole->is_published ?? true))/> Publiée sur le site</label>
</section>
@include('cms-admin.partials.entity-seo', ['entity' => $pole])
@if(! $isNew)
<button type="submit" form="delete-expertise" class="kiel-cms-btn kiel-cms-btn--danger kiel-cms-btn--block">Supprimer l’expertise</button>
@endif
</aside>
</div>
</form>
@if(! $isNew)
<form id="delete-expertise" method="post" action="{{ route('admin.cms.expertises.destroy', $pole) }}" onsubmit="return confirm('Supprimer cette expertise ?');">
@csrf
@method('DELETE')
</form>
@endif
@endsection

@push('scripts')
<script src="{{ asset('assets/js/admin/kiel-cms-media.js') }}" defer></script>
@endpush
