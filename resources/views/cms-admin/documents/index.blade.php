@extends('layouts.cms-admin')

@section('panel')
<div class="kiel-cms-list-panel">
<div class="kiel-cms-toolbar">
<a class="kiel-cms-btn kiel-cms-btn--primary" href="{{ route('admin.cms.documents.create') }}">Nouveau document</a>
</div>
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead><tr><th>Titre</th><th>Catégorie</th><th>Fichier</th><th class="kiel-cms-table__col-actions">Actions</th></tr></thead>
<tbody>
@forelse($documents as $doc)
<tr>
<td><span class="kiel-cms-table__primary">{{ $doc->title }}</span></td>
<td>{{ $categories[$doc->category] ?? $doc->category }}</td>
<td>@if($doc->fileUrl())<a href="{{ $doc->fileUrl() }}" target="_blank" rel="noopener">Voir</a>@else—@endif</td>
<td class="kiel-cms-table__col-actions">
<div class="kiel-cms-table__actions">
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--edit" href="{{ route('admin.cms.documents.edit', $doc) }}">Modifier</a>
<form method="post" action="{{ route('admin.cms.documents.destroy', $doc) }}" onsubmit="return confirm('Supprimer ce document ?');">
@csrf @method('DELETE')
<button type="submit" class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--danger">Supprimer</button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="4" class="kiel-cms-table__empty">Aucun document.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="kiel-cms-pagination">{{ $documents->links() }}</div>
</div>
@endsection
