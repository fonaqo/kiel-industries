@php
$pageTitle = $title ?? null;
$showDashContext = request()->routeIs('admin.cms.dashboard');
$user = auth()->user();
$initial = strtoupper(substr($user->display_name, 0, 1));
@endphp
<header class="kiel-cms-appbar">
<button type="button" class="kiel-cms-appbar__menu" id="kiel-cms-nav-toggle" aria-expanded="false" aria-controls="kiel-cms-sidebar">
<span class="material-symbols-outlined" aria-hidden="true">menu</span>
<span class="kiel-cms-sr">Menu</span>
</button>
<div class="kiel-cms-appbar__titles">
@if(filled($pageTitle))
<h1 class="kiel-cms-appbar__title">{{ $pageTitle }}</h1>
@elseif($showDashContext)
<p class="kiel-cms-appbar__eyebrow">Administration</p>
<h1 class="kiel-cms-appbar__title">Tableau de bord</h1>
@else
<h1 class="kiel-cms-appbar__title">Administration</h1>
@endif
</div>
<div class="kiel-cms-appbar__actions">
<a class="kiel-cms-appbar__action" href="{{ route('boutique') }}" target="_blank" rel="noopener">
<span class="material-symbols-outlined" aria-hidden="true">storefront</span>
<span class="kiel-cms-appbar__action-label">Boutique</span>
</a>
<a class="kiel-cms-appbar__action" href="{{ route('home') }}" target="_blank" rel="noopener">
<span class="material-symbols-outlined" aria-hidden="true">language</span>
<span class="kiel-cms-appbar__action-label">Site</span>
</a>
<div class="kiel-cms-appbar__user-menu" id="kiel-cms-user-menu">
<button type="button" class="kiel-cms-appbar__user-trigger" id="kiel-cms-user-toggle" aria-expanded="false" aria-haspopup="true" aria-controls="kiel-cms-user-dropdown">
<span class="kiel-cms-appbar__avatar" aria-hidden="true">
<span class="material-symbols-outlined kiel-cms-appbar__avatar-icon">account_circle</span>
<span class="kiel-cms-appbar__avatar-initial">{{ $initial }}</span>
</span>
<span class="kiel-cms-appbar__user-meta">
<span class="kiel-cms-appbar__user-name">{{ $user->display_name }}</span>
<span class="kiel-cms-appbar__user-role">Super administrateur</span>
</span>
<span class="material-symbols-outlined kiel-cms-appbar__user-chevron" aria-hidden="true">expand_more</span>
</button>
<div class="kiel-cms-appbar__dropdown" id="kiel-cms-user-dropdown" hidden>
<div class="kiel-cms-appbar__dropdown-head">
<strong>{{ $user->display_name }}</strong>
<span>{{ $user->email }}</span>
</div>
<a href="{{ route('admin.cms.dashboard') }}"><span class="material-symbols-outlined">space_dashboard</span> Tableau de bord</a>
<a href="{{ route('admin.cms.settings.edit') }}"><span class="material-symbols-outlined">tune</span> Paramètres</a>
<a href="{{ route('admin.users') }}"><span class="material-symbols-outlined">group</span> Utilisateurs</a>
<form method="post" action="{{ route('logout') }}">@csrf<button type="submit"><span class="material-symbols-outlined">logout</span> Déconnexion</button></form>
</div>
</div>
</div>
</header>
