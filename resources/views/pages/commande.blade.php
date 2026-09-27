@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/shop/kiel-shop.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pages/kiel-contact-page.css') }}" rel="stylesheet"/>
@endpush

@section('content')
@php
  $form = $checkoutForm ?? [];
  $val = fn (string $key, mixed $default = '') => old($key, $form[$key] ?? $default);
@endphp
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface" data-checkout-page>

@include('layouts.partials.page-subhero', [
  'heroTitle' => 'Finaliser la commande',
  'heroLead' => 'Renseignez vos coordonnées de livraison. Le règlement s’effectue avant la confirmation, puis vous recevrez votre facture par e-mail.',
  'heroCurrent' => 'Commande',
])

<section class="kiel-section kiel-checkout-section">
<div class="kiel-wrap">
<form class="kiel-checkout-layout" method="post" action="{{ route('commande.store') }}" novalidate>
@csrf
<div class="kiel-checkout-delivery kiel-contact-v3-form">
<h2>Informations de livraison</h2>
<p class="kiel-checkout-delivery__intro">Tous les champs marqués d’un astérisque sont obligatoires pour préparer votre livraison.</p>

@if($errors->any())
<div class="kiel-checkout-errors" role="alert">
<p>Veuillez corriger les champs suivants :</p>
<ul>
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

@if(session('status'))
<p class="kiel-checkout-auth-hint">{{ session('status') }}</p>
@elseif(! auth()->check())
<p class="kiel-checkout-auth-hint">Pour enregistrer votre commande, <a href="{{ route('login', ['redirect' => route('commande')]) }}">connectez-vous</a> ou <a href="{{ route('register', ['redirect' => route('commande')]) }}">créez un compte</a>. Vos informations ci-dessous seront conservées après connexion.</p>
@endif

<div class="kiel-form kiel-checkout-form">
<div class="kiel-form-row kiel-form-row--2">
<label>Nom complet <span class="kiel-form-required" aria-hidden="true">*</span>
<input name="customer_name" required type="text" value="{{ $val('customer_name', $user->name ?? '') }}" autocomplete="name" @class(['is-invalid' => $errors->has('customer_name')])/>
</label>
<label>E-mail <span class="kiel-form-required" aria-hidden="true">*</span>
<input name="customer_email" required type="email" value="{{ $val('customer_email', $user->email ?? '') }}" autocomplete="email" @class(['is-invalid' => $errors->has('customer_email')])/>
</label>
</div>
<div class="kiel-form-row kiel-form-row--2">
<label>Téléphone
<input name="customer_phone" type="tel" value="{{ $val('customer_phone', $user->phone ?? '') }}" autocomplete="tel" placeholder="+229 …" @class(['is-invalid' => $errors->has('customer_phone')])/>
</label>
<label>Ville
<input name="shipping_city" type="text" value="{{ $val('shipping_city', $user->city ?? 'Parakou') }}" autocomplete="address-level2" @class(['is-invalid' => $errors->has('shipping_city')])/>
</label>
</div>
<label>Adresse de livraison
<textarea name="shipping_address" rows="3" autocomplete="street-address" placeholder="Quartier, rue, repère…" @class(['is-invalid' => $errors->has('shipping_address')])>{{ $val('shipping_address', $user->address ?? '') }}</textarea>
</label>
<label>Notes (optionnel)
<textarea name="notes" rows="2" placeholder="Créneau, instructions pour le livreur…">{{ $val('notes') }}</textarea>
</label>
</div>
</div>

<aside class="kiel-panier-summary kiel-checkout-summary">
<h3>Récapitulatif</h3>
<ul class="kiel-checkout-summary__lines">
@foreach($cart['lines'] as $line)
<li><span>{{ $line['name'] }} × {{ $line['qty'] }}</span><strong>{{ number_format($line['price'] * $line['qty'], 0, ',', ' ') }} FCFA</strong></li>
@endforeach
</ul>
<p><span>Sous-total</span><strong>{{ number_format($cart['subtotal_fcfa'], 0, ',', ' ') }} FCFA</strong></p>
<p><span>Livraison</span><strong>{{ $cart['shipping_fcfa'] ? number_format($cart['shipping_fcfa'], 0, ',', ' ').' FCFA' : 'Offerte' }}</strong></p>
<p class="kiel-panier-summary__total"><span>Total</span><strong>{{ number_format($cart['total_fcfa'], 0, ',', ' ') }} FCFA</strong></p>
<p class="kiel-checkout-summary__note">Après validation, votre commande est considérée comme payée. Un e-mail avec la facture PDF vous sera envoyé.</p>
<button class="kiel-btn kiel-btn--primary kiel-panier-summary__cta" type="submit">Valider et payer ma commande</button>
</aside>
</form>
</div>
</section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  if (!document.querySelector('[data-checkout-page]') || !window.KielCart?.refresh) return;
  window.KielCart.refresh().catch(() => {});
});
</script>
@endpush
