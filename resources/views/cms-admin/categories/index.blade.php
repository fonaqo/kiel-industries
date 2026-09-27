@extends('layouts.cms-admin')

@section('panel')
@php
  $filters = $filters ?? [];
@endphp
<div class="kiel-cms-list-panel">
<div class="kiel-cms-toolbar">
<a class="kiel-cms-btn kiel-cms-btn--primary" href="{{ route('admin.cms.categories.create') }}">Nouvelle catégorie</a>
</div>
<form class="kiel-cms-filters" method="get" action="{{ route('admin.cms.categories.index') }}" data-cms-auto-filter>
<label class="kiel-cms-filters__field kiel-cms-filters__field--grow">
<span>Recherche</span>
<input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Nom, slug…" maxlength="120"/>
</label>
<label class="kiel-cms-filters__field">
<span>Utilisation</span>
<select name="usage">
<option value="">Toutes</option>
<option value="used" @selected(($filters['usage'] ?? '') === 'used')>Avec produits</option>
<option value="empty" @selected(($filters['usage'] ?? '') === 'empty')>Sans produit</option>
</select>
</label>
<div class="kiel-cms-filters__actions">
<a class="kiel-cms-btn kiel-cms-btn--soft" href="{{ route('admin.cms.categories.index') }}">Réinitialiser</a>
</div>
</form>
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead><tr><th>Nom</th><th>Slug</th><th>Produits</th><th>Ordre</th><th class="kiel-cms-table__col-actions">Actions</th></tr></thead>
<tbody>
@forelse($categories as $category)
<tr>
<td><span class="kiel-cms-table__primary">{{ $category->name }}</span></td>
<td><code class="kiel-cms-code">{{ $category->slug }}</code></td>
<td>{{ $category->products_count }}</td>
<td>{{ $category->sort_order }}</td>
<td class="kiel-cms-table__col-actions">
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--edit" href="{{ route('admin.cms.categories.edit', $category) }}">Modifier</a>
@if($category->products_count === 0)
<form method="post" action="{{ route('admin.cms.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer cette catégorie ?');">
@csrf
@method('DELETE')
<button type="submit" class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--danger">Supprimer</button>
</form>
@endif
</td>
</tr>
@empty
<tr><td colspan="5" class="kiel-cms-table__empty">Aucune catégorie pour ces critères.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
