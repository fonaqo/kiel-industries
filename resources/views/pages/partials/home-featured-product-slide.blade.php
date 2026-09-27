@php /** @var \App\Models\Product $product */ @endphp
<article class="catalogue-slide product-item {{ $product->category->slug ?? 'nutrition' }}">
<div class="featured-product-card h-full flex flex-col rounded-2xl overflow-hidden bg-surface">
<a class="featured-product-card__link" href="{{ route('boutique.show', $product) }}" aria-label="Voir {{ $product->name }}"></a>
<div class="relative aspect-[4/3] overflow-hidden">
<img alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy" src="{{ $product->image_url }}"/>
<div class="product-card-top">
@if($product->badge)<span class="px-2.5 py-1 rounded-full bg-secondary text-on-secondary font-label-sm text-label-sm">{{ $product->badge }}</span>@endif
<div class="product-card-actions">
<button aria-label="Ajouter aux favoris" class="product-fav-btn" type="button" data-kiel-wishlist="{{ $product->id }}" data-wish-name="{{ $product->name }}" data-wish-price="{{ $product->price_fcfa }}" data-wish-image="{{ $product->image_url }}" data-wish-url="{{ route('boutique.show', $product) }}"><span class="material-symbols-outlined">favorite</span></button>
<button aria-label="Voir le panier" class="product-cart-btn" type="button" data-kiel-open-cart><span class="material-symbols-outlined">shopping_bag</span></button>
</div>
</div>
</div>
<div class="p-space-md flex flex-col gap-3 flex-1">
<h3 class="font-headline-sm text-headline-sm text-primary leading-snug">{{ $product->name }}</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">{{ $product->description }}</p>
<div class="mt-auto pt-2 border-t border-outline-variant/15 flex flex-col gap-2.5">
<p class="text-right font-headline-sm text-headline-sm text-primary font-bold product-price kiel-money" @include('partials.product-money-attrs', ['product' => $product])>{{ number_format($product->price_fcfa, 0, ',', ' ') }} FCFA</p>
<div class="flex items-center gap-2">
<div class="product-qty" data-min="1">
<button aria-label="Diminuer la quantité" class="product-qty-minus" type="button">−</button>
<span class="product-qty-value">1</span>
<button aria-label="Augmenter la quantité" class="product-qty-plus" type="button">+</button>
</div>
<button class="flex-1 min-w-0 px-3 py-2 rounded-full bg-secondary hover:opacity-95 text-on-secondary font-label-sm text-label-sm uppercase tracking-wider transition-opacity product-add-btn" type="button" data-kiel-add-cart="{{ $product->id }}">Ajouter au panier</button>
</div>
</div>
</div>
</div>
</article>
