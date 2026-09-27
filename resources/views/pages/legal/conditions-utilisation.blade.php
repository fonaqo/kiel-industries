@extends('pages.legal._layout')

@php
  $legalTitle = 'Conditions d\'utilisation';
  $legalLead = 'Règles d\'accès et d\'usage du site et des services en ligne KIEL INDUSTRIES.';
  $legalCurrent = 'Conditions d\'utilisation';
@endphp

@section('legal-content')
<h2>Objet</h2>
<p>Les présentes conditions régissent l'utilisation du site KIEL INDUSTRIES (vitrine, boutique, compte client).</p>

<h2>Compte et usage</h2>
<p>Vous vous engagez à fournir des informations exactes, à protéger vos identifiants et à ne pas utiliser le site de manière illicite ou abusive.</p>

<h2>Propriété intellectuelle</h2>
<p>Marque, logo, textes et visuels sont protégés. Toute reproduction non autorisée est interdite.</p>

<h2>Ventes</h2>
<p>Les commandes sont régies par nos <a href="{{ route('conditions-generales') }}">conditions générales de vente (CGV)</a>.</p>

<h2>Données personnelles</h2>
<p>Voir la <a href="{{ route('politique-confidentialite') }}">politique de confidentialité</a>.</p>

<h2>Contact</h2>
<p><a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a> · <a href="{{ route('contact') }}">Formulaire contact</a></p>
@endsection
