@extends('layouts.cms-admin')

@section('panel')
<div class="kiel-cms-list-panel">
<div class="kiel-cms-form__actions">
<a class="kiel-cms-btn kiel-cms-btn--secondary" href="{{ route('admin.cms.dashboard') }}">← Tableau de bord</a>
</div>
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead><tr><th>Page</th><th>Section</th><th>Statut</th><th class="kiel-cms-table__col-actions">Actions</th></tr></thead>
<tbody>
@foreach($pages as $p)
<tr>
<td>
<span class="kiel-cms-table__primary">{{ $p->title }}</span>
<span class="kiel-cms-table__sub">{{ $p->slug }}</span>
</td>
<td>{{ $p->section }}</td>
<td>@if($p->is_published)<span class="kiel-cms-badge">Publié</span>@else <span class="kiel-cms-table__muted">Brouillon</span> @endif</td>
<td class="kiel-cms-table__col-actions"><a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--edit" href="{{ route('admin.cms.pages.edit', $p) }}">Modifier</a></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection
