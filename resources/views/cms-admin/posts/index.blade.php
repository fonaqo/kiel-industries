@extends('layouts.cms-admin')

@section('panel')
@php
  $filters = $filters ?? [];
@endphp
<div class="kiel-cms-list-panel">
<div class="kiel-cms-toolbar">
<a class="kiel-cms-btn kiel-cms-btn--primary" href="{{ route('admin.cms.posts.create') }}">Nouvelle actualité</a>
</div>
<form class="kiel-cms-filters" method="get" action="{{ route('admin.cms.posts.index') }}" data-cms-auto-filter>
<label class="kiel-cms-filters__field kiel-cms-filters__field--grow">
<span>Recherche</span>
<input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Titre, extrait, slug…" maxlength="120"/>
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
<a class="kiel-cms-btn kiel-cms-btn--soft" href="{{ route('admin.cms.posts.index') }}">Réinitialiser</a>
</div>
</form>
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead><tr><th>Titre</th><th>Publication</th><th class="kiel-cms-table__col-actions">Actions</th></tr></thead>
<tbody>
@forelse($posts as $post)
<tr>
<td><span class="kiel-cms-table__primary">{{ $post->title }}</span></td>
<td>{{ $post->published_at?->format('d/m/Y') ?? '—' }}</td>
<td class="kiel-cms-table__col-actions">
<div class="kiel-cms-table__actions">
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--edit" href="{{ route('admin.cms.posts.edit', $post) }}">Modifier</a>
<form method="post" action="{{ route('admin.cms.posts.destroy', $post) }}" onsubmit="return confirm('Supprimer cette actualité ?');">
@csrf
@method('DELETE')
<button type="submit" class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--danger">Supprimer</button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="3" class="kiel-cms-table__empty">Aucune actualité pour ces critères.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="kiel-cms-pagination">{{ $posts->links() }}</div>
</div>
@endsection
