@php
  $headline = 'Commande '.$order->reference;
  $preheader = 'Votre commande est payée. Facture en pièce jointe.';
@endphp
@extends('emails.layouts.kiel')

@section('content')
<p style="margin:0 0 16px;">Bonjour <strong style="color:#2c000a;">{{ $order->customer_name }}</strong>,</p>
<p style="margin:0 0 20px;">Votre paiement a bien été enregistré. Merci pour votre commande : vous trouverez en pièce jointe votre <strong>facture</strong> au format PDF.</p>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:0 0 20px;border-collapse:collapse;">
@foreach($order->items as $item)
<tr>
<td style="padding:8px 0;border-bottom:1px solid rgba(216,193,195,.4);font-size:14px;">{{ $item->product_name }} × {{ $item->quantity }}</td>
<td align="right" style="padding:8px 0;border-bottom:1px solid rgba(216,193,195,.4);font-size:14px;font-weight:700;color:#2c000a;">{{ number_format($item->line_total_fcfa, 0, ',', ' ') }} FCFA</td>
</tr>
@endforeach
<tr>
<td style="padding:10px 0;font-size:14px;">Sous-total</td>
<td align="right" style="padding:10px 0;font-size:14px;">{{ number_format($order->subtotal_fcfa, 0, ',', ' ') }} FCFA</td>
</tr>
<tr>
<td style="padding:4px 0;font-size:14px;">Livraison</td>
<td align="right" style="padding:4px 0;font-size:14px;">{{ $order->shipping_fcfa ? number_format($order->shipping_fcfa, 0, ',', ' ').' FCFA' : 'Offerte' }}</td>
</tr>
<tr>
<td style="padding:12px 0 0;font-size:16px;font-weight:800;color:#318135;">Total</td>
<td align="right" style="padding:12px 0 0;font-size:16px;font-weight:800;color:#318135;">{{ number_format($order->total_fcfa, 0, ',', ' ') }} FCFA</td>
</tr>
</table>
@if($order->shipping_address || $order->shipping_city)
<p style="margin:0 0 8px;font-size:13px;"><strong>Livraison :</strong> {{ trim($order->shipping_address.' '.$order->shipping_city) }}</p>
@endif
@if($order->customer_phone)
<p style="margin:0 0 16px;font-size:13px;"><strong>Téléphone :</strong> {{ $order->customer_phone }}</p>
@endif
<p style="margin:0 0 12px;font-size:13px;"><strong>Statut :</strong> {{ \App\Support\OrderStatus::label($order->status) }} · <strong>Mode de paiement :</strong> {{ $order->paymentMethodLabel() }}</p>
<p style="margin:0;font-size:14px;">Nous préparons votre commande. Vous serez informé lors de l’expédition. Questions ? Répondez à cet e-mail ou contactez-nous via le site.</p>
@endsection
