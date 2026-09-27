@php
  $logoFile = public_path('assets/img/brand/logo-kiel.png');
  if (! is_readable($logoFile)) {
      $logoFile = public_path('assets/img/brand/logo-kiel.svg');
  }
  $logoSrc = is_readable($logoFile) ? $logoFile : null;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<style>
  body { font-family: DejaVu Sans, sans-serif; color: #2c000a; font-size: 12px; margin: 0; padding: 24px; }
  .head { border-bottom: 3px solid #318135; padding-bottom: 14px; margin-bottom: 20px; }
  .head__row { width: 100%; border-collapse: collapse; }
  .head__logo { width: 160px; vertical-align: middle; }
  .head__logo img { max-width: 150px; max-height: 56px; height: auto; }
  .head__meta { vertical-align: middle; text-align: right; }
  .brand { font-size: 18px; font-weight: bold; color: #2c000a; }
  .sub { color: #318135; font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; margin-top: 4px; }
  table.lines { width: 100%; border-collapse: collapse; margin-top: 16px; }
  table.lines th {
    background: #2c000a;
    color: #ffffff;
    text-align: left;
    padding: 9px 8px;
    font-size: 11px;
    font-weight: bold;
    border: 1px solid #2c000a;
  }
  table.lines th.align-right { text-align: right; }
  table.lines td { padding: 8px; border-bottom: 1px solid #e8d4d0; }
  .totals { margin-top: 16px; width: 100%; }
  .totals td { padding: 4px 0; }
  .totals .grand { font-size: 16px; font-weight: bold; color: #318135; }
  .foot { margin-top: 28px; font-size: 10px; color: #534344; border-top: 1px solid #d8c1c3; padding-top: 12px; }
</style>
</head>
<body>
<div class="head">
<table class="head__row"><tr>
<td class="head__logo">
@if($logoSrc)
<img src="{{ $logoSrc }}" alt="KIEL INDUSTRIES"/>
@else
<span class="brand">KIEL INDUSTRIES</span>
@endif
</td>
<td class="head__meta">
<div class="sub">Facture</div>
<div class="brand" style="margin-top:6px;font-size:14px;">Parakou, Borgou, Bénin</div>
</td>
</tr></table>
</div>
<p><strong>Réf. :</strong> {{ $order->reference }}<br/>
<strong>Date :</strong> {{ $order->created_at?->format('d/m/Y') }}<br/>
<strong>Client :</strong> {{ $order->customer_name }} · {{ $order->customer_email }}<br/>
<strong>Paiement :</strong> {{ $order->paymentMethodLabel() }} · <span style="color:#318135;font-weight:bold;">Réglé</span></p>
<table class="lines">
<thead>
<tr>
<th>Produit</th>
<th>Qté</th>
<th class="align-right">P.U. FCFA</th>
<th class="align-right">Total FCFA</th>
</tr>
</thead>
<tbody>
@foreach($order->items as $item)
<tr>
<td>{{ $item->product_name }}</td>
<td>{{ $item->quantity }}</td>
<td align="right">{{ number_format($item->unit_price_fcfa, 0, ',', ' ') }}</td>
<td align="right">{{ number_format($item->line_total_fcfa, 0, ',', ' ') }}</td>
</tr>
@endforeach
</tbody>
</table>
<table class="totals">
<tr><td>Sous-total</td><td align="right">{{ number_format($order->subtotal_fcfa, 0, ',', ' ') }} FCFA</td></tr>
<tr><td>Livraison</td><td align="right">{{ $order->shipping_fcfa ? number_format($order->shipping_fcfa, 0, ',', ' ').' FCFA' : 'Offerte' }}</td></tr>
<tr><td class="grand">Total TTC</td><td align="right" class="grand">{{ number_format($order->total_fcfa, 0, ',', ' ') }} FCFA</td></tr>
</table>
<div class="foot">
  IFU 0201710192397 · kielbienetre@gmail.com · Facture acquittée. Document généré automatiquement par KIEL INDUSTRIES.
</div>
</body>
</html>
