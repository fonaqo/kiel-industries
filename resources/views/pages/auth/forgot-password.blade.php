@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-auth.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface kiel-auth-page">
<div class="kiel-wrap kiel-auth-simple">
<h1 class="kiel-auth-simple__title">Mot de passe oublié</h1>
<p class="kiel-auth-simple__lead">Recevez un lien par e-mail pour réinitialiser votre mot de passe.</p>
@if($errors->any())
<div class="kiel-auth-errors">{{ $errors->first() }}</div>
@endif
@if(session('status'))
<div class="kiel-auth-status">{{ session('status') }}</div>
@endif
<form class="kiel-auth-form" method="post" action="{{ route('password.email') }}">
@csrf
<label>E-mail<input name="email" required type="email" value="{{ old('email') }}" autocomplete="username" placeholder="vous@exemple.com"/></label>
<button class="kiel-btn kiel-btn--primary kiel-auth-form__submit" type="submit">Envoyer le lien</button>
</form>
<p class="kiel-auth-footer"><a href="{{ route('login') }}">Retour à la connexion</a></p>
</div>
</main>
@endsection
