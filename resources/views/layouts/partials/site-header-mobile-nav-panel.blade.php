<nav class="kiel-drawer-nav-links" id="kiel-site-mobile-nav" aria-label="Menu principal">
<a href="{{ route('home') }}" data-path="accueil">Accueil</a>
<a href="{{ route('boutique') }}" data-path="boutique">Notre boutique</a>
@foreach($navCategories ?? [] as $cat)
<a class="kiel-drawer-nav-sublink" href="{{ route('boutique', ['categorie' => $cat->slug]) }}">{{ $cat->name }}</a>
@endforeach
<a href="{{ route('expertises') }}" data-path="expertises">Nos expertises</a>
@foreach($navExpertises ?? [] as $pole)
<a class="kiel-drawer-nav-sublink" href="{{ route('expertises.show', $pole->slug) }}">{{ $pole->title }}</a>
@endforeach
<a href="{{ route('a-propos') }}" data-path="a-propos">À propos de nous</a>
<a href="{{ route('actualites') }}" data-path="actualites">Nos actualités</a>
<a href="{{ route('nos-astuces') }}" data-path="nos-astuces">Nos astuces</a>
<a href="{{ route('contact') }}" data-path="contact">Contactez-nous</a>
@auth
<a href="{{ route('account.dashboard') }}" data-path="compte">Mon compte</a>
@endauth
@guest
<a href="{{ route('login') }}" data-path="connexion">Se connecter</a>
<a href="{{ route('register') }}" data-path="inscription" class="kiel-site-mobile-nav__cta">S'inscrire</a>
@endguest
</nav>
