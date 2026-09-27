@php
  /** @var \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Support\Enumerable $orders */
  $variant = $variant ?? 'account';
  $showClient = $variant === 'admin';
  $detailRoute = $showClient ? 'admin.orders.show' : 'account.orders.show';
  $turboFrame = $showClient ? 'admin-main' : 'account-main';
  $isClient = ! $showClient;
@endphp
<div class="kiel-orders-panel">
<div class="kiel-orders-table-wrap">
<table class="kiel-orders-table">
<thead>
<tr>
<th>Référence</th>
@if($showClient)
<th>Client</th>
@endif
<th>Date</th>
<th class="kiel-orders-table__col-num">Articles</th>
<th class="kiel-orders-table__col-amount">Total</th>
<th>Statut</th>
<th class="kiel-orders-table__col-action"><span class="sr-only">Action</span></th>
</tr>
</thead>
<tbody>
@foreach($orders as $order)
<tr>
<td class="kiel-orders-table__ref"@if($isClient) data-label="Référence"@endif>
<a href="{{ route($detailRoute, $order) }}" data-turbo-frame="{{ $turboFrame }}">{{ $order->reference }}</a>
</td>
@if($showClient)
<td class="kiel-orders-table__client">
<span class="kiel-orders-table__client-name">{{ $order->customer_name }}</span>
<span class="kiel-orders-table__client-email">{{ $order->customer_email }}</span>
</td>
@endif
<td class="kiel-orders-table__date"@if($isClient) data-label="Date"@endif>
<time datetime="{{ $order->created_at->toIso8601String() }}">{{ $order->created_at->format('d/m/Y') }}</time>
<span class="kiel-orders-table__time">{{ $order->created_at->format('H:i') }}</span>
</td>
<td class="kiel-orders-table__col-num"@if($isClient) data-label="Articles"@endif>{{ $order->items_count ?? $order->items->count() }}</td>
<td class="kiel-orders-table__col-amount"@if($isClient) data-label="Total"@endif><strong>{{ number_format($order->total_fcfa, 0, ',', ' ') }} FCFA</strong></td>
<td class="kiel-orders-table__status"@if($isClient) data-label="Statut"@endif>@include('partials.order-status', ['status' => $order->status])</td>
<td class="kiel-orders-table__col-action">
<a class="kiel-orders-table__link" href="{{ route($detailRoute, $order) }}" data-turbo-frame="{{ $turboFrame }}">Détail</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
