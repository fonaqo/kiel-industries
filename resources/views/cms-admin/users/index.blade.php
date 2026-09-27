@extends('layouts.cms-admin')

@section('panel')
<div class="kiel-cms-list-panel">
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead><tr><th>Client</th><th>E-mail</th><th>Téléphone</th><th>Rôle</th><th>Inscription</th></tr></thead>
<tbody>
@forelse($users as $user)
<tr>
<td><span class="kiel-cms-table__primary">{{ $user->display_name }}</span></td>
<td><a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--soft" href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
<td>{{ $user->phone ?: '—' }}</td>
<td>
@if($user->is_super_admin)<span class="kiel-cms-badge">Super admin</span>
@elseif($user->is_admin)<span class="kiel-cms-badge kiel-cms-badge--muted">Admin</span>
@else <span class="kiel-cms-table__muted">Client</span> @endif
</td>
<td>{{ $user->created_at->format('d/m/Y') }}</td>
</tr>
@empty
<tr><td colspan="5" class="kiel-cms-table__empty">Aucun utilisateur.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="kiel-cms-pagination">{{ $users->links() }}</div>
</div>
@endsection
