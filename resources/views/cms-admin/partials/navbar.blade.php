@php
$items = [
  ['route' => 'admin.cms.dashboard', 'label' => 'Tableau de bord', 'icon' => 'dashboard', 'active' => 'admin.cms.dashboard'],
  ['route' => 'admin.orders', 'label' => 'Commandes', 'icon' => 'receipt_long', 'active' => 'admin.orders*'],
  ['route' => 'admin.cms.products.index', 'label' => 'Produits', 'icon' => 'inventory_2', 'active' => 'admin.cms.products.*'],
  ['route' => 'admin.cms.categories.index', 'label' => 'Catégories', 'icon' => 'category', 'active' => 'admin.cms.categories.*'],
  ['route' => 'admin.cms.expertises.index', 'label' => 'Expertises', 'icon' => 'psychology', 'active' => 'admin.cms.expertises.*'],
  ['route' => 'admin.cms.posts.index', 'label' => 'Actualités', 'icon' => 'newspaper', 'active' => 'admin.cms.posts.*'],
  ['route' => 'admin.cms.settings.edit', 'label' => 'Paramètres', 'icon' => 'settings', 'active' => 'admin.cms.settings.*'],
  ['route' => 'admin.users', 'label' => 'Utilisateurs', 'icon' => 'group', 'active' => 'admin.users'],
];
@endphp
<nav class="kiel-cms-navbar" aria-label="Navigation administration">
@foreach($items as $item)
<a href="{{ route($item['route']) }}" @class(['is-active' => request()->routeIs($item['active'])])>
<span class="material-symbols-outlined" aria-hidden="true">{{ $item['icon'] }}</span>
<span>{{ $item['label'] }}</span>
</a>
@endforeach
</nav>
