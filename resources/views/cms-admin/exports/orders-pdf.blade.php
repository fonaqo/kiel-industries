<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title>Export commandes</title>
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; }
h1 { font-size: 16px; color: #2c000a; margin: 0 0 4px; }
.meta { color: #64748b; margin-bottom: 16px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #e2e8f0; padding: 6px 8px; text-align: left; }
th { background: #f8fafc; font-size: 10px; }
</style>
</head>
<body>
<h1>Commandes KIEL</h1>
<p class="meta">Généré le {{ $generatedAt->format('d/m/Y à H:i') }} · {{ $orders->count() }} commande(s)</p>
<table>
<thead>
<tr>
<th>Réf.</th>
<th>Date</th>
<th>Client</th>
<th>Statut</th>
<th>Total FCFA</th>
</tr>
</thead>
<tbody>
@foreach($orders as $order)
<tr>
<td>{{ $order->reference }}</td>
<td>{{ $order->created_at?->format('d/m/Y H:i') }}</td>
<td>{{ $order->customer_name }}<br/>{{ $order->customer_email }}</td>
<td>{{ $order->status }}</td>
<td>{{ number_format($order->total_fcfa, 0, ',', ' ') }}</td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
