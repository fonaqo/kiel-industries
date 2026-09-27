@php
$user = auth()->user();
$groups = [
  [
    'label' => 'Vue d\'ensemble',
    'items' => [
      ['route' => 'admin.cms.dashboard', 'label' => 'Tableau de bord', 'icon' => 'space_dashboard', 'active' => 'admin.cms.dashboard'],
    ],
  ],
  [
    'label' => 'Boutique',
    'items' => [
      ['route' => 'admin.orders', 'label' => 'Commandes', 'icon' => 'receipt_long', 'active' => 'admin.orders*'],
      ['route' => 'admin.cms.products.index', 'label' => 'Produits', 'icon' => 'inventory_2', 'active' => 'admin.cms.products.*'],
      ['route' => 'admin.cms.categories.index', 'label' => 'Catégories', 'icon' => 'category', 'active' => 'admin.cms.categories.*'],
    ],
  ],
  [
    'label' => 'Contenu',
    'items' => [
      ['route' => 'admin.cms.expertises.index', 'label' => 'Expertises', 'icon' => 'psychology', 'active' => 'admin.cms.expertises.*'],
      ['route' => 'admin.cms.posts.index', 'label' => 'Actualités', 'icon' => 'newspaper', 'active' => 'admin.cms.posts.*'],
      ['route' => 'admin.cms.tips.index', 'label' => 'Nos astuces', 'icon' => 'smart_display', 'active' => 'admin.cms.tips.*'],
      ['route' => 'admin.cms.documents.index', 'label' => 'Documents', 'icon' => 'description', 'active' => 'admin.cms.documents.*'],
    ],
  ],
  [
    'label' => 'Système',
    'items' => [
      ['route' => 'admin.cms.settings.edit', 'label' => 'Paramètres', 'icon' => 'tune', 'active' => 'admin.cms.settings.*'],
      ['route' => 'admin.users', 'label' => 'Utilisateurs', 'icon' => 'group', 'active' => 'admin.users'],
    ],
  ],
];
@endphp
<aside class="kiel-cms-sidebar" id="kiel-cms-sidebar" aria-label="Navigation administration">
<div class="kiel-cms-sidebar__brand">
<a href="{{ route('admin.cms.dashboard') }}" class="kiel-cms-sidebar__logo">
<img class="kiel-cms-admin-logo kiel-logo-wordmark" src="{{ asset('assets/img/brand/logo-kiel.svg') }}" alt="KIEL Industries"/>
</a>
<span class="kiel-cms-sidebar__studio">Espace d'administration</span>
</div>
@foreach($groups as $group)
<div class="kiel-cms-sidebar__group">
<p class="kiel-cms-sidebar__group-label">{{ $group['label'] }}</p>
<nav class="kiel-cms-sidebar__nav">
@foreach($group['items'] as $item)
<a href="{{ route($item['route']) }}" @class(['is-active' => request()->routeIs($item['active'])])>
@include('cms-admin.partials.sidebar-icon', ['icon' => $item['icon']])
<span class="kiel-cms-sidebar__nav-text">{{ $item['label'] }}</span>
</a>
@endforeach
</nav>
</div>
@endforeach
<div class="kiel-cms-sidebar__bottom">
<div class="kiel-cms-sidebar__identity">
<p class="kiel-cms-sidebar__identity-name">{{ $user->display_name }}</p>
<p class="kiel-cms-sidebar__identity-email">{{ $user->email }}</p>
</div>
<div class="kiel-cms-sidebar__foot">
<a class="kiel-cms-sidebar__ext" href="{{ route('boutique') }}" target="_blank" rel="noopener">@include('cms-admin.partials.sidebar-icon', ['icon' => 'boutique', 'class' => 'kiel-cms-sidebar__ext-icon']) Boutique</a>
</div>
<form method="post" action="{{ route('logout') }}" class="kiel-cms-sidebar__logout">@csrf<button type="submit">@include('cms-admin.partials.sidebar-icon', ['icon' => 'logout', 'class' => 'kiel-cms-sidebar__logout-icon']) Déconnexion</button></form>
</div>
</aside>
