<div class="nav-dropdown nav-mega rounded-xl bg-surface shadow-[0_16px_48px_rgba(44,0,10,.14)] border border-outline-variant/25">
<div class="nav-mega-grid">
@forelse($navCategories ?? [] as $cat)
<a class="nav-mega-link" href="{{ route('boutique', ['categorie' => $cat->slug]) }}">
@include('partials.kiel-nav-mega-icon', ['image' => $cat->image, 'slug' => $cat->slug])
<span><strong>{{ $cat->name }}</strong>@if($cat->nav_teaser)<em>{{ $cat->nav_teaser }}</em>@elseif($cat->meta_description)<em>{{ \Illuminate\Support\Str::limit(strip_tags($cat->meta_description), 80) }}</em>@endif</span>
</a>
@empty
<a class="nav-mega-link" href="{{ route('boutique') }}"><span class="kiel-nav-mega-icon">@include('partials.kiel-category-icon', ['category' => 'nutrition'])</span><span><strong>Boutique KIEL</strong><em>Découvrez nos produits.</em></span></a>
@endforelse
<a class="nav-mega-link" href="{{ route('boutique', ['best' => 1]) }}"><span class="kiel-nav-mega-icon">@include('partials.kiel-category-icon', ['category' => 'packs'])</span><span><strong>Meilleures ventes</strong><em>Sélection des produits phares.</em></span></a>
</div>
<div class="nav-mega-foot nav-mega-foot--solo"><a class="nav-mega-foot-link" href="{{ route('boutique') }}">Voir toute la boutique <span class="material-symbols-outlined text-[15px]">arrow_forward</span></a></div>
</div>
