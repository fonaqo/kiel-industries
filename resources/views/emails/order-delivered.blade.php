@php
  $headline = 'Merci, commande livrée';
  $preheader = 'Votre commande '.$order->reference.' est entre vos mains.';
@endphp
@extends('emails.layouts.kiel')

@section('content')
<p style="margin:0 0 16px;">Bonjour <strong style="color:#2c000a;">{{ $order->customer_name }}</strong>,</p>
<p style="margin:0 0 16px;">Votre commande <strong>{{ $order->reference }}</strong> est marquée comme <span style="color:#318135;font-weight:800;">livrée</span>. Merci d’avoir choisi KIEL INDUSTRIES et la filière baobab du Borgou.</p>
<p style="margin:0 0 20px;">Nous espérons que nos produits vous accompagneront au quotidien : nutrition, soins ou partage en famille.</p>
<table role="presentation" cellspacing="0" cellpadding="0" style="margin:0 0 8px;">
<tr><td style="border-radius:999px;background:#2c000a;">
<a href="{{ route('boutique') }}" style="display:inline-block;padding:12px 22px;font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#fff;text-decoration:none;">Commander à nouveau</a>
</td></tr>
</table>
<p style="margin:16px 0 0;font-size:13px;">Un avis ou une question ? Nous sommes à l’écoute : <a href="mailto:kielbienetre@gmail.com" style="color:#318135;">kielbienetre@gmail.com</a></p>
@endsection
