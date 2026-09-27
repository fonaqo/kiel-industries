<div class="kiel-drawer-overlay" id="kiel-drawer-overlay" aria-hidden="true"></div>
<aside aria-hidden="true" aria-labelledby="drawer-cart-title" class="kiel-drawer" id="kiel-drawer-cart" role="dialog">
<div class="kiel-drawer__head"><h2 id="drawer-cart-title">Votre panier</h2><button type="button" class="kiel-drawer__close" data-drawer-close aria-label="Fermer le panier"><span class="material-symbols-outlined">close</span></button></div>
<div class="kiel-drawer__body" id="cart-drawer-body">
<div class="kiel-empty-state kiel-empty-state--drawer">
<p>Votre panier est vide.</p>
<a class="kiel-btn kiel-btn--primary" href="{{ route('boutique') }}" data-turbo-frame="_top">Aller à la boutique</a>
</div>
</div>
<div class="kiel-drawer__foot" id="cart-drawer-foot" hidden>
<p class="kiel-drawer__summary"><span>Sous-total</span><strong id="cart-drawer-subtotal">0 FCFA</strong></p>
<p class="kiel-drawer__summary kiel-drawer__summary--total"><span>Total</span><strong id="cart-drawer-total">0 FCFA</strong></p>
<a class="kiel-drawer__cta kiel-drawer__cta--wine" id="cart-drawer-goto-panier" href="{{ route('panier') }}" data-turbo-frame="_top">Voir le panier</a>
<button type="button" class="kiel-drawer__cta kiel-drawer__cta--ghost" data-drawer-close>Continuer mes achats</button>
</div>
</aside>
<aside aria-hidden="true" aria-labelledby="drawer-wishlist-title" class="kiel-drawer" id="kiel-drawer-wishlist" role="dialog">
<div class="kiel-drawer__head"><h2 id="drawer-wishlist-title">Mes favoris</h2><button type="button" class="kiel-drawer__close" data-drawer-close aria-label="Fermer les favoris"><span class="material-symbols-outlined">close</span></button></div>
<div class="kiel-drawer__body" id="wishlist-drawer-body"><p class="kiel-drawer__empty">Aucun favori pour le moment. Cliquez sur le cœur sur un produit pour l’enregistrer.</p></div>
<div class="kiel-drawer__foot"><a class="kiel-drawer__cta" href="{{ route('boutique') }}" data-drawer-close>Voir la boutique</a></div>
</aside>
<aside aria-hidden="true" aria-labelledby="drawer-nav-title" class="kiel-drawer kiel-drawer--nav" id="kiel-drawer-nav" role="dialog">
<div class="kiel-drawer__head"><h2 id="drawer-nav-title">Menu</h2><button type="button" class="kiel-drawer__close" data-drawer-close aria-label="Fermer le menu"><span class="material-symbols-outlined">close</span></button></div>
<div class="kiel-drawer__body kiel-drawer__body--nav">
@include('layouts.partials.site-header-mobile-nav-panel')
</div>
</aside>
<aside aria-hidden="true" aria-labelledby="drawer-search-title" class="kiel-drawer kiel-drawer--search" id="kiel-drawer-search" role="dialog">
<div class="kiel-drawer__head"><h2 id="drawer-search-title">Rechercher</h2><button type="button" class="kiel-drawer__close" data-drawer-close aria-label="Fermer la recherche"><span class="material-symbols-outlined">close</span></button></div>
<div class="kiel-drawer__body">
<form class="kiel-drawer-search" method="get" action="{{ route('boutique') }}" role="search">
<label class="sr-only" for="header-search-q">Rechercher un produit</label>
<input id="header-search-q" type="search" name="q" value="{{ request('q') }}" placeholder="Nom, catégorie, baobab…" autocomplete="off"/>
<button type="submit" class="kiel-drawer-search__submit"><span class="material-symbols-outlined">search</span> Voir les résultats</button>
</form>
<p class="kiel-drawer-search__hint">Recherche dans la boutique KIEL INDUSTRIES (nutrition, cosmétique, artisanat).</p>
</div>
</aside>
