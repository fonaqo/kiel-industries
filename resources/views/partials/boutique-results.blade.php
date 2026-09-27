<div class="kiel-shop-toolbar">
<div>
<p class="kiel-shop-result-count">Résultats {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} sur {{ $products->total() }}</p>
<div class="kiel-shop-tags">
@if($filters['q'] ?? false)<span class="kiel-shop-tag">« {{ $filters['q'] }} »</span>@endif
@if($filters['categorie'] ?? false)<span class="kiel-shop-tag">{{ $categories->firstWhere('slug', $filters['categorie'])?->name }}</span>@endif
@if($filters['promo'] ?? false)<span class="kiel-shop-tag">Promo</span>@endif
@if($filters['best'] ?? false)<span class="kiel-shop-tag">Best-seller</span>@endif
</div>
</div>
<form class="kiel-shop-sort" method="get" action="{{ route('boutique') }}" data-shop-sort-form>
@foreach(collect($filters)->except('tri')->filter() as $k => $v)
<input type="hidden" name="{{ $k }}" value="{{ $v }}"/>
@endforeach
<label class="sr-only" for="tri">Tri</label>
<select id="tri" name="tri" data-shop-auto-submit>
<option value="default" @selected(($filters['tri'] ?? 'default') === 'default')>Tri par défaut</option>
<option value="price_asc" @selected(($filters['tri'] ?? '') === 'price_asc')>Prix croissant</option>
<option value="price_desc" @selected(($filters['tri'] ?? '') === 'price_desc')>Prix décroissant</option>
</select>
</form>
</div>
<div class="kiel-shop-grid" id="kiel-shop-grid">
@forelse($products as $product)
@include('partials.kiel-shop-product-card', ['product' => $product])
@empty
<p class="kiel-shop-empty">Aucun produit ne correspond à votre recherche.</p>
@endforelse
</div>
<div class="kiel-shop-pagination">{{ $products->links() }}</div>
