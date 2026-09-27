@extends('layouts.cms-admin')

@section('panel')
@php
  $filters = $filters ?? [];
@endphp
<div class="kiel-cms-list-panel">
<div class="kiel-cms-toolbar kiel-cms-toolbar--wrap">
<a class="kiel-cms-btn kiel-cms-btn--primary" href="{{ route('admin.cms.products.create') }}">Nouveau produit</a>
<a class="kiel-cms-btn kiel-cms-btn--secondary" href="{{ route('admin.cms.categories.index') }}">Catégories</a>
<div class="kiel-cms-toolbar__exports">
<span class="kiel-cms-toolbar__exports-label">Exporter</span>
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--soft" href="{{ route('admin.cms.products.export', 'excel') }}">Excel</a>
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--soft" href="{{ route('admin.cms.products.export', 'pdf') }}">PDF</a>
</div>
</div>
<form class="kiel-cms-filters" method="get" action="{{ route('admin.cms.products.index') }}" data-cms-auto-filter>
<label class="kiel-cms-filters__field kiel-cms-filters__field--grow">
<span>Recherche</span>
<input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Nom, slug, description…" maxlength="120"/>
</label>
<label class="kiel-cms-filters__field">
<span>Catégorie</span>
<select name="category">
<option value="">Toutes</option>
@foreach($categories as $cat)
<option value="{{ $cat->id }}" @selected(($filters['category'] ?? '') === (string) $cat->id)>{{ $cat->name }}</option>
@endforeach
</select>
</label>
<label class="kiel-cms-filters__field">
<span>Actif</span>
<select name="active">
<option value="">Tous</option>
<option value="1" @selected(($filters['active'] ?? '') === '1')>Oui</option>
<option value="0" @selected(($filters['active'] ?? '') === '0')>Non</option>
</select>
</label>
<label class="kiel-cms-filters__field">
<span>Stock</span>
<select name="stock">
<option value="">Tous</option>
<option value="in" @selected(($filters['stock'] ?? '') === 'in')>En stock</option>
<option value="out" @selected(($filters['stock'] ?? '') === 'out')>Rupture</option>
</select>
</label>
<div class="kiel-cms-filters__actions">
<a class="kiel-cms-btn kiel-cms-btn--soft" href="{{ route('admin.cms.products.index') }}">Réinitialiser</a>
</div>
</form>
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead><tr><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Actif</th><th class="kiel-cms-table__col-actions">Actions</th></tr></thead>
<tbody>
@forelse($products as $product)
<tr>
<td><span class="kiel-cms-table__primary">{{ $product->name }}</span></td>
<td>{{ $product->category?->name ?? '—' }}</td>
<td>
<div class="kiel-cms-table__primary">{{ number_format($product->price_fcfa, 0, ',', ' ') }} FCFA</div>
@if($product->price_eur || $product->price_usd)
<div class="kiel-cms-table__sub">
@if($product->price_eur){{ number_format((float) $product->price_eur, 2, ',', ' ') }} €@endif
@if($product->price_eur && $product->price_usd) · @endif
@if($product->price_usd){{ number_format((float) $product->price_usd, 2, '.', ' ') }} $@endif
</div>
@endif
</td>
<td>
@if($product->stock > 0)
<span class="kiel-cms-badge">{{ $product->stock }}</span>
@else
<span class="kiel-cms-badge kiel-cms-badge--muted">Rupture</span>
@endif
</td>
<td>@if($product->is_active)<span class="kiel-cms-badge">Oui</span>@else<span class="kiel-cms-table__muted">Non</span>@endif</td>
<td class="kiel-cms-table__col-actions">
<div class="kiel-cms-table__actions">
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--edit" href="{{ route('admin.cms.products.edit', $product) }}">Modifier</a>
<form method="post" action="{{ route('admin.cms.products.stock', $product) }}">
@csrf
@if($product->stock > 0)
<input type="hidden" name="action" value="out"/>
<button type="submit" class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--danger" title="Mettre en rupture">Rupture</button>
@else
<input type="hidden" name="action" value="in"/>
<button type="submit" class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--primary" title="Remettre en stock">En stock</button>
@endif
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="6" class="kiel-cms-table__empty">Aucun produit pour ces critères.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="kiel-cms-pagination">{{ $products->links() }}</div>
</div>
@endsection
