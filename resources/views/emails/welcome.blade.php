@php
  $headline = 'Bienvenue chez KIEL INDUSTRIES';
  $preheader = 'Votre compte est prêt. Découvrez la filière baobab du Borgou.';
@endphp
@extends('emails.layouts.kiel')

@section('content')
<p style="margin:0 0 16px;">Bonjour <strong style="color:#2c000a;">{{ $user->display_name ?? $user->name }}</strong>,</p>
<p style="margin:0 0 16px;">Merci de rejoindre la communauté KIEL. Votre espace client vous permet de suivre vos commandes, gérer vos favoris et retrouver l’ensemble de nos produits issus de la filière baobab.</p>
<table role="presentation" cellspacing="0" cellpadding="0" style="margin:20px 0;">
<tr><td style="border-radius:999px;background:#318135;">
<a href="{{ route('boutique') }}" style="display:inline-block;padding:12px 22px;font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#fff;text-decoration:none;">Découvrir la boutique</a>
</td></tr>
</table>
<p style="margin:0;">À très bientôt sur <a href="{{ route('home') }}" style="color:#318135;font-weight:700;">{{ parse_url(config('app.url'), PHP_URL_HOST) ?: 'notre site' }}</a>.</p>
@endsection
