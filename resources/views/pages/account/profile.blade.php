@extends('layouts.account')

@section('heroTitle', 'Mon profil')
@section('heroLead', 'Mettez à jour vos coordonnées et votre photo.')
@section('heroCurrent', 'Profil')

@section('panel')
<div class="kiel-profile-layout kiel-profile-layout--wide mt-1">
@if(session('status'))<p class="kiel-profile-flash">{{ session('status') }}</p>@endif
<form class="kiel-profile-layout__grid kiel-form kiel-profile-form" method="post" action="{{ route('account.profile.update') }}" enctype="multipart/form-data" data-turbo="false">
@csrf
@method('PUT')
<aside class="kiel-profile-layout__photo">
<div class="kiel-profile-photo-card">
<div class="kiel-profile-photo-card__preview">
<img src="{{ $user->avatar_url }}" alt="Photo de profil de {{ $user->display_name }}" width="160" height="160" data-kiel-profile-avatar onerror="this.onerror=null;this.src='{{ asset('assets/img/account/default-avatar.svg') }}';"/>
</div>
<h2 class="kiel-profile-photo-card__title">Photo de profil</h2>
<p class="kiel-profile-photo-card__hint">JPG, PNG ou WebP. Format carré recommandé.</p>
<label class="kiel-profile-photo-card__file">
<span class="material-symbols-outlined" aria-hidden="true">upload</span>
<span>Choisir une image</span>
<input name="avatar" type="file" accept="image/jpeg,image/png,image/webp" data-kiel-avatar-preview/>
</label>
</div>
</aside>
<div class="kiel-profile-layout__form">
<label>Nom<input name="name" required type="text" value="{{ old('name', $user->name) }}" autocomplete="name"/></label>
<label>E-mail<input name="email" required type="email" value="{{ old('email', $user->email) }}" autocomplete="email"/></label>
<label>Téléphone<input name="phone" type="tel" value="{{ old('phone', $user->phone) }}" autocomplete="tel"/></label>
<label>Ville<input name="city" type="text" value="{{ old('city', $user->city) }}" autocomplete="address-level2"/></label>
<label>Adresse<textarea name="address" rows="4" autocomplete="street-address">{{ old('address', $user->address) }}</textarea></label>
<button class="kiel-btn kiel-btn--primary kiel-profile-form__submit" type="submit">Enregistrer les modifications</button>
</div>
</form>
</div>
@endsection
