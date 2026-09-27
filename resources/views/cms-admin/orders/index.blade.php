@extends('layouts.cms-admin')

@push('head')
<link href="{{ asset('assets/css/account/kiel-admin-orders.css') }}" rel="stylesheet"/>
@endpush

@section('panel')
<div class="kiel-cms-list-panel">
<div class="kiel-cms-toolbar kiel-cms-toolbar--wrap">
<a class="kiel-cms-btn kiel-cms-btn--secondary kiel-cms-btn--sm" href="{{ route('admin.orders.history') }}">
<span class="material-symbols-outlined" aria-hidden="true">history</span>
Historique
</a>
<div class="kiel-cms-toolbar__exports">
<span class="kiel-cms-toolbar__exports-label">Exporter les commandes</span>
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--soft" href="{{ route('admin.orders.export', 'excel') }}">Excel</a>
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--soft" href="{{ route('admin.orders.export', 'pdf') }}">PDF</a>
</div>
</div>
@if($orders->isEmpty())
<div class="kiel-cms-empty-state">
<span class="material-symbols-outlined" aria-hidden="true">inbox</span>
<p>Aucune commande à afficher.</p>
</div>
@else
<div class="kiel-cms-table-wrap">
<table class="kiel-cms-table kiel-cms-table--hover">
<thead>
<tr>
<th>Référence</th>
<th>Client</th>
<th>Date</th>
<th>Articles</th>
<th>Total</th>
<th>Statut</th>
<th class="kiel-cms-table__col-actions">Actions</th>
</tr>
</thead>
<tbody>
@foreach($orders as $order)
<tr>
<td><span class="kiel-cms-code">{{ $order->reference }}</span></td>
<td>
<div class="kiel-cms-table__primary">{{ $order->customer_name }}</div>
<div class="kiel-cms-table__sub">{{ $order->customer_email }}</div>
</td>
<td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
<td>{{ $order->items_count }}</td>
<td><strong>{{ number_format($order->total_fcfa, 0, ',', ' ') }} FCFA</strong></td>
<td>@include('partials.order-status', ['status' => $order->status])</td>
<td class="kiel-cms-table__col-actions">
<a class="kiel-cms-btn kiel-cms-btn--xs kiel-cms-btn--edit kiel-cms-btn--wrap" href="{{ route('admin.orders.show', $order) }}">Détail</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="kiel-cms-pagination">{{ $orders->links() }}</div>
@endif
</div>
@endsection
