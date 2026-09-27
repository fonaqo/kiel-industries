@extends('layouts.app')

@push('shop-scripts')
<script src="{{ asset('assets/js/shop/kiel-shop-live.js') }}" defer></script>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] kiel-shop-page">

@include('layouts.partials.page-subhero', [
  'heroTitle' => 'La réserve botanique KIEL',
  'heroLead' => 'Poudres, huiles, soins et artisanat issus du baobab : transformés à Parakou, livrés au Bénin et à l’international.',
  'heroCurrent' => 'Boutique',
])

<section class="kiel-section kiel-section--content">
<div class="kiel-wrap kiel-shop-layout" id="kiel-shop-live">
<aside class="kiel-shop-sidebar">
<h3>Recherche & filtres</h3>
<form class="kiel-shop-search" method="get" action="{{ route('boutique') }}">
<label class="sr-only" for="shop-q">Rechercher</label>
<input id="shop-q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Nom, description…"/>
@if($filters['categorie'] ?? false)<input type="hidden" name="categorie" value="{{ $filters['categorie'] }}"/>@endif
<button type="submit" class="kiel-shop-search__btn"><span class="material-symbols-outlined">search</span></button>
</form>
<div class="kiel-shop-filter-group">
<p class="kiel-shop-filter-label">Catégories</p>
<ul>
<li><a class="{{ empty($filters['categorie'] ?? null) ? 'is-active' : '' }}" href="{{ route('boutique', collect($filters)->except('categorie')->filter()->all()) }}">Toutes</a></li>
@foreach($categories as $cat)
<li><a class="{{ ($filters['categorie'] ?? '') === $cat->slug ? 'is-active' : '' }}" href="{{ route('boutique', array_merge(collect($filters)->filter()->all(), ['categorie' => $cat->slug])) }}">{{ $cat->name }}</a></li>
@endforeach
</ul>
</div>
<form class="kiel-shop-filter-group" method="get" action="{{ route('boutique') }}">
@foreach(collect($filters)->except(['prix_min', 'prix_max', 'tri'])->filter() as $k => $v)
<input type="hidden" name="{{ $k }}" value="{{ $v }}"/>
@endforeach
<p class="kiel-shop-filter-label">Prix (FCFA)</p>
<div class="kiel-shop-price-row">
<input type="number" name="prix_min" min="0" placeholder="Min" value="{{ $filters['prix_min'] ?? '' }}"/>
<span>–</span>
<input type="number" name="prix_max" min="0" placeholder="Max" value="{{ $filters['prix_max'] ?? '' }}"/>
</div>
<p class="kiel-shop-filter-label">Options</p>
<label class="kiel-shop-filter-check"><input type="checkbox" name="best" value="1" @checked($filters['best'] ?? false)/> Best-sellers</label>
<label class="kiel-shop-filter-check"><input type="checkbox" name="promo" value="1" @checked($filters['promo'] ?? false)/> En promotion</label>
<label class="kiel-shop-filter-check"><input type="checkbox" name="stock" value="1" @checked($filters['stock'] ?? false)/> En stock</label>
<button type="submit" class="kiel-shop-filter-submit">Appliquer</button>
<a class="kiel-shop-filter-reset" href="{{ route('boutique') }}">Réinitialiser</a>
</form>
</aside>
<div id="kiel-shop-results">
@include('partials.boutique-results', compact('products', 'filters', 'categories'))
</div>
</div>
</section>
</main>
@endsection
