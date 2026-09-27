@extends('layouts.cms-admin')

@section('panel')
@php
  $filters = $filters ?? [];
@endphp
<div class="kiel-cms-list-panel">
<div class="kiel-cms-toolbar">
<a class="kiel-cms-btn kiel-cms-btn--primary" href="{{ route('admin.cms.expertises.create') }}">Nouvelle expertise</a>
</div>
<form class="kiel-cms-filters" method="get" action="{{ route('admin.cms.expertises.index') }}" data-cms-auto-filter>
<label class="kiel-cms-filters__field kiel-cms-filters__field--grow">
<span>Recherche</span>
<input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Titre, tag, slug…" maxlength="120"/>
</label>
<label class="kiel-cms-filters__field">
<span>Publication</span>
<select name="published">
<option value="">Toutes</option>
<option value="1" @selected(($filters['published'] ?? '') === '1')>Publiées</option>
<option value="0" @selected(($filters['published'] ?? '') === '0')>Brouillons</option>
</select>
</label>
<div class="kiel-cms-filters__actions">
<a class="kiel-cms-btn kiel-cms-btn--soft" href="{{ route('admin.cms.expertises.index') }}">Réinitialiser</a>
</div>
</form>
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead><tr><th>Pôle</th><th>Slug</th><th>Publié</th><th>Ordre</th><th class="kiel-cms-table__col-actions">Actions</th></tr></thead>
<tbody>
@forelse($poles as $pole)
<tr>
<td>
<span class="kiel-cms-table__primary">{{ $pole->title }}</span>
@if($pole->tag)<span class="kiel-cms-table__sub">{{ $pole->tag }}</span>@endif
</td>
<td><code class="kiel-cms-code">{{ $pole->slug }}</code></td>
<td>@if($pole->is_published)<span class="kiel-cms-badge">Oui</span>@else<span class="kiel-cms-table__muted">Non</span>@endif</td>
<td>{{ $pole->sort_order }}</td>
<td class="kiel-cms-table__col-actions">
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--edit" href="{{ route('admin.cms.expertises.edit', $pole) }}">Modifier</a>
</td>
</tr>
@empty
<tr><td colspan="5" class="kiel-cms-table__empty">Aucune expertise pour ces critères.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
