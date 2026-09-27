@extends('pages.legal._layout')

@php
  $legalTitle = 'Politique de confidentialité';
  $legalLead = 'Comment KIEL INDUSTRIES collecte, utilise et protège vos données sur la boutique et le site vitrine.';
  $legalCurrent = 'Confidentialité';
@endphp

@section('legal-content')
<h2>Responsable du traitement</h2>
<p>KIEL INDUSTRIES (Parakou, Bénin) est responsable des traitements décrits ci-dessous. Contact : <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a>.</p>

<h2>Données collectées</h2>
<ul>
<li>Identité et coordonnées lors d’une commande ou d’un message via le formulaire de contact.</li>
<li>Données de navigation techniques (cookies essentiels, journaux serveur) pour la sécurité et le bon fonctionnement du site.</li>
<li>Préférences boutique (panier local, devise affichée) lorsque vous utilisez la boutique en ligne.</li>
</ul>

<h2>Finalités</h2>
<p>Traitement des commandes, livraison, service client, réponse aux demandes B2B et partenariats, amélioration du site et respect des obligations légales.</p>

<h2>Conservation</h2>
<p>Les données liées aux commandes sont conservées pendant la durée nécessaire à la gestion commerciale et aux obligations comptables. Les messages de contact sont conservés le temps du traitement de la demande.</p>

<h2>Vos droits</h2>
<p>Vous pouvez demander l’accès, la rectification ou l’effacement de vos données, ainsi que vous opposer à certains traitements, en écrivant à <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a>.</p>

<h2>Cookies</h2>
<p>Seuls les cookies nécessaires au fonctionnement (session, panier, préférences) sont utilisés par défaut. Toute évolution sera mentionnée sur cette page.</p>

<h2>Conditions de vente</h2>
<p>Les commandes passées sur la boutique KIEL INDUSTRIES sont régies par nos <a href="{{ route('conditions-generales') }}">conditions générales de vente (CGV)</a> : prix en FCFA, modalités de livraison au Bénin, délais, droit de rétractation et responsabilités du vendeur.</p>
@endsection
