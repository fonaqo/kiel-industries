@extends('layouts.cms-admin')

@include('cms-admin.partials.wysiwyg-scripts')

@section('panel')
@php
  $isNew = ! $product->exists;
  $benefitsText = old('benefits', is_array($product->benefits) ? implode("\n", $product->benefits) : '');
@endphp
<form class="kiel-cms-editor" method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.cms.products.store') : route('admin.cms.products.update', $product) }}">
@csrf
@if(! $isNew) @method('PUT') @endif
<header class="kiel-cms-editor__head">
<div>
<p class="kiel-cms-editor__eyebrow">{{ $isNew ? 'Création' : 'Édition' }}</p>
<h2 class="kiel-cms-editor__title">{{ $isNew ? 'Nouveau produit' : $product->name }}</h2>
</div>
<div class="kiel-cms-editor__head-actions">
<a class="kiel-cms-btn kiel-cms-btn--secondary" href="{{ route('admin.cms.products.index') }}">Retour à la liste</a>
<button class="kiel-cms-btn kiel-cms-btn--primary" type="submit">{{ $isNew ? 'Publier le produit' : 'Enregistrer' }}</button>
</div>
</header>
<div class="kiel-cms-editor__grid">
<div class="kiel-cms-editor__main">
<section class="kiel-cms-editor__section">
<h3>Informations produit</h3>
<label>Catégorie
<select name="category_id" required>
@foreach($categories as $cat)
<option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
@endforeach
</select>
</label>
<label>Nom du produit<input name="name" required value="{{ old('name', $product->name) }}"/></label>
<label>Slug URL<input name="slug" value="{{ old('slug', $product->slug) }}" placeholder="auto depuis le nom"/></label>
<label>Description<textarea name="description" data-wysiwyg="basic" data-wysiwyg-height="260" rows="5">{{ old('description', $product->description) }}</textarea></label>
<label>Vertus &amp; avantages (une ligne = un point)<textarea name="benefits" rows="5">{{ $benefitsText }}</textarea></label>
</section>
<section class="kiel-cms-editor__section">
<h3>Prix &amp; stock</h3>
<p class="kiel-cms-media-field__hint">Saisissez chaque devise telle qu’affichée en boutique (sans conversion automatique).</p>
<div class="kiel-cms-editor__row-3">
<label>Prix FCFA<input type="number" name="price_fcfa" required value="{{ old('price_fcfa', $product->price_fcfa) }}"/></label>
<label>Prix EUR<input type="number" step="0.01" name="price_eur" value="{{ old('price_eur', $product->price_eur) }}" placeholder="Optionnel"/></label>
<label>Prix USD<input type="number" step="0.01" name="price_usd" value="{{ old('price_usd', $product->price_usd) }}" placeholder="Optionnel"/></label>
</div>
<label>Réduction promotion (%)<input type="number" name="discount_percent" min="0" max="100" value="{{ old('discount_percent', $product->discount_percent) }}" placeholder="Ex. 15 pour −15 %"/></label>
<label>Quantité en stock<input type="number" name="stock" value="{{ old('stock', $product->stock) }}"/></label>
</section>
<section class="kiel-cms-editor__section">
<h3>Média &amp; badges</h3>
@include('cms-admin.partials.image-field', [
  'label' => 'Image principale',
  'value' => $product->exists ? $product->getRawOriginal('image_url') : '',
])
@include('cms-admin.partials.gallery-field', ['gallery' => $product->gallery ?? []])
<label>Badge (ex. Nouveau)<input name="badge" value="{{ old('badge', $product->badge) }}"/></label>
</section>
</div>
<aside class="kiel-cms-editor__aside">
<section class="kiel-cms-editor__section kiel-cms-editor__section--card">
<h3>Visibilité boutique</h3>
<label class="kiel-cms-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))/> Produit actif</label>
<label class="kiel-cms-check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))/> Mise en vedette</label>
<label class="kiel-cms-check"><input type="checkbox" name="is_best_seller" value="1" @checked(old('is_best_seller', $product->is_best_seller))/> Best-seller</label>
<label class="kiel-cms-check"><input type="checkbox" name="on_sale" value="1" @checked(old('on_sale', $product->on_sale))/> En promotion</label>
</section>
@include('cms-admin.partials.entity-seo', ['entity' => $product])
@if(! $isNew)
<button type="submit" form="delete-product" class="kiel-cms-btn kiel-cms-btn--danger kiel-cms-btn--block">Supprimer le produit</button>
@endif
</aside>
</div>
</form>
@if(! $isNew)
<form id="delete-product" method="post" action="{{ route('admin.cms.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce produit définitivement ?');">
@csrf
@method('DELETE')
</form>
@endif
@endsection

@push('scripts')
<script src="{{ asset('assets/js/admin/kiel-cms-media.js') }}" defer></script>
@endpush
