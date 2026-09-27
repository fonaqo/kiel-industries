@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-auth.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/account/kiel-auth.js') }}" defer></script>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] kiel-auth-page">
<div class="kiel-wrap kiel-auth-simple">
<h1 class="kiel-auth-simple__title">Nouveau mot de passe</h1>
<p class="kiel-auth-simple__lead">Choisissez un mot de passe sécurisé pour votre compte KIEL.</p>
@if($errors->any())
<ul class="kiel-auth-errors">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
@endif
<form class="kiel-auth-form" method="post" action="{{ route('password.update') }}">
@csrf
<input type="hidden" name="token" value="{{ $token }}"/>
<label>E-mail<input name="email" required type="email" value="{{ old('email', $email) }}" autocomplete="username" placeholder="vous@exemple.com"/></label>
<label>Nouveau mot de passe
<span class="kiel-auth-password">
<input name="password" required type="password" autocomplete="new-password" placeholder="8 caractères minimum"/>
<button type="button" class="kiel-auth-password__toggle" data-kiel-password-toggle aria-label="Afficher le mot de passe"><span class="material-symbols-outlined">visibility</span></button>
</span>
</label>
<label>Confirmer le mot de passe
<span class="kiel-auth-password">
<input name="password_confirmation" required type="password" autocomplete="new-password" placeholder="Répétez le mot de passe"/>
<button type="button" class="kiel-auth-password__toggle" data-kiel-password-toggle aria-label="Afficher le mot de passe"><span class="material-symbols-outlined">visibility</span></button>
</span>
</label>
<button class="kiel-btn kiel-btn--primary kiel-auth-form__submit" type="submit">Enregistrer</button>
</form>
</div>
</main>
@endsection
