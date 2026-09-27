@if($teaserProducts->isNotEmpty())
<section class="kiel-product-strip" aria-label="Produits KIEL à découvrir">
<div class="kiel-wrap">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'Boutique KIEL',
  'title' => 'Offrez-vous le baobab du Borgou',
  'lead' => 'Quelques best-sellers transformés à Parakou. Ajoutez au panier en un clic.',
  'centered' => true,
])
<div class="kiel-shop-grid mt-6">
@foreach($teaserProducts as $product)
<article class="kiel-shop-card">
<div class="kiel-shop-card__media">
<a class="kiel-shop-card__media-link" href="{{ route('boutique.show', $product) }}" tabindex="-1" aria-hidden="true">
<img alt="{{ $product->name }}" loading="lazy" src="{{ $product->image_url }}"/>
</a>
@if($product->badge)<span class="kiel-shop-card__badge">{{ $product->badge }}</span>@endif
<div class="kiel-shop-card__actions">
<button type="button" aria-label="Ajouter aux favoris" data-kiel-wishlist="{{ $product->id }}" data-wish-name="{{ $product->name }}" data-wish-price="{{ $product->price_fcfa }}" data-wish-image="{{ $product->image_url }}" data-wish-url="{{ route('boutique.show', $product) }}"><span class="material-symbols-outlined text-[18px]">favorite</span></button>
<button type="button" aria-label="Ajouter au panier" data-kiel-add-cart="{{ $product->id }}"><span class="material-symbols-outlined text-[18px]">shopping_bag</span></button>
</div>
</div>
<a class="kiel-shop-card__link" href="{{ route('boutique.show', $product) }}">
<div class="kiel-shop-card__body">
<div class="kiel-shop-card__meta"><span>{{ $product->category->name ?? 'KIEL' }}</span></div>
<h3 class="kiel-shop-card__title">{{ $product->name }}</h3>
<div class="kiel-shop-card__prices"><strong class="kiel-money" @include('partials.product-money-attrs', ['product' => $product])>{{ number_format($product->price_fcfa, 0, ',', ' ') }} FCFA</strong></div>
</div>
</a>
<div class="kiel-shop-card__foot">
<button type="button" data-kiel-add-cart="{{ $product->id }}">Ajouter au panier</button>
<a class="kiel-shop-card__detail" href="{{ route('boutique.show', $product) }}">Voir la fiche</a>
</div>
</article>
@endforeach
</div>
<p class="text-center mt-6"><a class="kiel-btn kiel-btn--primary" href="{{ route('boutique') }}">Voir toute la boutique</a></p>
</div>
</section>
@endif
