@php
  $name = trim($payload['prenom'].' '.$payload['nom']);
  $headline = 'Nouveau message contact';
  $preheader = $name.' a écrit via le formulaire du site.';
@endphp
@extends('emails.layouts.kiel')

@section('content')
<p style="margin:0 0 16px;">Vous avez reçu un message depuis la page <strong>Contact</strong> du site KIEL INDUSTRIES.</p>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:0 0 20px;border-collapse:collapse;font-size:14px;">
<tr>
<td style="padding:8px 0;border-bottom:1px solid rgba(216,193,195,.4);color:#534344;width:120px;">Nom</td>
<td style="padding:8px 0;border-bottom:1px solid rgba(216,193,195,.4);font-weight:700;color:#2c000a;">{{ $name }}</td>
</tr>
<tr>
<td style="padding:8px 0;border-bottom:1px solid rgba(216,193,195,.4);color:#534344;">E-mail</td>
<td style="padding:8px 0;border-bottom:1px solid rgba(216,193,195,.4);"><a href="mailto:{{ $payload['email'] }}" style="color:#318135;font-weight:600;">{{ $payload['email'] }}</a></td>
</tr>
</table>
<p style="margin:0 0 8px;font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#318135;">Message</p>
<div style="margin:0;padding:16px 18px;border-radius:12px;background:#f8faf8;border:1px solid rgba(49,129,53,.15);font-size:14px;line-height:1.65;color:#2c000a;white-space:pre-wrap;">{{ $payload['message'] }}</div>
<p style="margin:20px 0 0;font-size:13px;color:#534344;">Répondez directement à cet e-mail pour contacter {{ $payload['prenom'] }}.</p>
@endsection
