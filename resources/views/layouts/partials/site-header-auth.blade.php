@auth
<div class="kiel-header-account hidden lg:block">
<button type="button" class="kiel-header-account__trigger" id="kiel-header-account-trigger" aria-expanded="false" aria-haspopup="true" aria-controls="kiel-header-account-menu">
Mon compte
<span class="material-symbols-outlined" aria-hidden="true">expand_more</span>
</button>
<div class="kiel-header-account__menu" id="kiel-header-account-menu" role="menu" hidden>
<a role="menuitem" href="{{ route('account.dashboard') }}">Tableau de bord</a>
<a role="menuitem" href="{{ route('account.orders') }}">Mes commandes</a>
<a role="menuitem" href="{{ route('account.profile') }}">Mon profil</a>
<a role="menuitem" href="{{ route('account.wishlist') }}">Mes favoris</a>
@if(auth()->user()->is_super_admin)
<a role="menuitem" href="{{ route('admin.cms.dashboard') }}">Administration boutique</a>
@endif
<form method="post" action="{{ route('logout') }}" data-turbo="false" role="none">
@csrf
<button type="submit" class="kiel-header-account__logout" role="menuitem">Déconnexion</button>
</form>
</div>
</div>
@endauth
