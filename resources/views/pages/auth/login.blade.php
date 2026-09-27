@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-auth.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/account/kiel-auth.js') }}" defer></script>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface kiel-auth-page">
<div class="kiel-wrap kiel-auth-simple">
<h1 class="kiel-auth-simple__title">Connexion</h1>
<p class="kiel-auth-simple__lead">Accédez à votre espace client KIEL INDUSTRIES.</p>
@if($errors->any())
<div class="kiel-auth-errors">{{ $errors->first() }}</div>
@endif
@if(session('status'))
<div class="kiel-auth-status">{{ session('status') }}</div>
@endif
<a class="kiel-auth-google" href="{{ route('auth.google.redirect') }}" data-turbo="false">
<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
Continuer avec Google
</a>
<p class="kiel-auth-divider"><span>ou</span></p>
<form class="kiel-auth-form" method="post" action="{{ route('login.store') }}">
@csrf
<label>E-mail<input name="email" required type="email" value="{{ old('email') }}" autocomplete="username" placeholder="vous@exemple.com"/></label>
<label>Mot de passe
<span class="kiel-auth-password">
<input name="password" required type="password" autocomplete="current-password" placeholder="Votre mot de passe"/>
<button type="button" class="kiel-auth-password__toggle" data-kiel-password-toggle aria-label="Afficher le mot de passe"><span class="material-symbols-outlined">visibility</span></button>
</span>
</label>
<p class="kiel-auth-forgot"><a href="{{ route('password.request') }}">Mot de passe oublié ?</a></p>
<label class="kiel-auth-form__remember"><input type="checkbox" name="remember" value="1"/> Se souvenir de moi</label>
<button class="kiel-btn kiel-btn--primary kiel-auth-form__submit" type="submit">Se connecter</button>
</form>
<p class="kiel-auth-footer">Pas encore de compte ? <a href="{{ route('register', request()->only('redirect')) }}">Créer un compte</a></p>
</div>
</main>
@endsection
