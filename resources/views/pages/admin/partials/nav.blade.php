@php
  $user = auth()->user();
@endphp
@if($user)
<aside class="kiel-account-sidebar" aria-label="Administration">
<div class="kiel-account-sidebar__profile">
<img class="kiel-account-sidebar__avatar" src="{{ $user->avatar_url }}" alt="" width="72" height="72"/>
<p class="kiel-account-sidebar__name">{{ $user->display_name }}</p>
<p class="kiel-account-sidebar__meta">Administration KIEL</p>
</div>
<ul class="kiel-account-sidebar__nav">
<li><a href="{{ route('admin.dashboard') }}" data-turbo-frame="admin-main" data-sidebar-nav @class(['is-active' => request()->routeIs('admin.dashboard')])>Tableau de bord</a></li>
<li><a href="{{ route('admin.orders') }}" data-turbo-frame="admin-main" data-sidebar-nav @class(['is-active' => request()->routeIs('admin.orders') || request()->routeIs('admin.orders.show')])>Commandes</a></li>
<li><a href="{{ route('admin.users') }}" data-turbo-frame="admin-main" data-sidebar-nav @class(['is-active' => request()->routeIs('admin.users')])>Utilisateurs</a></li>
<li><a href="{{ route('admin.wishlist') }}" data-turbo-frame="admin-main" data-sidebar-nav @class(['is-active' => request()->routeIs('admin.wishlist')])>Mes favoris</a></li>
</ul>
<form class="kiel-account-sidebar__logout" method="post" action="{{ route('logout') }}" data-turbo="false">
@csrf
<button type="submit">Déconnexion</button>
</form>
</aside>
@endif
