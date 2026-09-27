<footer class="kiel-site-footer w-full" id="site-footer">
  <div class="kiel-container">
    <div class="kiel-footer-top">
      <div class="kiel-footer-brand">
        <img alt="KIEL INDUSTRIES" class="kiel-footer-logo-wordmark kiel-logo-wordmark" loading="lazy" src="{{ asset('assets/img/brand/logo-kiel.svg') }}"/>

        <p class="kiel-footer-desc">KIEL Industries, restauration des paysages et valorisation intégrale du baobab (économie circulaire). Alimentation, cosmétique, artisanat, conseil nutritionnel, projets et mentorat.</p>
      </div>
      <div class="kiel-footer-col"><h3>Maison KIEL</h3><ul><li><a href="{{ route('a-propos') }}">À propos de nous</a></li><li><a href="{{ route('expertises') }}">Nos expertises</a></li><li><a href="{{ route('nos-documents') }}">Nos documents</a></li><li><a href="{{ route('nos-astuces') }}">Nos astuces</a></li><li><a href="{{ route('actualites') }}">Nos actualités</a></li><li><a href="{{ route('partenaire') }}">Devenir un partenaire</a></li></ul></div><div class="kiel-footer-col"><h3>Produits KIEL</h3><ul><li><a href="{{ route('home') }}#catalogue-boutique">Poudre de pulpe et feuilles</a></li><li><a href="{{ route('home') }}#catalogue-boutique">Café, whisky et biscuits</a></li><li><a href="{{ route('home') }}#catalogue-boutique">Huile, baume et pommade</a></li><li><a href="{{ route('home') }}#catalogue-boutique">Artisanat et accessoires</a></li><li><a href="{{ route('home') }}#comment-ca-marche">Commander en ligne</a></li><li><a href="{{ route('boutique') }}">Découvrir tous les produits</a></li></ul></div>      <div class="kiel-footer-col kiel-footer-contact-col">
        <h3>NOS Contacts</h3>
        <ul class="kiel-footer-contact-list">          
          <li>
            <a href="tel:+2290165728584">
              @include('partials.kiel-ui-icon', ['name' => 'call', 'size' => 18])
              <span>+229 0165728584</span>
            </a>
          </li>
          <li>
            <a href="mailto:kielbienetre@gmail.com">
              @include('partials.kiel-ui-icon', ['name' => 'mail', 'size' => 18])
              <span>kielbienetre@gmail.com</span>
            </a>
          </li>
          <li>
            @include('partials.kiel-ui-icon', ['name' => 'location_on', 'size' => 18])
            <span>Parakou, Borgou, Bénin</span>
          </li>          
        </ul>
        @include('layouts.partials.kiel-social-links', ['context' => 'footer'])
      </div>
    </div>
    <div class="kiel-footer-bottom"><p class="m-0">© 2026 KIEL Industries. Tous droits réservés. · Développé par <a href="{{ config('kiel.site_credit.url', '#') }}" rel="noopener noreferrer" target="_blank">{{ config('kiel.site_credit.company', 'Fonaqo SARL') }}</a></p><nav aria-label="Liens légaux" class="kiel-footer-legal"><a href="{{ route('mentions-legales') }}">Mentions légales</a><a href="{{ route('politique-confidentialite') }}">Politique de confidentialité</a><a href="{{ route('conditions-utilisation') }}">Conditions d'utilisation</a><a href="{{ route('conditions-generales') }}">Conditions de vente (CGV)</a></nav><div class="kiel-footer-payments"><img alt="Commande en ligne. Paiement Mobile Money et carte bientôt disponibles" class="kiel-footer-payments__img" height="36" loading="lazy" src="{{ asset('assets/img/brand/paiement-securise-vanconfig.png') }}" width="280"/></div></div></div></footer>