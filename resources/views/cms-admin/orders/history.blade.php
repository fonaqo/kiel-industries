@extends('layouts.cms-admin')

@push('head')
<link href="{{ asset('assets/css/account/kiel-admin-orders.css') }}" rel="stylesheet"/>
@endpush

@section('panel')
<div class="kiel-cms-list-panel">
<div class="kiel-cms-toolbar kiel-cms-toolbar--wrap">
<a class="kiel-cms-btn kiel-cms-btn--secondary kiel-cms-btn--sm" href="{{ route('admin.orders') }}">← Retour aux commandes</a>
</div>
<p class="kiel-cms-toolbar__exports-label" style="margin:0.75rem 0 0.35rem">Historique de gestion</p>
<p class="kiel-cms-table__sub" style="margin:0 0 1rem">Consultations de fiches commande et changements de statut par l’équipe admin.</p>
@if($logs->isEmpty())
<div class="kiel-cms-empty-state">
<span class="material-symbols-outlined" aria-hidden="true">history</span>
<p>Aucune activité enregistrée pour le moment.</p>
</div>
@else
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead>
<tr>
<th>Date</th>
<th>Utilisateur</th>
<th>Activité</th>
<th>Commande</th>
</tr>
</thead>
<tbody>
@foreach($logs as $log)
<tr>
<td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
<td>
<span class="kiel-cms-table__primary">{{ $log->user?->name ?? 'Compte supprimé' }}</span>
@if($log->user?->email)
<div class="kiel-cms-table__sub">{{ $log->user->email }}</div>
@endif
</td>
<td>{{ $log->summary }}</td>
<td>
@if($log->order)
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--soft" href="{{ route('admin.orders.show', $log->order) }}">{{ $log->order->reference }}</a>
@else
<span class="kiel-cms-table__muted">{{ $log->properties['order_reference'] ?? 'N/A' }}</span>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="kiel-cms-pagination">{{ $logs->links() }}</div>
@endif
</div>
@endsection
