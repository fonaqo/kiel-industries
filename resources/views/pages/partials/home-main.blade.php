@php
  $cms = $cms ?? app(\App\Services\CmsBlocks::class);
  $g = fn (string $k, string $d = '') => (string) ($h[$k] ?? $d);
  $galleryItems = $cms->json('home.gallery.items', []);
  $homeFaqItems = $cms->json('home.faq.items', []);
  $homeStatsItems = $cms->json('home.stats.items', []);
@endphp
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface"><div class="flex flex-col w-full">
<!-- 1. HERO VIDÉO, ROTATION DES TEXTES -->
<section class="relative w-full overflow-hidden bg-primary text-on-primary min-h-[580px] lg:min-h-[700px] flex flex-col" id="hero-section">
<div class="absolute inset-0 z-0">
<video autoplay="" class="w-full h-full object-cover object-center" id="hero-video" loop="" muted="" playsinline="" poster="{{ $cms->assetUrl($g('hero.video_poster', 'assets/img/ressources/home-1.png')) }}">
<source src="{{ asset('assets/video/baobab-video.mp4') }}" type="video/mp4"/>
</video>
<div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/78 to-primary/38"></div>
<div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/35 to-transparent"></div>
</div>
<div class="relative z-20 w-full kiel-container py-space-lg lg:py-[3.5rem] flex-1 flex items-center">
<div class="w-full flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-xl">
<div class="flex-1 min-w-0">
<div class="text-tertiary-fixed font-label-lg text-label-lg uppercase tracking-widest mb-space-sm font-bold">
<span>{{ $g('hero.eyebrow', 'KIEL Industries · Parakou, Bénin') }}</span>
</div>
<div class="max-w-4xl mb-space-md">
<h1 class="font-display-lg text-display-lg text-surface-bright font-title leading-[1.08]">{!! $g('hero.title', 'Restaurer les paysages, valoriser le baobab.') !!}</h1>
</div>
<div class="max-w-2xl mb-space-lg">
<p class="font-body-lg text-body-lg text-white leading-relaxed">{!! $g('hero.lead', '') !!}</p>
</div>
<div class="flex flex-wrap items-center gap-4 pt-space-xs">
<a class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full bg-secondary hover:opacity-95 text-on-secondary font-label-md text-label-md uppercase tracking-wider transition-all duration-300 shadow-md" href="{{ route('boutique') }}">
<span class="material-symbols-outlined text-[20px]">shopping_bag</span>
<span>{{ $g('hero.cta_primary', 'Commander en ligne') }}</span>
</a>
<a class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full border-2 border-surface-bright bg-transparent text-surface-bright hover:bg-surface-bright/10 font-label-md text-label-md uppercase tracking-wider transition-all duration-300" href="{{ route('boutique') }}">
<span>{{ $g('hero.cta_secondary', 'Découvrir la boutique') }}</span>
<span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</a>
</div>
</div>
<div aria-hidden="true" class="hidden lg:flex flex-shrink-0 items-center justify-center pr-2">
<div class="hero-orbit hero-orbit--lg relative rounded-full">
<svg class="absolute inset-0 w-full h-full" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
<circle class="hero-orbit-fill" cx="100" cy="100" r="96"/>
<defs><path d="M 100,100 m -74,0 a 74,74 0 1,1 148,0 a 74,74 0 1,1 -148,0" fill="none" id="hero-slogan-ring"/></defs>
<g class="hero-orbit-spin-group">
<text fill="#ffffff" font-family="Plus Jakarta Sans,sans-serif" font-weight="800">
<textPath href="#hero-slogan-ring" startOffset="0">KIEL · INDUSTRIES · BAOBAB · ÉCONOMIE CIRCULAIRE · NATURE · PARAKOU · </textPath>
</text>
</g>
</svg>
<div class="hero-orbit-center">
@include('partials.kiel-logo-filigrane', ['variant' => 'hero', 'class' => 'hero-badge-icon hero-badge-icon--orbit kiel-logo--hero'])
</div>
</div>
</div>
</div>
</div>
</section>
<!-- PARTENAIRES, bandeau logos -->
<section class="w-full partners-strip bg-surface pt-space-lg pb-space-sm" id="partenaires" aria-label="Ils nous soutiennent">
<div class="kiel-container mb-4 pt-1">
<h2 class="font-headline-sm text-headline-sm lg:text-headline-md text-primary font-title text-center">{{ $g('partners.title', 'Ils nous soutiennent') }}</h2>
</div>
<div class="testimonial-marquee overflow-hidden">
<div class="testimonial-marquee-track kiel-marquee-track partners-marquee-track" id="partners-track" style="--marquee-duration:38s;">
<a class="partners-logo-link" href="{{ route('partenaire') }}" title="Land Accelerator"><img alt="Land Accelerator" loading="lazy" src="{{ asset('assets/img/partenaires/patener-1.png') }}"/></a>
<a class="partners-logo-link" href="{{ route('partenaire') }}" title="PAVRIB"><img alt="PAVRIB" loading="lazy" src="{{ asset('assets/img/partenaires/pavrib.svg') }}"/></a>
<a class="partners-logo-link" href="https://www.oapi.int" rel="noopener noreferrer" target="_blank" title="OAPI"><img alt="OAPI" loading="lazy" src="{{ asset('assets/img/partenaires/oapi.png') }}"/></a>
</div>
</div>
</section>

<!-- 2. À PROPOS, KIEL Industries (section d’origine) -->
<section class="relative w-full bg-surface py-space-xl lg:py-[4.5rem] overflow-hidden" id="manifeste-impact">
<div aria-hidden="true" class="about-deco about-deco--leaves absolute -left-[6%] top-[8%] hidden sm:block">
<img alt="" loading="lazy" src="{{ asset('assets/img/filigrane/baobab-leaves-deco.svg') }}"/>
</div>
<div aria-hidden="true" class="about-deco about-deco--fruits absolute -right-[4%] bottom-[12%] hidden md:block">
<img alt="" loading="lazy" src="{{ asset('assets/img/filigrane/baobab-fruits-deco.svg') }}"/>
</div>
<div aria-hidden="true" class="about-deco about-deco--leaves-alt absolute left-[38%] bottom-[6%] hidden lg:block">
<img alt="" loading="lazy" src="{{ asset('assets/img/filigrane/baobab-leaves-deco.svg') }}"/>
</div>
<div class="kiel-container relative z-10">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl lg:gap-10 items-center">
<div class="lg:col-span-5 flex flex-col gap-space-md relative about-reveal" id="about-text-reveal">
<div aria-hidden="true" class="baobab-scene pointer-events-none absolute -right-20 sm:-right-16 lg:right-6 xl:right-6 2xl:right-[-30%] top-[46%] lg:top-[60%] -translate-y-1/2 translate-x-3 lg:translate-x-6 w-[min(280px,58vw)] sm:w-[min(320px,50vw)] lg:w-[min(360px,42vw)] z-0">
@include('partials.kiel-baobab-silhouette', ['wine' => true, 'class' => 'w-[90%] h-auto'])
</div>
<div class="relative z-10 flex flex-col gap-space-md about-copy">
@include('partials.kiel-section-eyebrow', ['label' => 'À PROPOS DE', 'class' => 'about-item'])
<h2 class="about-item font-headline-lg text-headline-lg lg:text-[2.75rem] text-primary font-title leading-tight -mt-1">{{ $g('manifeste.title', 'KIEL Industries') }}</h2>
<p class="about-item font-body-lg text-body-lg text-on-surface leading-snug max-w-xl" id="about-story">{!! $g('manifeste.p1', '') !!}</p>
<p class="about-item font-body-md text-body-md text-on-surface-variant leading-relaxed max-w-xl">{!! $g('manifeste.p2', '') !!}</p>
<p class="about-item font-body-md text-body-md text-on-surface-variant leading-relaxed max-w-xl">{!! $g('manifeste.p3', '') !!}</p>
<div class="about-item flex flex-wrap items-center gap-3 mt-space-xs">
<a class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-secondary text-on-secondary font-label-md text-label-md uppercase tracking-wider hover:opacity-95 transition-opacity shadow-md" href="{{ route('boutique') }}">
<span class="material-symbols-outlined text-[20px]">shopping_bag</span>
<span>Consulter nos produits</span>
</a>
<a class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full border-2 border-primary text-primary bg-transparent hover:bg-primary/5 font-label-md text-label-md uppercase tracking-wider transition-colors" href="{{ route('a-propos') }}#impact-chiffres">
<span>Découvrir nos chiffres</span>
<span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</a>
</div>
</div>
</div>
<div class="lg:col-span-4 relative about-collage-wrap mx-auto w-full max-w-xl lg:max-w-none about-reveal-scale" id="about-collage-reveal">
<div class="about-photo absolute top-0 right-0 w-[74%] h-[44%] z-10">
<img alt="Paysage de savane et baobab au Borgou" class="w-full h-full object-cover" loading="lazy" src="{{ $cms->assetUrl($g('manifeste.img1', 'assets/img/ressources/home-1.png')) }}"/>
</div>
<div class="about-photo absolute top-[22%] left-0 w-[66%] h-[40%] z-20">
<img alt="Femmes productrices autour du baobab à Parakou" class="w-full h-full object-cover" loading="lazy" src="{{ $cms->assetUrl($g('manifeste.img2', 'assets/img/ressources/home-2.png')) }}"/>
</div>
<div class="about-photo absolute bottom-0  left-[20%] w-[78%] h-[46%] z-30">
<img alt="Huile pure de baobab KIEL" class="w-full h-full object-cover object-center" loading="lazy" src="{{ $cms->assetUrl($g('manifeste.img3', 'assets/img/ressources/home-3.png')) }}"/>
</div>
</div>
<div class="lg:col-span-3 flex flex-col gap-space-md about-reveal" id="about-activities-reveal">
<h3 class="about-item font-headline-md text-headline-md text-primary font-title leading-snug">Nos activités</h3>
<ul class="about-item flex flex-col divide-y divide-outline-variant/25">
<li class="flex gap-3 py-4 first:pt-0">
<span class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-secondary text-[22px]">eco</span></span>
<div><p class="font-label-md text-label-md text-primary uppercase tracking-wide">Valorisation du baobab</p><p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Production, transformation &amp; vente via la marque KIEL, économie circulaire</p></div>
</li>
<li class="flex gap-3 py-4">
<span class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-secondary text-[22px]">nutrition</span></span>
<div><p class="font-label-md text-label-md text-primary uppercase tracking-wide">Conseil nutritionnel</p><p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Accompagnement alimentaire &amp; lutte contre la malnutrition</p></div>
</li>
<li class="flex gap-3 py-4">
<span class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-secondary text-[22px]">assignment</span></span>
<div><p class="font-label-md text-label-md text-primary uppercase tracking-wide">Gestion de projets</p><p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Développement communautaire &amp; restauration des écosystèmes</p></div>
</li>
<li class="flex gap-3 py-4">
<span class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-secondary text-[22px]">school</span></span>
<div><p class="font-label-md text-label-md text-primary uppercase tracking-wide">Mentorat</p><p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Transmission &amp; accompagnement des porteurs de filières locales</p></div>
</li>
</ul>
<div class="about-item border-t border-outline-variant/20 about-copy">
  <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
    <strong class="text-primary font-bold">Vision&nbsp;:</strong> 
    une Afrique où le baobab devient moteur de restauration écologique, de prospérité économique, de sécurité alimentaire et de résilience climatique pour les communautés rurales. Notre légitimité s’appuie sur des années d’expérience en agroalimentaire, développement communautaire, entrepreneuriat social et restauration des écosystèmes.
  </p>
</div>
</div>
</div>
</div>
</section>

<!-- NOS PRODUITS VEDETTE -->
<section class="featured-products-section w-full py-space-xl lg:py-[4.25rem] bg-white" id="catalogue-boutique">
<div class="kiel-container">
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-space-md pb-space-md">
<div class="featured-products-head">
<div class="kiel-section-eyebrow">
@include('partials.kiel-baobab-heading-icon')
<span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">Nos produits vedette</span>
</div>
<h2 class="font-headline-lg text-headline-lg text-primary font-title leading-tight">La gamme KIEL INDUSTRIES, alimentation, soins &amp; artisanat</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-2">Poudres de pulpe et de feuilles, café, huile, baume, pommade, biscuits et créations artisanales, transformés à Parakou, disponibles en ligne.</p>
</div>
<span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-secondary-container/80 border border-secondary/25 text-secondary font-label-sm text-label-sm uppercase tracking-wider shrink-0"><span class="material-symbols-outlined text-secondary text-[18px]">verified</span> Best-sellers · direct producteur</span>
</div>
</div>
<div class="catalogue-carousel catalogue-carousel--featured overflow-hidden">
<div class="catalogue-track kiel-marquee-track" id="catalogue-track">
@forelse($featuredCarousel ?? [] as $product)
@include('pages.partials.home-featured-product-slide', ['product' => $product])
@empty
<p class="text-center text-on-surface-variant py-8">Catalogue en cours de chargement. <a class="text-secondary font-bold" href="{{ route('boutique') }}">Parcourir la boutique</a></p>
@endforelse
</div>
</div>
<div class="kiel-container pt-space-lg pb-space-md">
<p class="text-center m-0">
<a class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full border-2 border-secondary bg-transparent text-secondary font-label-md text-label-md uppercase tracking-wider hover:bg-secondary/8 transition-colors" href="{{ route('boutique') }}">
<span>Découvrir tous les produits</span>
<span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</a>
</p>
</div>
</section>


<!-- DÉCOUVRIR KIEL INDUSTRIES -->
<section class="kiel-discover w-full py-space-xl lg:py-[4.75rem] bg-surface relative overflow-hidden" id="decouvrez-kiel">
<div aria-hidden="true" class="kiel-discover-filigrane pointer-events-none">
@include('partials.kiel-baobab-silhouette', ['mono' => true])
</div>
<div class="kiel-container relative z-10 about-reveal">
<header class="kiel-discover-head about-item">
<div class="kiel-section-eyebrow mb-2">
@include('partials.kiel-baobab-heading-icon')
<span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">Découvrez KIEL INDUSTRIES</span>
</div>
<h2 class="font-headline-lg text-headline-lg lg:text-[2.75rem] text-primary font-title leading-[1.12] max-w-2xl">Baobab, terres restaurées &amp; bien-être, notre histoire à Parakou.</h2>
</header>
<div class="kiel-discover-grid">
<div class="kiel-discover-media about-item">
<div class="kiel-discover-photo kiel-discover-photo--main">
<img alt="Savane et baobab au Borgou" loading="lazy" src="{{ asset('assets/img/ressources/decouvre-1.png') }}"/>
</div>
<div class="kiel-discover-photo kiel-discover-photo--accent">
<img alt="Femmes productrices au Borgou" loading="lazy" src="{{ asset('assets/img/sections/decouvre/decouvre-2.png') }}"/>
</div>
<div class="kiel-discover-badge kiel-discover-badge--green">
<span class="kiel-discover-badge__num">500+</span>
<span class="kiel-discover-badge__txt">productrices au Borgou</span>
</div>
</div>
<div class="kiel-discover-copy about-item">
<blockquote class="kiel-discover-pull quote-serif">«&nbsp;Le baobab n’est pas une matière première&nbsp;: c’est un pacte avec les femmes du Borgou, avec la savane et avec demain.&nbsp;»</blockquote>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mt-5 text-justify">Depuis <strong class="text-primary font-medium">Parakou</strong>, KIEL Industries structure une filière où nature, croissance et transformation du baobab incarnent notre identité africaine, le logo évoque l’arbre, la vie et le bien-être.</p>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mt-3 text-justify">Nous sommes l’une des rares entreprises africaines à combiner restauration des terres, économie circulaire zéro déchet, lutte contre la malnutrition, autonomisation des femmes rurales, innovation brevetée et création d’emplois verts.</p>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mt-3 text-justify">Nos valeurs&nbsp;: innovation, qualité, valorisation locale, économie circulaire, respect de l’environnement, création d’emplois et autonomisation des femmes, portées par un brevet OAPI.</p>
<div class="kiel-discover-steps-wrap">
<ol class="kiel-discover-steps" aria-label="Étapes de l'histoire KIEL INDUSTRIES">
<li><span class="kiel-discover-steps__dot">01</span><div><strong>Restauration</strong><p>Terres dégradées et paysages régénérés autour du baobab.</p></div></li>
<li><span class="kiel-discover-steps__dot">02</span><div><strong>Transformation</strong><p>Unités locales à Parakou, zéro déchet, traçabilité.</p></div></li>
<li><span class="kiel-discover-steps__dot">03</span><div><strong>Marque KIEL</strong><p>Commercialisation, conseil, projets, mentorat &amp; e-commerce.</p></div></li>
</ol>
<div aria-hidden="true" class="kiel-discover-steps-filigrane pointer-events-none">
@include('partials.kiel-baobab-silhouette', ['mono' => true])
</div>
</div>
</div>
</div>
</div>
</section>



<!-- CATÉGORIES BOUTIQUE -->
<section class="w-full bg-white py-space-lg lg:py-[3rem]" id="categories-boutique">
<div class="kiel-container">
<div class="kiel-categories-block">
<div class="kiel-categories-head">
<div>
<h3 class="font-headline-md text-headline-md text-primary font-title text-center lg:text-left">Catégories</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-1 text-center lg:text-left">Parcourez la boutique par univers produit.</p>
</div>
<a class="kiel-categories-all-link shrink-0 mx-auto lg:mx-0" href="{{ route('boutique') }}">
<span>Découvrez toutes les catégories</span>
<span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
</a>
</div>
<div class="kiel-categories-grid mt-4">
@forelse(($shopCategories ?? collect()) as $cat)
<a class="kiel-cat-card" href="{{ route('boutique', ['categorie' => $cat->slug]) }}"><span class="kiel-cat-card__thumb @if(! $cat->image_url) kiel-cat-card__thumb--svg @endif">@if($cat->image_url)<img class="kiel-cat-card__thumb-img" src="{{ $cat->image_url }}" alt="" loading="lazy"/>@else @include('partials.kiel-category-icon', ['category' => $cat->slug]) @endif</span><span><strong class="kiel-cat-card__title font-title">{{ $cat->name }}</strong><span class="font-body-sm text-body-sm text-on-surface-variant">{{ $cat->nav_teaser ?: ($cat->products_count.' produit'.($cat->products_count > 1 ? 's' : '')) }}</span></span></a>
@empty
<p class="font-body-sm text-body-sm text-on-surface-variant">Les catégories seront bientôt disponibles.</p>
@endforelse
</div>
</div>
</div>
</section>


<!-- LES UNIVERS DE LA MANUFACTURE -->
<section class="w-full py-space-xl lg:py-[4.5rem] bg-surface-container-low" id="univers-manufacture">
<div class="kiel-container">
<div class="max-w-2xl mb-space-lg">
<div class="kiel-section-eyebrow">
@include('partials.kiel-baobab-heading-icon')
<span class="kiel-eyebrow font-label-md text-label-md uppercase tracking-widest text-secondary">Les univers de la manufacture</span>
</div>
<h2 class="font-headline-lg text-headline-lg text-primary leading-tight mt-1">Explorez nos Pôles d'Excellence Botanique.</h2>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
@forelse(($homeExpertisePoles ?? collect())->take(4) as $pole)
@php
  $poleHref = $pole->boutique_category
    ? route('boutique', ['categorie' => $pole->boutique_category])
    : route('expertises.show', $pole->slug);
@endphp
<a class="group relative block rounded-2xl overflow-hidden min-h-[400px] lg:min-h-[460px] shadow-md hover:shadow-xl transition-shadow" href="{{ $poleHref }}">
<img alt="" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="{{ asset($pole->image) }}"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/75 to-primary/10"></div>
<div class="relative z-10 h-full min-h-[400px] lg:min-h-[460px] flex flex-col justify-end p-space-md">
<span class="inline-flex self-start px-3 py-1 rounded-full border border-surface-bright/35 font-label-sm text-label-sm uppercase tracking-wider text-surface-bright mb-space-sm">{{ $pole->tag }}</span>
<h3 class="font-headline-sm text-headline-sm text-surface-bright">{{ $pole->title }}</h3>
<p class="font-body-sm text-body-sm text-outline-variant mt-1 line-clamp-2">{{ $pole->intro }}</p>
<span class="font-label-md text-label-md uppercase tracking-wider text-surface-bright mt-space-md inline-flex items-center gap-1 group-hover:gap-2 transition-all">Explorer l'univers <span class="material-symbols-outlined text-[16px]">arrow_forward</span></span>
</div>
</a>
@empty
<p class="font-body-md text-on-surface-variant col-span-full text-center"><a class="text-secondary font-semibold hover:underline" href="{{ route('expertises') }}">Découvrir nos expertises</a></p>
@endforelse
</div>
</div>
</section>

<!-- LE BAOBAB  :  L'ARBRE DE VIE -->
<section class="kiel-baobab-hub w-full py-space-xl lg:py-[4.75rem]" id="baobab-arbre-vie" aria-labelledby="baobab-arbre-vie-title">
  <div class="kiel-container relative z-10">
    <header class="kiel-baobab-hub__head">
      <div class="kiel-section-eyebrow justify-center mb-3">
        @include('partials.kiel-baobab-heading-icon')
        <span class="kiel-eyebrow">KIEL INDUSTRIES · filière baobab</span>
      </div>
      <h2 class="kiel-baobab-hub__title" id="baobab-arbre-vie-title">
        LE BA<span class="kiel-baobab-hub__title-o">@include('partials.kiel-logo-eyebrow', ['class' => 'kiel-baobab-hub__title-logo'])</span>BAB
      </h2>
      <p class="kiel-baobab-hub__subtitle">L’arbre de vie</p>
      <p class="kiel-baobab-hub__intro">Symbole de force et de résilience, le baobab est au cœur de la vie, des cultures et de l’avenir durable que KIEL INDUSTRIES porte depuis Parakou.</p>
    </header>

    <div class="kiel-baobab-hub__stage">
      <svg aria-hidden="true" class="kiel-baobab-hub__links" id="baobab-hub-links"></svg>
      <div class="kiel-baobab-hub__col kiel-baobab-hub__col--left">
        <article class="kiel-baobab-hub__node">
          <div class="kiel-baobab-hub__node-icon"><span class="material-symbols-outlined">eco</span></div>
          <div class="kiel-baobab-hub__node-text">
            <h3>Matière première</h3>
            <p>Le baobab, une ressource naturelle exceptionnelle pour l’alimentation, la cosmétique et l’artisanat.</p>
          </div>
        </article>
        <article class="kiel-baobab-hub__node">
          <div class="kiel-baobab-hub__node-icon"><span class="material-symbols-outlined">public</span></div>
          <div class="kiel-baobab-hub__node-text">
            <h3>Ancrage territorial</h3>
            <p>Ancré en Afrique, engagé pour les communautés locales et la filière au Bénin.</p>
          </div>
        </article>
        <article class="kiel-baobab-hub__node">
          <div class="kiel-baobab-hub__node-icon"><span class="material-symbols-outlined">recycling</span></div>
          <div class="kiel-baobab-hub__node-text">
            <h3>Zéro déchet</h3>
            <p>Valorisation intégrale du baobab, du fruit à la coque, en économie circulaire.</p>
          </div>
        </article>
      </div>

      <div class="kiel-baobab-hub__center">
        <div class="kiel-baobab-hub__tree-wrap">
          <img alt="Baobab majestueux, symbole KIEL INDUSTRIES" class="kiel-baobab-hub__tree" loading="lazy" src="{{ asset('assets/img/baobab/baobab-arbre.png') }}"/>
        </div>
      </div>

      <div class="kiel-baobab-hub__col kiel-baobab-hub__col--right">
        <article class="kiel-baobab-hub__node">
          <div class="kiel-baobab-hub__node-icon"><span class="material-symbols-outlined">diversity_3</span></div>
          <div class="kiel-baobab-hub__node-text">
            <h3>Impact social</h3>
            <p>Création de valeur durable et autonomisation des femmes rurales et des coopératives.</p>
          </div>
        </article>
        <article class="kiel-baobab-hub__node">
          <div class="kiel-baobab-hub__node-icon"><span class="material-symbols-outlined">spa</span></div>
          <div class="kiel-baobab-hub__node-text">
            <h3>Bien-être</h3>
            <p>Des produits naturels pour le corps, l’esprit et une nutrition de qualité.</p>
          </div>
        </article>
        <article class="kiel-baobab-hub__node">
          <div class="kiel-baobab-hub__node-icon"><span class="material-symbols-outlined">science</span></div>
          <div class="kiel-baobab-hub__node-text">
            <h3>Transformation</h3>
            <p>Innovation brevetée OAPI et savoir-faire local au service du baobab.</p>
          </div>
        </article>
      </div>
    </div>

    <div class="kiel-baobab-hub__pick" id="selection-du-jour" aria-labelledby="selection-du-jour-title">
      <div class="kiel-baobab-hub__pick-head">
        <div class="kiel-section-eyebrow justify-center mb-2">
          @include('partials.kiel-baobab-heading-icon')
          <span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">Boutique KIEL</span>
        </div>
        <h3 class="font-headline-md text-headline-md text-primary font-title leading-tight text-center" id="selection-du-jour-title">Sélection du jour</h3>
        <p class="font-body-md text-body-md text-on-surface-variant mt-2 text-center max-w-xl mx-auto">Trois produits mis en avant aujourd’hui  :  direct producteur, transformés à Parakou.</p>
      </div>

      <div class="kiel-shop-grid kiel-shop-grid--pick kiel-shop-grid--pick-day">
        @forelse($pickDayProducts ?? [] as $product)
          @include('pages.partials.home-gem-product-card', ['product' => $product])
        @empty
          <p class="text-center text-on-surface-variant col-span-full py-6"><a class="text-secondary font-bold" href="{{ route('boutique') }}">Parcourir la boutique</a></p>
        @endforelse
      </div>

      <p class="kiel-baobab-hub__pick-cta text-center">
        <a class="inline-flex items-center gap-2 px-7 py-3 rounded-full border-2 border-secondary text-secondary font-label-md text-label-md uppercase tracking-wider hover:bg-secondary/8 transition-colors" href="{{ route('boutique') }}">Voir toute la sélection en ligne</a>
      </p>
    </div>
  </div>
</section>

<!-- POURQUOI KIEL -->
<section class="kiel-why-v3 w-full py-space-xl lg:py-[4.5rem] bg-surface relative overflow-hidden" id="pourquoi-kiel">
<div aria-hidden="true" class="kiel-why-v3-filigrane pointer-events-none">
@include('partials.kiel-baobab-silhouette', ['mono' => true, 'class' => 'kiel-why-v3-filigrane__main'])
@include('partials.kiel-baobab-silhouette', ['mono' => true, 'class' => 'kiel-why-v3-filigrane__accent'])
</div>
<div class="kiel-container relative z-10">
<div class="kiel-why-v3-grid">
<div class="kiel-why-v3-visual">
<img alt="Productrices et filière baobab au Borgou" loading="lazy" src="{{ asset('assets/img/ressources/pourquoi.jpeg') }}"/>
<div class="kiel-why-v3-visual-badge"><span class="kiel-why-v3-visual-badge__num">500+</span><span class="kiel-why-v3-visual-badge__txt">Productrices au Borgou</span></div>
</div>
<div class="kiel-why-v3-content">
<div class="kiel-section-eyebrow mb-2">
@include('partials.kiel-baobab-heading-icon')
<span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">Pourquoi choisir KIEL INDUSTRIES</span>
</div>
<h2 class="font-title font-headline-lg text-headline-lg text-primary leading-tight mb-3">La référence baobab,<br class="hidden sm:block"/> de la récolte au soin</h2>
<p class="font-body-md text-body-md text-on-surface-variant mb-space-md max-w-lg">Modèle intégré rare en Afrique&nbsp;: restauration des terres, zéro déchet, nutrition, femmes rurales, brevet OAPI et emplois verts, le tout autour du baobab à Parakou.</p>
<ul class="kiel-why-v3-list">
<li>
<div class="kiel-why-v3-icon"><span class="material-symbols-outlined">verified</span></div>
<div>
<strong>Innovation &amp; qualité</strong>
<p>Brevet d’invention OAPI, procédés maîtrisés et exigence qualité sur toute la chaîne KIEL INDUSTRIES.</p>
</div>
</li>
<li>
<div class="kiel-why-v3-icon"><span class="material-symbols-outlined">cycle</span></div>
<div>
<strong>Économie circulaire</strong>
<p>Valorisation intégrale du baobab (alimentation, cosmétique, artisanat), sans gaspillage.</p>
</div>
</li>
<li>
<div class="kiel-why-v3-icon"><span class="material-symbols-outlined">diversity_3</span></div>
<div>
<strong>Impact social &amp; environnemental</strong>
<p>Terres restaurées, emplois verts, autonomisation des femmes, conseil nutritionnel et mentorat.</p>
</div>
</li>
</ul>
<div class="flex flex-wrap gap-3 mt-space-md">
<a class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-secondary text-on-secondary font-label-md text-label-md uppercase tracking-wider hover:opacity-95 transition-opacity" href="{{ route('boutique') }}">Découvrez nos produits</a>
<a class="inline-flex items-center gap-2 px-7 py-3 rounded-full border-2 border-primary text-primary hover:bg-primary/5 font-label-md text-label-md uppercase tracking-wider transition-colors" href="{{ route('a-propos') }}">Qui sommes-nous</a>
</div>
</div>
</div>
</div>
</section>

<!-- IMPACT, BANNIÈRE STATISTIQUES -->
<section class="kiel-stats-banner relative w-full min-h-[420px] lg:min-h-[480px] flex items-center justify-center overflow-hidden" id="impact-chiffres" aria-labelledby="kiel-stats-banner-title">
<div aria-hidden="true" class="kiel-stats-banner__media">
<img alt="" class="kiel-stats-banner__img" loading="lazy" src="{{ asset('assets/img/banners/fond-vect.jpg') }}"/>
</div>
<div aria-hidden="true" class="kiel-stats-banner__overlay"></div>
<div class="kiel-container relative z-10 py-space-xl lg:py-[4rem]">
<div class="kiel-stats-banner__inner text-center max-w-4xl mx-auto">
<h2 class="kiel-stats-banner__title font-title font-headline-lg text-headline-lg lg:text-[2.65rem] text-white leading-tight mb-space-lg" id="kiel-stats-banner-title">{{ $g('stats.title', 'KIEL INDUSTRIES EN CHIFFRES') }}</h2>
<div class="kiel-stats-banner__grid">
@forelse($homeStatsItems as $stat)
<div class="kiel-stats-banner__stat">
<p class="kiel-stats-banner__num">{{ $stat['num'] ?? '' }}</p>
<p class="kiel-stats-banner__label">{{ $stat['label'] ?? '' }}</p>
</div>
@empty
<div class="kiel-stats-banner__stat">
<p class="kiel-stats-banner__num"><span class="kiel-stat-counter" data-target="500" data-suffix="+">0</span></p>
<p class="kiel-stats-banner__label">Productrices mobilisées au Borgou</p>
</div>
@endforelse
</div>
<a class="kiel-stats-banner__cta inline-flex items-center gap-2.5 mt-space-lg px-8 py-3 rounded-full border-2 border-white/90 text-white font-label-md text-label-md uppercase tracking-wider hover:bg-white/10 transition-colors" href="#hero-section">
<span class="material-symbols-outlined text-[22px]">play_circle</span>
<span>Découvrir la filière KIEL INDUSTRIES</span>
</a>
</div>
</div>
</section>



<!-- CATALOGUE  :  SÉLECTION EN LIGNE -->
<section class="kiel-shop-grid-section w-full py-space-xl lg:py-[4.25rem] bg-white" id="catalogue-selection">
  <div class="kiel-container">
    <div class="text-center max-w-2xl mx-auto mb-space-lg">
      <div class="kiel-section-eyebrow justify-center mb-2">
        @include('partials.kiel-baobab-heading-icon')
        <span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">Sélection en ligne</span>
      </div>
      <h2 class="font-headline-lg text-headline-lg text-primary font-title leading-tight">Les pépites de KIEL INDUSTRIES</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">Produits réels de la boutique KIEL : fiches détaillées, panier en ligne et confirmation par e-mail (paiement en ligne prochainement).</p>
    </div>

    <div class="kiel-shop-grid kiel-shop-grid--pick">
      @forelse($pickGridProducts ?? [] as $product)
        @include('pages.partials.home-gem-product-card', ['product' => $product])
      @empty
        <p class="text-center text-on-surface-variant col-span-full py-6"><a class="text-secondary font-bold" href="{{ route('boutique') }}">Parcourir la boutique</a></p>
      @endforelse
    </div>

    <p class="text-center mt-space-lg">
      <a class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-secondary text-on-secondary font-label-md text-label-md uppercase tracking-wider hover:opacity-95 transition-opacity" href="{{ route('boutique') }}">Consulter la boutique</a>
    </p>
  </div>
</section>


<!-- COMMENT ÇA MARCHE -->
<section class="kiel-command kiel-command--plain relative w-full py-space-xl lg:py-[4.5rem] bg-white overflow-hidden" id="comment-ca-marche">
<div aria-hidden="true" class="kiel-command-filigrane pointer-events-none">
@include('partials.kiel-baobab-silhouette', ['mono' => true])
</div>
<div class="kiel-container relative z-10">
<header class="text-center max-w-2xl mx-auto mb-space-lg lg:mb-10">
<div class="kiel-section-eyebrow justify-center mb-2">
@include('partials.kiel-baobab-heading-icon')
<span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">Commander chez KIEL INDUSTRIES</span>
</div>
<h2 class="font-headline-lg text-headline-lg text-primary font-title leading-tight">Votre commande en 4 étapes</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-2">Parcourez la boutique, validez votre panier et recevez une confirmation par e-mail avec les coordonnées de livraison.</p>
</header>
<div class="kiel-command-pipeline">
<div aria-hidden="true" class="kiel-command-pipeline__circuit kiel-command-pipeline__circuit--horiz">
<svg preserveAspectRatio="none" viewBox="0 0 1000 56">
<path class="kiel-circuit-glow" d="M 125 28 H 875"/>
<path class="kiel-circuit-trace" d="M 125 28 H 875"/>
<path class="kiel-circuit-flow" pathLength="100" d="M 125 28 H 875"/>
<circle class="kiel-circuit-via" cx="125" cy="28" r="3.5"/>
<circle class="kiel-circuit-via" cx="375" cy="28" r="3.5"/>
<circle class="kiel-circuit-via" cx="625" cy="28" r="3.5"/>
<circle class="kiel-circuit-via" cx="875" cy="28" r="3.5"/>
</svg>
</div>
<div aria-hidden="true" class="kiel-command-pipeline__circuit kiel-command-pipeline__circuit--vert">
<svg preserveAspectRatio="none" viewBox="0 0 56 420">
<path class="kiel-circuit-glow" d="M 28 52 V 368"/>
<path class="kiel-circuit-trace" d="M 28 52 V 368"/>
<path class="kiel-circuit-flow" pathLength="100" d="M 28 52 V 368"/>
<circle class="kiel-circuit-via" cx="28" cy="52" r="3.5"/>
<circle class="kiel-circuit-via" cx="28" cy="158" r="3.5"/>
<circle class="kiel-circuit-via" cx="28" cy="264" r="3.5"/>
<circle class="kiel-circuit-via" cx="28" cy="368" r="3.5"/>
</svg>
</div>
<ol class="kiel-command-pipeline__steps">
<li class="kiel-command-pipeline__step">
<div class="kiel-command-pipeline__node"><span class="material-symbols-outlined">storefront</span></div>
<h3>Parcourez</h3>
<p>Catalogue nutrition, soins, breuvages &amp; artisanat.</p>
</li>
<li class="kiel-command-pipeline__step">
<div class="kiel-command-pipeline__node"><span class="material-symbols-outlined">shopping_bag</span></div>
<h3>Validez</h3>
<p>Panier en ligne puis confirmation par e-mail ; le paiement sécurisé sera activé prochainement.</p>
</li>
<li class="kiel-command-pipeline__step">
<div class="kiel-command-pipeline__node"><span class="material-symbols-outlined">inventory_2</span></div>
<h3>Préparez</h3>
<p>Ateliers Parakou, qualité &amp; traçabilité.</p>
</li>
<li class="kiel-command-pipeline__step">
<div class="kiel-command-pipeline__node"><span class="material-symbols-outlined">local_shipping</span></div>
<h3>Recevez</h3>
<p>Livraison suivie, confirmation par e-mail ou tel.</p>
</li>
</ol>
</div>
<div class="text-center mt-space-lg">
<a class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-secondary text-on-secondary font-label-md text-label-md uppercase tracking-wider hover:opacity-95 transition-opacity" href="{{ route('boutique') }}"><span class="material-symbols-outlined text-[20px]">shopping_bag</span> Consulter la boutique</a>
</div>
</div>
</section>

<!-- FAQ -->
<section class="kiel-faq-section relative w-full py-space-xl lg:py-[4rem] bg-surface overflow-hidden" id="faq">
<div aria-hidden="true" class="kiel-faq-filigrane pointer-events-none">
@include('partials.kiel-baobab-silhouette', ['mono' => true])
</div>
<div class="kiel-container max-w-3xl mx-auto relative z-10">
<div class="text-center mb-space-md">
<div class="kiel-section-eyebrow justify-center mb-2">
@include('partials.kiel-baobab-heading-icon')
<span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">FAQ</span>
</div>
<h2 class="font-headline-lg text-headline-lg text-primary font-title">{{ $g('faq.title', 'Questions fréquentes') }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-2">{{ $g('faq.lead', '') }}</p>
</div>
<div class="faq-list">
@forelse($homeFaqItems as $faq)
<details class="faq-item">
<summary>{{ $faq['q'] ?? '' }} <span class="material-symbols-outlined">expand_more</span></summary>
<div class="faq-answer">{{ $faq['a'] ?? '' }}</div>
</details>
@empty
<details class="faq-item">
<summary>Comment passer commande sur la boutique ? <span class="material-symbols-outlined">expand_more</span></summary>
<div class="faq-answer">Choisissez vos produits, ajoutez au panier et finalisez depuis l’icône panier.</div>
</details>
@endforelse
</div>
</div>
</section>

<!-- GALERIE -->
<section class="kiel-gallery-section w-full py-space-xl lg:py-[4rem]" id="galerie" aria-labelledby="kiel-gallery-title">
  <div class="kiel-container">
    <div class="text-center max-w-2xl mx-auto mb-space-lg">
      <div class="kiel-section-eyebrow justify-center mb-2">
        @include('partials.kiel-baobab-heading-icon')
        <span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">Galerie</span>
      </div>
      <h2 class="font-headline-lg text-headline-lg text-primary font-title leading-tight" id="kiel-gallery-title">{{ $g('gallery.title', 'Galerie de KIEL INDUSTRIES') }}</h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-2">{{ $g('gallery.lead', '') }}</p>
    </div>
    <div class="kiel-gallery-showcase kiel-gallery-showcase--quad">
@foreach($galleryItems as $item)
@php
  $src = isset($item['image']) ? $cms->assetUrl($item['image']) : $cms->assetUrl('assets/img/galleries/'.($item['file'] ?? '1.png'));
@endphp
      <button type="button" class="kiel-gallery-item" data-gallery-tag="{{ $item['tag'] }}" data-gallery-title="{{ $item['title'] }}" data-gallery-short="{{ $item['short'] }}" data-gallery-desc="{{ $item['desc'] }}" data-gallery-src="{{ $src }}">
        <img alt="{{ $item['title'] }}" loading="lazy" src="{{ $src }}"/>
        <span aria-hidden="true" class="kiel-gallery-item__shade"></span>
        <span class="kiel-gallery-item__tag">{{ $item['tag'] }}</span>
        <span class="kiel-gallery-item__caption">{{ $item['caption'] }}</span>
        <span class="kiel-gallery-item__hover"><strong>{{ $item['title'] }}</strong><p>{{ $item['short'] }}</p></span>
      </button>
@endforeach
    </div>
    <div class="kiel-gallery-cta">
      <a class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full border-2 border-secondary bg-transparent text-secondary font-label-md text-label-md uppercase tracking-wider hover:bg-secondary hover:text-on-secondary transition-colors" href="#kiel-gallery-title">
        <span class="material-symbols-outlined text-[20px]">photo_library</span>
        <span>Découvrez KIEL en images</span>
      </a>
    </div>
  </div>
</section>

<div class="kiel-gallery-lightbox" id="kiel-gallery-lightbox" hidden role="dialog" aria-modal="true" aria-labelledby="kiel-gallery-lightbox-title">
  <div class="kiel-gallery-lightbox__panel">
    <button type="button" class="kiel-gallery-lightbox__close" id="kiel-gallery-lightbox-close" aria-label="Fermer">
      <span class="material-symbols-outlined">close</span>
    </button>
    <div class="kiel-gallery-lightbox__media">
      <img alt="" id="kiel-gallery-lightbox-img" src=""/>
    </div>
    <div class="kiel-gallery-lightbox__body">
      <p class="kiel-gallery-lightbox__tag" id="kiel-gallery-lightbox-tag"></p>
      <h3 class="kiel-gallery-lightbox__title" id="kiel-gallery-lightbox-title"></h3>
      <p class="kiel-gallery-lightbox__text" id="kiel-gallery-lightbox-text"></p>
    </div>
  </div>
</div>

<!-- LIVRAISON · OAPI · B2B -->
<section class="kiel-service-strip w-full" id="services-kiel" aria-label="Livraison, traçabilité et service professionnel">
  <div aria-hidden="true" class="kiel-service-strip-filigrane pointer-events-none">
    @include('partials.kiel-baobab-silhouette', ['mono' => true])
  </div>
  <div class="kiel-container">
    <div class="kiel-service-strip__grid">
      <article class="kiel-service-strip__item">
        <div class="kiel-service-strip__icon kiel-service-strip__icon--green" aria-hidden="true">
          @include('partials.kiel-ui-icon', ['name' => 'local_shipping', 'size' => 22])
        </div>
        <div class="kiel-service-strip__text">
          <h3 class="kiel-service-strip__title">Livraison partout dans le monde</h3>
          <p class="kiel-service-strip__desc">Livraison au Bénin et expédition à l’international selon destination et stock.</p>
        </div>
      </article>
      <article class="kiel-service-strip__item">
        <div class="kiel-service-strip__icon kiel-service-strip__icon--rose" aria-hidden="true">
          @include('partials.kiel-ui-icon', ['name' => 'verified', 'size' => 22])
        </div>
        <div class="kiel-service-strip__text">
          <h3 class="kiel-service-strip__title">Origine 100&nbsp;% Brevetée OAPI</h3>
          <p class="kiel-service-strip__desc">Traçabilité Borgou → Parakou et contrôles qualité sur chaque lot.</p>
        </div>
      </article>
      <article class="kiel-service-strip__item">
        <div class="kiel-service-strip__icon kiel-service-strip__icon--green" aria-hidden="true">
          @include('partials.kiel-ui-icon', ['name' => 'support_agent', 'size' => 22])
        </div>
        <div class="kiel-service-strip__text">
          <h3 class="kiel-service-strip__title">Service Pro &amp; Vrac B2B</h3>
          <p class="kiel-service-strip__desc">Cotations fûts 200&nbsp;L et tonnes sur demande directe</p>
        </div>
      </article>
      <article class="kiel-service-strip__item">
        <div class="kiel-service-strip__icon kiel-service-strip__icon--rose" aria-hidden="true">
          @include('partials.kiel-ui-icon', ['name' => 'lock', 'size' => 22])
        </div>
        <div class="kiel-service-strip__text">
          <h3 class="kiel-service-strip__title">Commande enregistrée</h3>
          <p class="kiel-service-strip__desc">Vos commandes sont sécurisées ; le paiement en ligne (Mobile Money, carte) arrive bientôt.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ACTUALITÉS -->
<section class="kiel-news-section w-full py-space-xl lg:py-[4rem]" id="actualites" aria-labelledby="kiel-news-title">
  <div class="kiel-container">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-space-md mb-space-lg">
      <div class="max-w-xl">
        <div class="kiel-section-eyebrow mb-2">
          @include('partials.kiel-baobab-heading-icon')
          <span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">Actualités</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary font-title leading-tight" id="kiel-news-title">Nos dernières actualités</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-2">Filière baobab, boutique en ligne, innovation et impact au Borgou.</p>
      </div>
      <a class="kiel-news-all-link self-start md:self-auto" href="{{ route('actualites') }}">
        <span>Voir toutes les actualités</span>
        <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
      </a>
    </div>

    <div class="kiel-news-grid">
@forelse($homeNews ?? [] as $post)
      <a class="kiel-news-card" href="{{ route('actualites.show', $post) }}">
        <div class="kiel-news-card__media">
          <img alt="" loading="lazy" src="{{ $post->resolved_image_url ?? asset('assets/img/sections/about/about-1.jpg') }}"/>
        </div>
        <div class="kiel-news-card__body">
          <p class="kiel-news-card__date">{{ $post->published_at?->translatedFormat('M Y') }} · {{ $post->category }}</p>
          <h3 class="kiel-news-card__title">{{ $post->title }}</h3>
          <p class="kiel-news-card__excerpt">{{ $post->excerpt }}</p>
          <span class="kiel-news-card__link">Lire la suite <span class="material-symbols-outlined text-[16px]">arrow_forward</span></span>
        </div>
      </a>
@empty
      <p class="font-body-md text-on-surface-variant">Actualités bientôt disponibles.</p>
@endforelse
    </div>
  </div>
</section>

</div>
<script>
  // Catalogue Product Filter
  function filterProducts(category, clickedBtn) {
    const items = document.querySelectorAll('.product-item');
    const tabs = document.querySelectorAll('.filter-tab');

    tabs.forEach(tab => {
      tab.classList.remove('bg-primary', 'text-on-primary');
      tab.classList.add('text-on-surface-variant');
    });

    clickedBtn.classList.add('bg-primary', 'text-on-primary');
    clickedBtn.classList.remove('text-on-surface-variant');

    items.forEach(item => {
      if (category === 'all' || item.classList.contains(category)) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  }

  function getProductQty(card) {
    const valueEl = card?.querySelector('.product-qty-value');
    const min = parseInt(card?.querySelector('.product-qty')?.dataset.min || '1', 10) || 1;
    const qty = parseInt(valueEl?.textContent || '1', 10) || 1;
    return Math.max(min, qty);
  }

  function initProductCards() {
    document.querySelectorAll('.product-item:not([data-qty-init])').forEach((card) => {
      card.dataset.qtyInit = 'true';
      const valueEl = card.querySelector('.product-qty-value');
      const minusBtn = card.querySelector('.product-qty-minus');
      const plusBtn = card.querySelector('.product-qty-plus');
      const min = parseInt(card.querySelector('.product-qty')?.dataset.min || '1', 10) || 1;

      const syncMinus = () => {
        if (minusBtn && valueEl) minusBtn.disabled = parseInt(valueEl.textContent, 10) <= min;
      };

      minusBtn?.addEventListener('click', () => {
        if (!valueEl) return;
        valueEl.textContent = String(Math.max(min, (parseInt(valueEl.textContent, 10) || min) - 1));
        syncMinus();
      });
      plusBtn?.addEventListener('click', () => {
        if (!valueEl) return;
        valueEl.textContent = String((parseInt(valueEl.textContent, 10) || min) + 1);
        syncMinus();
      });
      syncMinus();

      card.querySelector('.product-discover-btn')?.addEventListener('click', () => {
        document.getElementById('catalogue-boutique')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  }

  // Init
  function drawBaobabHubWires(hub) {
    const stage = hub.querySelector('.kiel-baobab-hub__stage');
    const svg = hub.querySelector('#baobab-hub-links');
    const treeWrap = hub.querySelector('.kiel-baobab-hub__tree-wrap');
    if (!stage || !svg || !treeWrap) return;

    if (window.innerWidth < 992) {
      svg.innerHTML = '';
      return;
    }

    const stageRect = stage.getBoundingClientRect();
    const treeRect = treeWrap.getBoundingClientRect();
    const w = stageRect.width;
    const h = stageRect.height;
    if (w < 10 || h < 10) return;

    svg.setAttribute('viewBox', `0 0 ${w} ${h}`);
    svg.setAttribute('width', String(w));
    svg.setAttribute('height', String(h));

    const cx = treeRect.left + treeRect.width / 2 - stageRect.left;
    const cy = treeRect.top + treeRect.height * 0.55 - stageRect.top;
    const rx = treeRect.width * 0.48;
    const ry = treeRect.height * 0.64;

    const leftIcons = hub.querySelectorAll('.kiel-baobab-hub__col--left .kiel-baobab-hub__node-icon');
    const rightIcons = hub.querySelectorAll('.kiel-baobab-hub__col--right .kiel-baobab-hub__node-icon');

    const anchorFrom = (el, side) => {
      const r = el.getBoundingClientRect();
      const y = r.top + r.height / 2 - stageRect.top;
      const x =
        side === 'right'
          ? r.right - stageRect.left + 4
          : r.left - stageRect.left - 4;
      return { x, y };
    };

    const anchorRing = (from) => {
      const dx = from.x - cx;
      const dy = from.y - cy;
      const t = Math.atan2(dy * rx, dx * ry);
      return {
        x: cx + rx * Math.cos(t),
        y: cy + ry * Math.sin(t),
      };
    };

    const wirePath = (from, to) => {
      const dx = to.x - from.x;
      const dy = to.y - from.y;
      const dist = Math.hypot(dx, dy) || 1;
      const nx = -dy / dist;
      const ny = dx / dist;
      const bulge = Math.min(42, dist * 0.22);
      const c1x = from.x + dx * 0.35 + nx * bulge;
      const c1y = from.y + dy * 0.35 + ny * bulge;
      const c2x = from.x + dx * 0.65 + nx * bulge * 0.65;
      const c2y = from.y + dy * 0.65 + ny * bulge * 0.65;
      return `M ${from.x.toFixed(1)} ${from.y.toFixed(1)} C ${c1x.toFixed(1)} ${c1y.toFixed(1)} ${c2x.toFixed(1)} ${c2y.toFixed(1)} ${to.x.toFixed(1)} ${to.y.toFixed(1)}`;
    };

    const links = [];
    leftIcons.forEach((icon) => {
      const from = anchorFrom(icon, 'right');
      links.push({ from, to: anchorRing(from) });
    });
    rightIcons.forEach((icon) => {
      const from = anchorFrom(icon, 'left');
      links.push({ from, to: anchorRing(from) });
    });

    let markup = `<ellipse class="kiel-baobab-hub__ring-path" cx="${cx}" cy="${cy}" rx="${rx}" ry="${ry}"/>`;
    links.forEach((link, i) => {
      const d = wirePath(link.from, link.to);
      markup += `<path class="kiel-baobab-hub__wire" data-wire="${i}" d="${d}"/>`;
      markup += `<circle class="kiel-baobab-hub__wire-dot kiel-baobab-hub__wire-dot--from" cx="${link.from.x.toFixed(1)}" cy="${link.from.y.toFixed(1)}" r="4"/>`;
      markup += `<circle class="kiel-baobab-hub__wire-dot kiel-baobab-hub__wire-dot--to" cx="${link.to.x.toFixed(1)}" cy="${link.to.y.toFixed(1)}" r="4.5"/>`;
    });
    svg.innerHTML = markup;

    if (!hub.classList.contains('is-visible')) return;
    svg.querySelectorAll('.kiel-baobab-hub__wire').forEach((path, index) => {
      const len = path.getTotalLength();
      path.style.strokeDasharray = `${len}`;
      path.style.strokeDashoffset = `${len}`;
      path.style.transition = `stroke-dashoffset 1.15s cubic-bezier(.4,0,.2,1) ${index * 0.1}s`;
      requestAnimationFrame(() => {
        path.style.strokeDashoffset = '0';
      });
    });
  }

  function initBaobabHub() {
    const hub = document.getElementById('baobab-arbre-vie');
    if (!hub) return;

    const refresh = () => drawBaobabHubWires(hub);
    const reveal = () => {
      hub.classList.add('is-visible');
      refresh();
    };

    window.addEventListener('resize', refresh);
    if ('ResizeObserver' in window) {
      const stage = hub.querySelector('.kiel-baobab-hub__stage');
      if (stage) new ResizeObserver(refresh).observe(stage);
    }

    if (!('IntersectionObserver' in window)) {
      reveal();
      return;
    }
    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          reveal();
          obs.unobserve(entry.target);
        });
      },
      { root: null, rootMargin: '0px 0px -6% 0px', threshold: 0.14 }
    );
    observer.observe(hub);

    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(refresh);
    }
  }

  function initAboutReveal() {
    const blocks = document.querySelectorAll('.about-reveal, .about-reveal-scale');
    if (!blocks.length) return;
    const show = (el) => el.classList.add('is-visible');
    if (!('IntersectionObserver' in window)) {
      blocks.forEach(show);
      return;
    }
    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          show(entry.target);
          obs.unobserve(entry.target);
        });
      },
      { root: null, rootMargin: '0px 0px -8% 0px', threshold: 0.12 }
    );
    blocks.forEach((el) => observer.observe(el));
  }

  document.addEventListener('DOMContentLoaded', () => {
    const heroVideo = document.getElementById('hero-video');
    if (heroVideo) {
      heroVideo.play().catch(() => {});
    }
    initAboutReveal();
    initBaobabHub();
    initSeamlessMarquee(document.getElementById('catalogue-track'), () => initProductCards());
    initProductCards();
    initSeamlessMarquee(document.getElementById('partners-track'));
    initStatCounters();
    initShopPickCards();
    initGalleryLightbox();
  });

  function initStatCounters() {
    const section = document.getElementById('impact-chiffres');
    if (!section) return;
    const counters = section.querySelectorAll('.kiel-stat-counter');
    const run = (el) => {
      if (el.dataset.done === 'true') return;
      el.dataset.done = 'true';
      const target = parseInt(el.dataset.target, 10) || 0;
      const suffix = el.dataset.suffix || '';
      const duration = 2000;
      const start = performance.now();
      const step = (now) => {
        const t = Math.min(1, (now - start) / duration);
        const eased = 1 - Math.pow(1 - t, 3);
        const val = Math.round(target * eased);
        el.textContent = val.toLocaleString('fr-FR') + suffix;
        if (t < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };
    const observer = new IntersectionObserver(
      (entries) => entries.forEach((e) => { if (e.isIntersecting) run(e.target); }),
      { threshold: 0.3 }
    );
    counters.forEach((el) => observer.observe(el));
  }


  function initGalleryLightbox() {
    const lightbox = document.getElementById('kiel-gallery-lightbox');
    if (!lightbox) return;
    const img = document.getElementById('kiel-gallery-lightbox-img');
    const tag = document.getElementById('kiel-gallery-lightbox-tag');
    const title = document.getElementById('kiel-gallery-lightbox-title');
    const body = document.getElementById('kiel-gallery-lightbox-text');
    const closeBtn = document.getElementById('kiel-gallery-lightbox-close');
    let lastFocus = null;

    const open = (btn) => {
      lastFocus = document.activeElement;
      img.src = btn.dataset.gallerySrc || '';
      img.alt = btn.dataset.galleryTitle || '';
      tag.textContent = btn.dataset.galleryTag || '';
      title.textContent = btn.dataset.galleryTitle || '';
      body.textContent = btn.dataset.galleryDesc || '';
      lightbox.hidden = false;
      document.body.style.overflow = 'hidden';
      closeBtn.focus();
    };

    const close = () => {
      lightbox.hidden = true;
      document.body.style.overflow = '';
      img.src = '';
      if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
    };

    document.querySelectorAll('.kiel-gallery-item[data-gallery-src]').forEach((btn) => {
      btn.addEventListener('click', () => open(btn));
    });
    closeBtn.addEventListener('click', close);
    lightbox.addEventListener('click', (e) => { if (e.target === lightbox) close(); });
    document.addEventListener('keydown', (e) => {
      if (!lightbox.hidden && e.key === 'Escape') close();
    });
  }

  function initShopPickCards() {
    document.querySelectorAll('.kiel-shop-grid--pick .kiel-shop-card, .kiel-shop-grid--pick-day .kiel-shop-card').forEach((card) => {
      card.setAttribute('tabindex', '0');
      card.setAttribute('role', 'button');
      const toggle = () => card.classList.toggle('is-picked');
      card.addEventListener('click', (e) => {
        if (e.target.closest('button')) return;
        toggle();
      });
      card.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggle();
        }
      });
    });
  }

  function initSeamlessMarquee(track, afterClone) {
    if (!track || track.dataset.marqueeReady === 'true') return;
    const viewport = track.parentElement;
    if (!viewport) return;

    const seed = [...track.children];
    if (!seed.length) return;

    let guard = 0;
    while (track.scrollWidth < viewport.offsetWidth + 160 && guard < 14) {
      seed.forEach((node) => track.appendChild(node.cloneNode(true)));
      guard += 1;
    }

    const cycle = [...track.children];
    const loopWidth = track.scrollWidth;
    cycle.forEach((node) => track.appendChild(node.cloneNode(true)));

    track.style.setProperty('--marquee-distance', `${loopWidth}px`);
    track.classList.add('kiel-marquee-track');
    track.dataset.marqueeReady = 'true';

    if (typeof afterClone === 'function') afterClone();
  }
</script></main>