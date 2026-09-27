@extends('layouts.cms-admin')

@section('panel')
@php $isNew = ! $category->exists; @endphp
<form class="kiel-cms-editor" method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.cms.categories.store') : route('admin.cms.categories.update', $category) }}">
@csrf
@if(! $isNew) @method('PUT') @endif
<header class="kiel-cms-editor__head">
<div>
<p class="kiel-cms-editor__eyebrow">{{ $isNew ? 'Création' : 'Édition' }}</p>
<h2 class="kiel-cms-editor__title">{{ $isNew ? 'Nouvelle catégorie' : $category->name }}</h2>
</div>
<div class="kiel-cms-editor__head-actions">
<a class="kiel-cms-btn kiel-cms-btn--ghost" href="{{ route('admin.cms.categories.index') }}">Retour</a>
<button class="kiel-cms-btn" type="submit">{{ $isNew ? 'Créer' : 'Enregistrer' }}</button>
</div>
</header>
<div class="kiel-cms-editor__grid">
<div class="kiel-cms-editor__main">
<section class="kiel-cms-editor__section">
<h3>Catégorie boutique</h3>
<label>Nom<input name="name" required value="{{ old('name', $category->name) }}"/></label>
<label>Slug URL<input name="slug" value="{{ old('slug', $category->slug) }}" placeholder="nutrition, soins…"/></label>
<label>Ordre d’affichage<input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}"/></label>
@include('cms-admin.partials.image-field', ['label' => 'Image (menu & accueil)', 'urlName' => 'image', 'fileName' => 'image_file', 'value' => old('image', $category->image)])
<label>Accroche menu (sous-titre)<input name="nav_teaser" value="{{ old('nav_teaser', $category->nav_teaser) }}" placeholder="Texte court sous le nom dans le menu boutique"/></label>
</section>
</div>
<aside class="kiel-cms-editor__aside">
@include('cms-admin.partials.entity-seo', ['entity' => $category, 'showRobots' => false, 'showOg' => false])
@if(! $isNew && $category->products()->count() === 0)
<button type="submit" form="delete-category" class="kiel-cms-btn kiel-cms-btn--danger kiel-cms-btn--block">Supprimer la catégorie</button>
@endif
</aside>
</div>
</form>
@if(! $isNew && $category->products()->count() === 0)
<form id="delete-category" method="post" action="{{ route('admin.cms.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer cette catégorie ?');">
@csrf
@method('DELETE')
</form>
@endif
@endsection

@push('scripts')
<script src="{{ asset('assets/js/admin/kiel-cms-media.js') }}" defer></script>
@endpush
