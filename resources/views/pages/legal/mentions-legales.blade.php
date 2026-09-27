@extends('pages.legal._layout')

@php
  $legalTitle = 'Mentions légales';
  $legalLead = 'Informations légales relatives à KIEL INDUSTRIES, éditeur du site et hébergement.';
  $legalCurrent = 'Mentions légales';
@endphp

@section('legal-content')
<h2>Éditeur du site</h2>
<p><strong>KIEL INDUSTRIES</strong>, entreprise béninoise au Borgou.<br/>
Siège : Parakou, Bénin · IFU : 0201710192397<br/>
Téléphone : <a href="tel:+2290165728584">+229 01 65 72 85 84</a><br/>
E-mail : <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a></p>

<h2>Directeur de la publication</h2>
<p>La direction générale de KIEL INDUSTRIES.</p>

<h2>Hébergement</h2>
<p>Les informations d’hébergement sont communiquées sur demande auprès de l’équipe KIEL. Pour toute question technique, contactez-nous via la page <a href="{{ route('contact') }}">Contact</a>.</p>

<h2>Propriété intellectuelle</h2>
<p>Textes, visuels, marque KIEL, logo et contenus du site sont protégés. Toute reproduction sans autorisation écrite est interdite.</p>

<h2>Crédits</h2>
<p>Conception et contenus : KIEL INDUSTRIES. Partenaires institutionnels : OAPI, PAVRIB, Land Accelerator.</p>

<h2>Conception technique</h2>
<p>Site web développé par <strong>{{ config('kiel.site_credit.company', 'Fonaqo SARL') }}</strong>@if(config('kiel.site_credit.url')) (<a href="{{ config('kiel.site_credit.url') }}" rel="noopener noreferrer" target="_blank">{{ parse_url(config('kiel.site_credit.url'), PHP_URL_HOST) ?: config('kiel.site_credit.url') }}</a>)@endif, pour le compte de KIEL INDUSTRIES.</p>
@endsection
