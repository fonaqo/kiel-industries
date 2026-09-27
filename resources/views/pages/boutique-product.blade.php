@extends('layouts.app')

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] kiel-shop-page kiel-pdp-page">

@include('layouts.partials.page-subhero', [
  'heroTitle' => $product->name,
  'heroLead' => $product->category->name.' · Transformé à Parakou',
  'heroCurrent' => $product->name,
])

<section class="kiel-section kiel-section--content">
<div class="kiel-wrap">
<nav class="kiel-pdp-breadcrumb" aria-label="Fil d'Ariane produit">
<a href="{{ route('home') }}">Accueil</a>
<span aria-hidden="true">/</span>
<a href="{{ route('boutique') }}">Boutique</a>
<span aria-hidden="true">/</span>
<a href="{{ route('boutique') }}">Produits</a>
<span aria-hidden="true">/</span>
<span aria-current="page">{{ $product->name }}</span>
</nav>

<div class="kiel-pdp">
@php
  $pdpImages = collect($product->galleryPaths())
    ->map(fn ($path) => \App\Support\CmsUploads::publicUrl($path))
    ->filter()
    ->unique()
    ->values();
  if ($pdpImages->isEmpty()) {
    $pdpImages = collect([$product->image_url]);
  }
@endphp
<div class="kiel-pdp__gallery" data-kiel-pdp-gallery>
<div class="kiel-pdp__main">
<button type="button" class="kiel-pdp__nav kiel-pdp__nav--prev" aria-label="Image précédente" data-kiel-pdp-prev><span class="material-symbols-outlined">chevron_left</span></button>
<img alt="{{ $product->name }}" class="kiel-pdp__main-img" data-kiel-pdp-main src="{{ $pdpImages->first() }}"/>
<button type="button" class="kiel-pdp__nav kiel-pdp__nav--next" aria-label="Image suivante" data-kiel-pdp-next><span class="material-symbols-outlined">chevron_right</span></button>
</div>
<div class="kiel-pdp__thumbs">
@foreach($pdpImages as $i => $url)
<button type="button" class="kiel-pdp__thumb @if($i === 0) is-active @endif" data-kiel-pdp-thumb="{{ $url }}" aria-label="Vue {{ $i + 1 }}">
<img alt="" loading="lazy" src="{{ $url }}"/>
</button>
@endforeach
</div>
</div>

@php
  $shareUrl = url()->current();
  $shareText = $product->name.' · KIEL INDUSTRIES';
  $virtues = $product->virtuesList();
@endphp
<div class="kiel-pdp__info">
<p class="kiel-pdp__cat">{{ $product->category->name }}</p>
<div class="kiel-pdp__title-row">
<h1 class="kiel-pdp__title">{{ $product->name }}</h1>
<button type="button" class="kiel-pdp__wishlist-icon" aria-label="Ajouter aux favoris" data-kiel-wishlist="{{ $product->id }}" data-wish-name="{{ $product->name }}" data-wish-price="{{ $product->price_fcfa }}" data-wish-image="{{ $product->image_url }}" data-wish-url="{{ route('boutique.show', $product) }}"><span class="material-symbols-outlined">favorite</span></button>
</div>
@if($product->discountPercent())
<p class="kiel-pdp__promo-line"><span class="kiel-pdp__promo">Promotion −{{ $product->discountPercent() }}%</span></p>
@endif
<div class="kiel-pdp__lead">{!! $product->description !!}</div>

<div class="kiel-pdp__purchase">
<div class="kiel-pdp__qty-total-row">
<div class="kiel-pdp__qty">
<label for="pdp-qty">Quantité</label>
<div class="kiel-pdp__qty-control">
<button type="button" data-kiel-pdp-qty-minus aria-label="Diminuer">−</button>
<input id="pdp-qty" type="number" min="1" max="99" value="1" data-kiel-pdp-qty/>
<button type="button" data-kiel-pdp-qty-plus aria-label="Augmenter">+</button>
</div>
</div>
<div class="kiel-pdp__amount" data-kiel-pdp-amount data-unit-price="{{ $product->price_fcfa }}" @if($product->price_eur !== null) data-unit-price-eur="{{ $product->price_eur }}" @endif @if($product->price_usd !== null) data-unit-price-usd="{{ $product->price_usd }}" @endif>
<span class="kiel-pdp__amount-label">Montant</span>
<strong class="kiel-pdp__amount-value kiel-money" data-kiel-pdp-total @include('partials.product-money-attrs', ['product' => $product])>{{ number_format($product->price_fcfa, 0, ',', ' ') }} FCFA</strong>
<span class="kiel-pdp__amount-unit kiel-money" @include('partials.product-money-attrs', ['product' => $product])>{{ number_format($product->price_fcfa, 0, ',', ' ') }} FCFA / unité</span>
</div>
</div>

<div class="kiel-pdp__toolbar">
<div class="kiel-pdp-share" data-kiel-pdp-share>
<button type="button" class="kiel-pdp-share__toggle" data-kiel-share-toggle aria-expanded="false" aria-haspopup="true"><span class="material-symbols-outlined">share</span> Partager</button>
<div class="kiel-pdp-share__menu" data-kiel-share-menu hidden role="menu">
<a role="menuitem" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" data-kiel-share-item><span class="kiel-pdp-share__ico kiel-pdp-share__ico--fb">f</span> Facebook</a>
<a role="menuitem" href="https://wa.me/?text={{ urlencode($shareText.' '.$shareUrl) }}" target="_blank" rel="noopener noreferrer" data-kiel-share-item><span class="kiel-pdp-share__ico kiel-pdp-share__ico--wa">W</span> WhatsApp</a>
<a role="menuitem" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" data-kiel-share-item><span class="kiel-pdp-share__ico kiel-pdp-share__ico--in">in</span> LinkedIn</a>
<button type="button" role="menuitem" data-kiel-share-copy data-copy-url="{{ $shareUrl }}"><span class="material-symbols-outlined">link</span> Copier le lien</button>
</div>
</div>
</div>

<div class="kiel-pdp__actions">
<button type="button" class="kiel-pdp__btn kiel-pdp__btn--primary" data-kiel-buy-now="{{ $product->id }}" data-qty-source="pdp">Commander directement</button>
<button type="button" class="kiel-pdp__btn kiel-pdp__btn--secondary" data-kiel-add-cart="{{ $product->id }}" data-qty-source="pdp">Ajouter au panier</button>
</div>
</div>

<dl class="kiel-pdp__meta">
<div><dt>Réf.</dt><dd>KIEL-{{ strtoupper($product->slug) }}</dd></div>
<div><dt>Disponibilité</dt><dd>{{ $product->stock > 0 ? 'En stock' : 'Rupture' }}</dd></div>
@if($product->badge)<div><dt>Étiquette</dt><dd>{{ $product->badge }}</dd></div>@endif
<div><dt>Origine</dt><dd>Parakou, Borgou (Bénin)</dd></div>
</dl>
</div>
</div>

<div class="kiel-pdp-tabs" data-kiel-pdp-tabs data-kiel-open-reviews="{{ ($errors->has('rating') || $errors->has('body')) ? '1' : '0' }}">
<div class="kiel-pdp-tabs__nav" role="tablist">
<button type="button" role="tab" aria-selected="true" data-kiel-pdp-tab="desc">Description</button>
<button type="button" role="tab" aria-selected="false" data-kiel-pdp-tab="virtues">Vertus &amp; avantages</button>
<button type="button" role="tab" aria-selected="false" data-kiel-pdp-tab="info">Informations complémentaires</button>
<button type="button" role="tab" aria-selected="false" data-kiel-pdp-tab="reviews" id="avis">Avis @if($reviews->isNotEmpty())({{ $reviews->count() }})@endif</button>
</div>
<div class="kiel-pdp-tabs__panel is-active" data-kiel-pdp-panel="desc" role="tabpanel">
<div>{!! $product->description !!}</div>
<p>Produit issu de la filière baobab KIEL INDUSTRIES : traçabilité locale, transformation responsable et circuits courts depuis Parakou.</p>
</div>
<div class="kiel-pdp-tabs__panel" data-kiel-pdp-panel="virtues" role="tabpanel" hidden>
<ul class="kiel-pdp-virtues">
@foreach($virtues as $virtue)
<li><span class="material-symbols-outlined" aria-hidden="true">eco</span><span>{{ $virtue }}</span></li>
@endforeach
</ul>
<p class="kiel-pdp-virtues__note">Les vertus présentées s’inscrivent dans les usages traditionnels du baobab et les engagements qualité de KIEL INDUSTRIES. Pour un usage thérapeutique, consultez un professionnel de santé.</p>
</div>
<div class="kiel-pdp-tabs__panel" data-kiel-pdp-panel="info" role="tabpanel" hidden>
<table class="kiel-pdp-table">
<thead><tr><th>Caractéristique</th><th>Détail</th></tr></thead>
<tbody>
<tr><td>Catégorie</td><td>{{ $product->category->name }}</td></tr>
<tr><td>Prix</td><td>{{ number_format($product->price_fcfa, 0, ',', ' ') }} FCFA</td></tr>
<tr><td>Stock</td><td>{{ $product->stock }} unité(s)</td></tr>
<tr><td>Marque</td><td>KIEL INDUSTRIES</td></tr>
<tr><td>Pays d'origine</td><td>Bénin</td></tr>
</tbody>
</table>
</div>
<div class="kiel-pdp-tabs__panel" data-kiel-pdp-panel="reviews" role="tabpanel" hidden>
@php
  $reviewCount = $reviews->count();
  $avgRating = $reviewCount > 0 ? round($reviews->avg('rating'), 1) : null;
@endphp
<div class="kiel-pdp-reviews">
@if($reviewCount > 0)
<div class="kiel-pdp-reviews__summary">
<div class="kiel-pdp-reviews__score" aria-label="Note moyenne {{ $avgRating }} sur 5">
<strong>{{ number_format($avgRating, 1, ',', ' ') }}</strong>
<span class="kiel-pdp-reviews__stars" aria-hidden="true">@for($i = 1; $i <= 5; $i++)<span class="material-symbols-outlined @if($i <= round($avgRating)) is-filled @endif">star</span>@endfor</span>
</div>
<p class="kiel-pdp-reviews__count">{{ $reviewCount }} avis client{{ $reviewCount > 1 ? 's' : '' }}</p>
</div>
@else
<p class="kiel-pdp-reviews__empty">Soyez le premier à laisser un avis sur ce produit.</p>
@endif

<ul class="kiel-pdp-reviews__list">
@foreach($reviews as $review)
<li class="kiel-pdp-review">
<div class="kiel-pdp-review__head">
<strong class="kiel-pdp-review__author">{{ $review->user->name }}</strong>
<time class="kiel-pdp-review__date" datetime="{{ $review->created_at->format('Y-m-d') }}">{{ $review->created_at->translatedFormat('d F Y') }}</time>
</div>
<div class="kiel-pdp-review__stars" aria-label="Note {{ $review->rating }} sur 5">
@for($i = 1; $i <= 5; $i++)
<span class="material-symbols-outlined @if($i <= $review->rating) is-filled @endif">star</span>
@endfor
</div>
<p class="kiel-pdp-review__body">{{ $review->body }}</p>
</li>
@endforeach
</ul>

<div class="kiel-pdp-reviews__form-wrap">
<h3 class="kiel-pdp-reviews__form-title">Laisser un avis</h3>
@if(session('review_status'))
<p class="kiel-pdp-reviews__flash" role="status">{{ session('review_status') }}</p>
@endif
@auth
@if($userReview)
<p class="kiel-pdp-reviews__hint">Vous avez déjà publié un avis : vous pouvez le modifier ci-dessous.</p>
@endif
<form class="kiel-form kiel-pdp-reviews__form" method="post" action="{{ route('boutique.reviews.store', $product) }}">
@csrf
<label>Note <span class="kiel-form-required" aria-hidden="true">*</span>
<select name="rating" required @class(['is-invalid' => $errors->has('rating')])>
@for($r = 5; $r >= 1; $r--)
<option value="{{ $r }}" @selected(old('rating', $userReview?->rating) == $r)>{{ $r }} étoile{{ $r > 1 ? 's' : '' }}</option>
@endfor
</select>
</label>
<label>Votre avis <span class="kiel-form-required" aria-hidden="true">*</span>
<textarea name="body" rows="4" required minlength="10" maxlength="2000" placeholder="Partagez votre expérience avec ce produit…" @class(['is-invalid' => $errors->has('body')])>{{ old('body', $userReview?->body) }}</textarea>
</label>
@if($errors->has('rating') || $errors->has('body'))
<ul class="kiel-pdp-reviews__errors">
@foreach($errors->get('rating') as $e)<li>{{ $e }}</li>@endforeach
@foreach($errors->get('body') as $e)<li>{{ $e }}</li>@endforeach
</ul>
@endif
<button type="submit" class="kiel-pdp__btn kiel-pdp__btn--primary">{{ $userReview ? 'Mettre à jour mon avis' : 'Publier mon avis' }}</button>
</form>
@else
<p class="kiel-pdp-reviews__auth">Pour publier un avis, <a href="{{ route('login', ['redirect' => url()->current().'#avis']) }}">connectez-vous</a> ou <a href="{{ route('register', ['redirect' => url()->current().'#avis']) }}">créez un compte</a>.</p>
@endauth
</div>
</div>
</div>
</div>

@if($related->isNotEmpty())
<section class="kiel-pdp-related">
<h2 class="kiel-pdp-related__title">Produits associés</h2>
<div class="kiel-shop-layout">
<div class="kiel-shop-grid">
@foreach($related as $item)
@include('partials.kiel-shop-product-card', ['product' => $item])
@endforeach
</div>
</div>
</section>
@endif
</div>
</section>
</main>
@endsection

@push('scripts')
<script>
(function () {
  const gallery = document.querySelector('[data-kiel-pdp-gallery]');
  if (gallery) {
    const main = gallery.querySelector('[data-kiel-pdp-main]');
    const urls = [...gallery.querySelectorAll('[data-kiel-pdp-thumb]')].map((b) => b.getAttribute('data-kiel-pdp-thumb'));
    let idx = 0;
    const setIdx = (i) => {
      idx = (i + urls.length) % urls.length;
      if (main) main.src = urls[idx];
      gallery.querySelectorAll('.kiel-pdp__thumb').forEach((el, n) => el.classList.toggle('is-active', n === idx));
    };
    gallery.querySelector('[data-kiel-pdp-prev]')?.addEventListener('click', () => setIdx(idx - 1));
    gallery.querySelector('[data-kiel-pdp-next]')?.addEventListener('click', () => setIdx(idx + 1));
    gallery.querySelectorAll('[data-kiel-pdp-thumb]').forEach((btn, n) => btn.addEventListener('click', () => setIdx(n)));
  }

  const qtyInput = document.querySelector('[data-kiel-pdp-qty]');
  const pdpActionBtns = document.querySelectorAll('[data-qty-source="pdp"]');
  const amountRoot = document.querySelector('[data-kiel-pdp-amount]');
  const totalEl = document.querySelector('[data-kiel-pdp-total]');
  const unitPrice = parseInt(amountRoot?.getAttribute('data-unit-price') || '0', 10) || 0;

  const syncPdpQty = () => {
    const qty = Math.max(1, Math.min(99, parseInt(qtyInput?.value || '1', 10) || 1));
    if (qtyInput) qtyInput.value = String(qty);
    pdpActionBtns.forEach((btn) => btn.setAttribute('data-qty', String(qty)));
    const total = unitPrice * qty;
    if (totalEl) {
      totalEl.setAttribute('data-price-fcfa', String(total));
      const unitEur = amountRoot?.getAttribute('data-unit-price-eur');
      const unitUsd = amountRoot?.getAttribute('data-unit-price-usd');
      if (unitEur) {
        totalEl.setAttribute('data-price-eur', String(parseFloat(unitEur) * qty));
      }
      if (unitUsd) {
        totalEl.setAttribute('data-price-usd', String(parseFloat(unitUsd) * qty));
      }
      if (window.KielCurrency?.formatAmount) {
        totalEl.textContent = window.KielCurrency.formatAmount(totalEl, total);
      } else {
        totalEl.textContent = total.toLocaleString('fr-FR') + ' FCFA';
      }
    }
  };

  if (qtyInput && pdpActionBtns.length) {
    document.querySelector('[data-kiel-pdp-qty-minus]')?.addEventListener('click', () => {
      qtyInput.value = String(Math.max(1, parseInt(qtyInput.value, 10) - 1 || 1));
      syncPdpQty();
    });
    document.querySelector('[data-kiel-pdp-qty-plus]')?.addEventListener('click', () => {
      qtyInput.value = String(Math.min(99, parseInt(qtyInput.value, 10) + 1 || 1));
      syncPdpQty();
    });
    qtyInput.addEventListener('change', syncPdpQty);
    syncPdpQty();
  }

  const shareRoot = document.querySelector('[data-kiel-pdp-share]');
  const shareToggle = shareRoot?.querySelector('[data-kiel-share-toggle]');
  const shareMenu = shareRoot?.querySelector('[data-kiel-share-menu]');
  if (shareToggle && shareMenu) {
    shareToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const open = shareMenu.hidden;
      shareMenu.hidden = !open;
      shareToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.addEventListener('click', () => {
      shareMenu.hidden = true;
      shareToggle.setAttribute('aria-expanded', 'false');
    });
    shareRoot.querySelector('[data-kiel-share-copy]')?.addEventListener('click', async () => {
      const url = shareRoot.querySelector('[data-kiel-share-copy]')?.getAttribute('data-copy-url') || window.location.href;
      try {
        await navigator.clipboard.writeText(url);
        shareToggle.textContent = 'Lien copié !';
        setTimeout(() => {
          shareToggle.innerHTML = '<span class="material-symbols-outlined">share</span> Partager';
        }, 2000);
      } catch {
        window.prompt('Copiez le lien :', url);
      }
      shareMenu.hidden = true;
    });
  }

  const tabsRoot = document.querySelector('[data-kiel-pdp-tabs]');
  const activateTab = (id) => {
    if (!tabsRoot) return;
    tabsRoot.querySelectorAll('[data-kiel-pdp-tab]').forEach((t) => {
      const on = t.getAttribute('data-kiel-pdp-tab') === id;
      t.setAttribute('aria-selected', on ? 'true' : 'false');
    });
    tabsRoot.querySelectorAll('[data-kiel-pdp-panel]').forEach((p) => {
      const on = p.getAttribute('data-kiel-pdp-panel') === id;
      p.classList.toggle('is-active', on);
      p.hidden = !on;
    });
  };
  if (tabsRoot) {
    tabsRoot.querySelectorAll('[data-kiel-pdp-tab]').forEach((tab) => {
      tab.addEventListener('click', () => activateTab(tab.getAttribute('data-kiel-pdp-tab')));
    });
    if (window.location.hash === '#avis' || tabsRoot.getAttribute('data-kiel-open-reviews') === '1') {
      activateTab('reviews');
    }
  }
})();
</script>
@endpush
