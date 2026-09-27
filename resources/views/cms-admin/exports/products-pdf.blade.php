<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title>Export produits</title>
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
<h1>Catalogue produits KIEL</h1>
<p class="meta">Généré le {{ $generatedAt->format('d/m/Y à H:i') }} · {{ $products->count() }} produit(s)</p>
<table>
<thead>
<tr>
<th>Nom</th>
<th>Catégorie</th>
<th>FCFA</th>
<th>EUR</th>
<th>USD</th>
<th>Stock</th>
<th>Actif</th>
</tr>
</thead>
<tbody>
@foreach($products as $product)
<tr>
<td>{{ $product->name }}</td>
<td>{{ $product->category?->name ?? '—' }}</td>
<td>{{ number_format($product->price_fcfa, 0, ',', ' ') }}</td>
<td>{{ $product->price_eur !== null ? number_format((float) $product->price_eur, 2, ',', ' ') : '—' }}</td>
<td>{{ $product->price_usd !== null ? number_format((float) $product->price_usd, 2, ',', ' ') : '—' }}</td>
<td>{{ $product->stock }}</td>
<td>{{ $product->is_active ? 'Oui' : 'Non' }}</td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
