@php
  $user = auth()->user();
@endphp
@if($user)
<aside class="kiel-account-sidebar" aria-label="Espace client">
<div class="kiel-account-sidebar__profile">
<img class="kiel-account-sidebar__avatar" src="{{ $user->avatar_url }}" alt="" width="72" height="72" onerror="this.onerror=null;this.src='{{ asset('assets/img/account/default-avatar.svg') }}';"/>
<p class="kiel-account-sidebar__name">{{ $user->display_name }}</p>
<p class="kiel-account-sidebar__meta">Mon espace KIEL</p>
</div>
<ul class="kiel-account-sidebar__nav">
<li><a href="{{ route('account.dashboard') }}" data-turbo-frame="account-main" data-sidebar-nav @class(['is-active' => request()->routeIs('account.dashboard')])>Tableau de bord</a></li>
<li><a href="{{ route('account.orders') }}" data-turbo-frame="account-main" data-sidebar-nav @class(['is-active' => request()->routeIs('account.orders') || request()->routeIs('account.orders.show')])>Mes commandes</a></li>
<li><a href="{{ route('account.profile') }}" data-turbo-frame="account-main" data-sidebar-nav @class(['is-active' => request()->routeIs('account.profile')])>Mon profil</a></li>
<li><a href="{{ route('account.wishlist') }}" data-turbo-frame="account-main" data-sidebar-nav @class(['is-active' => request()->routeIs('account.wishlist')])>Mes favoris</a></li>
<li><a href="{{ route('panier') }}" data-turbo-frame="account-main" data-sidebar-nav @class(['is-active' => request()->routeIs('panier')])>Mon panier</a></li>
</ul>
<form class="kiel-account-sidebar__logout" method="post" action="{{ route('logout') }}" data-turbo="false">
@csrf
<button type="submit">Déconnexion</button>
</form>
</aside>
@endif
