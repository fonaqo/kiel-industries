@extends('layouts.cms-admin')

@section('panel')
@php
  $filters = $filters ?? [];
@endphp
<div class="kiel-cms-list-panel">
<div class="kiel-cms-toolbar kiel-cms-toolbar--wrap">
<a class="kiel-cms-btn kiel-cms-btn--primary" href="{{ route('admin.cms.tips.create') }}">Nouvelle vidéo</a>
</div>
<form class="kiel-cms-filters" method="get" action="{{ route('admin.cms.tips.index') }}" data-cms-auto-filter>
<label class="kiel-cms-filters__field kiel-cms-filters__field--grow">
<span>Recherche</span>
<input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Titre, description, ID YouTube…" maxlength="120"/>
</label>
<label class="kiel-cms-filters__field">
<span>Catégorie</span>
<select name="cat">
<option value="">Toutes</option>
@foreach($categories as $key => $label)
<option value="{{ $key }}" @selected(($filters['cat'] ?? '') === $key)>{{ $label }}</option>
@endforeach
</select>
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
<a class="kiel-cms-btn kiel-cms-btn--soft" href="{{ route('admin.cms.tips.index') }}">Réinitialiser</a>
</div>
</form>
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead><tr><th>Titre</th><th>Catégorie</th><th>YouTube</th><th>Publiée</th><th class="kiel-cms-table__col-actions">Actions</th></tr></thead>
<tbody>
@forelse($videos as $video)
<tr>
<td><span class="kiel-cms-table__primary">{{ $video->title }}</span></td>
<td>{{ $categories[$video->category] ?? $video->category ?? '—' }}</td>
<td><code class="kiel-cms-code">{{ $video->youtube_id }}</code></td>
<td>{{ $video->is_published ? ($video->published_at?->format('d/m/Y') ?? 'Oui') : 'Non' }}</td>
<td class="kiel-cms-table__col-actions">
<div class="kiel-cms-table__actions">
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--edit" href="{{ route('admin.cms.tips.edit', $video) }}">Modifier</a>
<form method="post" action="{{ route('admin.cms.tips.destroy', $video) }}" onsubmit="return confirm('Supprimer cette vidéo ?');">
@csrf @method('DELETE')
<button type="submit" class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--danger">Supprimer</button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="5" class="kiel-cms-table__empty">Aucune vidéo pour ces critères.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="kiel-cms-pagination">{{ $videos->links() }}</div>
</div>
@endsection
