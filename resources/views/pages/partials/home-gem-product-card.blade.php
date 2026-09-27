@php /** @var \App\Models\Product $product */ @endphp
<article class="product-item {{ $product->category->slug ?? 'nutrition' }} kiel-shop-card kiel-gem-card">
<div class="kiel-shop-card__media">
<img alt="{{ $product->name }}" loading="lazy" src="{{ $product->image_url }}"/>
<span aria-hidden="true" class="kiel-gem-card__overlay"></span>
@if($product->badge)<span class="kiel-shop-card__tag">{{ $product->badge }}</span>@endif
<div class="kiel-shop-card__actions">
<button type="button" aria-label="Ajouter aux favoris" data-kiel-wishlist="{{ $product->id }}" data-wish-name="{{ $product->name }}" data-wish-price="{{ $product->price_fcfa }}" data-wish-image="{{ $product->image_url }}" data-wish-url="{{ route('boutique.show', $product) }}"><span class="material-symbols-outlined text-[18px]">favorite</span></button>
</div>
<p class="kiel-gem-card__price product-price kiel-money" @include('partials.product-money-attrs', ['product' => $product])>{{ number_format($product->price_fcfa, 0, ',', ' ') }} FCFA</p>
</div>
<div class="kiel-gem-card__body">
<h4>{{ $product->name }}</h4>
<p class="kiel-gem-card__desc">{{ \Illuminate\Support\Str::limit($product->description ?? '', 90) }}</p>
<div class="kiel-gem-card__bar">
<div class="kiel-gem-card__actions">
<button class="product-add-btn kiel-gem-btn kiel-gem-btn--primary" type="button" data-kiel-add-cart="{{ $product->id }}">Ajouter au panier</button>
<a class="product-discover-btn kiel-gem-btn kiel-gem-btn--ghost" href="{{ route('boutique.show', $product) }}">Voir la fiche</a>
</div>
</div>
</div>
</article>
