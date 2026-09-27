<div class="kiel-account-wishlist" id="kiel-account-wishlist">
@auth
<script type="application/json" id="kiel-wishlist-bootstrap">@json($wishlistItems ?? [])</script>
@endauth
<p class="kiel-account-wishlist__hint">@auth Vos favoris sont liés à votre compte : ils se mettent à jour ici et dans le menu boutique (icône cœur). @else Vos favoris sont enregistrés sur cet appareil. Connectez-vous pour les retrouver dans votre espace client. @endauth Ajoutez des produits depuis la boutique avec l’icône cœur.</p>
<div class="kiel-account-wishlist__list" id="kiel-account-wishlist-list" aria-live="polite"></div>
<div class="kiel-account-wishlist__empty" id="kiel-account-wishlist-empty" hidden>
@include('pages.account.partials.empty-state', ['message' => 'Aucun favori pour le moment.'])
</div>
</div>
