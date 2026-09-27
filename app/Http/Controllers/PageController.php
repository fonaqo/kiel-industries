<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CmsPage;
use App\Models\CompanyDocument;
use App\Models\ExpertisePole;
use App\Models\Post;
use App\Models\Product;
use App\Models\TipVideo;
use App\Services\CmsBlocks;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $catalogProducts = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        $homeProducts = $catalogProducts->keyBy('slug');

        $featuredCarousel = $catalogProducts->where('is_featured', true)->values();
        if ($featuredCarousel->isEmpty()) {
            $featuredCarousel = $catalogProducts->take(3)->values();
        }

        $pickDaySlugs = ['poudre-pulpe-250g', 'baume-baobab', 'huile-baobab-50ml'];
        $pickDayProducts = collect($pickDaySlugs)
            ->map(fn (string $slug) => $homeProducts->get($slug))
            ->filter()
            ->values();
        if ($pickDayProducts->count() < 3) {
            $pickDayProducts = $catalogProducts->take(3)->values();
        }

        $pickGridProducts = $catalogProducts
            ->reject(fn (Product $p) => $pickDayProducts->contains('id', $p->id))
            ->take(4)
            ->values();

        $homeNews = Post::query()
            ->published()
            ->latest('published_at')
            ->take(4)
            ->get();

        $cms = app(CmsBlocks::class);

        $shopCategories = Category::query()
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $homeExpertisePoles = ExpertisePole::query()
            ->published()
            ->orderBy('sort_order')
            ->get();

        return view('pages.home', [
            'page' => 'accueil',
            'shopCategories' => $shopCategories,
            'homeExpertisePoles' => $homeExpertisePoles,
            'title' => 'KIEL INDUSTRIES',
            'homeProducts' => $homeProducts,
            'featuredCarousel' => $featuredCarousel,
            'pickDayProducts' => $pickDayProducts,
            'pickGridProducts' => $pickGridProducts,
            'catalogProducts' => $catalogProducts,
            'homeNews' => $homeNews,
            'h' => $cms->group('home'),
            'cms' => $cms,
        ]);
    }

    public function expertises(): View
    {
        return view('pages.expertises', [
            'page' => 'expertises',
            'title' => 'Nos expertises',
            'poles' => $this->expertisePoles(),
        ]);
    }

    public function expertiseShow(string $slug): View
    {
        $pole = collect($this->expertisePoles())->firstWhere('slug', $slug);
        abort_if($pole === null, 404);

        $poles = $this->expertisePoles();
        $pole = $this->enrichPole($pole);

        return view('pages.expertise-show', [
            'page' => 'expertises',
            'title' => $pole['title'],
            'pole' => $pole,
            'otherPoles' => collect($poles)->where('slug', '!=', $slug)->take(3)->values()->all(),
        ]);
    }

    public function aPropos(): View
    {
        $cms = app(CmsBlocks::class);

        $documents = CompanyDocument::query()
            ->published()
            ->orderBy('sort_order')
            ->orderByDesc('issued_at')
            ->take(3)
            ->get();

        return view('pages.a-propos', [
            'page' => 'a-propos',
            'title' => 'À propos de nous',
            'a' => $cms->group('about'),
            'cms' => $cms,
            'highlightDocuments' => $documents,
        ]);
    }

    public function nosDocuments(): View
    {
        $categories = config('kiel.document_categories', []);
        $activeCategory = request('cat');
        if ($activeCategory !== null && $activeCategory !== '' && ! array_key_exists($activeCategory, $categories)) {
            $activeCategory = null;
        }

        $query = CompanyDocument::query()->published();
        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $documents = $query
            ->orderBy('sort_order')
            ->orderByDesc('issued_at')
            ->orderBy('title')
            ->get();

        return view('pages.nos-documents', [
            'page' => 'nos-documents',
            'title' => 'Nos documents',
            'documents' => $documents,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function partenaire(): View
    {
        $cms = app(CmsBlocks::class);

        return view('pages.partenaire', [
            'page' => 'partenaire',
            'title' => 'Devenir partenaire',
            'p' => $cms->group('partner'),
            'cms' => $cms,
        ]);
    }

    public function nosAstuces(): View
    {
        $categories = config('kiel.tip_video_categories', []);
        $activeCategory = request('cat');
        if ($activeCategory !== null && $activeCategory !== '' && ! array_key_exists($activeCategory, $categories)) {
            $activeCategory = null;
        }

        $search = trim((string) request('q', ''));
        if (strlen($search) > 120) {
            $search = substr($search, 0, 120);
        }

        $query = TipVideo::query()->published();
        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $videos = $query
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderBy('title')
            ->get();

        $featured = $videos->first();
        if (request()->filled('v')) {
            $featured = $videos->firstWhere('slug', request('v')) ?? $featured;
        }

        return view('pages.nos-astuces', [
            'page' => 'nos-astuces',
            'title' => 'Nos astuces',
            'videos' => $videos,
            'featuredVideo' => $featured,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'searchQuery' => $search,
        ]);
    }

    public function actualites(): View
    {
        $featured = Post::query()->published()->where('is_featured', true)->latest('published_at')->first();
        if ($featured === null) {
            $featured = Post::query()->published()->latest('published_at')->first();
        }

        $posts = Post::query()
            ->published()
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->latest('published_at')
            ->paginate(6);

        return view('pages.actualites', [
            'page' => 'actualites',
            'title' => 'Nos actualités',
            'featuredPost' => $featured,
            'posts' => $posts,
        ]);
    }

    public function actualiteShow(Post $post): View
    {
        abort_unless($post->published_at && $post->published_at->lte(now()), 404);

        return view('pages.actualite-show', [
            'page' => 'actualites',
            'title' => $post->title,
            'post' => $post,
        ]);
    }

    public function mentionsLegales(): View
    {
        return $this->legalCmsPage('mentions-legales', 'pages.legal.mentions-legales');
    }

    public function politiqueConfidentialite(): View
    {
        return $this->legalCmsPage('politique-confidentialite', 'pages.legal.politique-confidentialite');
    }

    public function conditionsGenerales(): View
    {
        return $this->legalCmsPage('conditions-generales', 'pages.legal.conditions-generales');
    }

    public function conditionsUtilisation(): View
    {
        return $this->legalCmsPage('conditions-utilisation', 'pages.legal.conditions-utilisation');
    }

    public function contact(): View
    {
        $cms = app(CmsBlocks::class);

        return view('pages.contact', [
            'page' => 'contact',
            'title' => 'Contact',
            'c' => $cms->group('contact'),
            'cms' => $cms,
        ]);
    }

    public function panier(): View
    {
        $data = ['page' => 'boutique', 'title' => 'Panier'];

        if (auth()->check()) {
            return view('pages.account.panier', $data);
        }

        return view('pages.panier', $data);
    }

    /** @return list<array<string, mixed>> */
    private function expertisePoles(): array
    {
        $fromDb = ExpertisePole::query()->published()->orderBy('sort_order')->get();
        if ($fromDb->isNotEmpty()) {
            return $fromDb->map(fn (ExpertisePole $p) => $this->enrichPole($p->toPoleArray()))->all();
        }

        return collect(config('kiel.expertise_poles', []))
            ->map(fn (array $pole) => $this->enrichPole($pole))
            ->all();
    }

    /** @param  array<string, mixed>  $pole */
    private function enrichPole(array $pole): array
    {
        if (! empty($pole['highlights'])) {
            return $pole;
        }

        $fromConfig = collect(config('kiel.expertise_poles', []))->firstWhere('slug', $pole['slug'] ?? '');
        if (is_array($fromConfig) && ! empty($fromConfig['highlights'])) {
            $pole['highlights'] = $fromConfig['highlights'];
        } elseif (! empty($pole['slug'])) {
            $pole['highlights'] = $this->defaultPoleHighlights($pole['slug']);
        }

        return $pole;
    }

    /** @return list<array{icon: string, title: string, text: string}> */
    private function defaultPoleHighlights(string $slug): array
    {
        return match ($slug) {
            'filiere-baobab-kiel' => [
                ['icon' => 'recycling', 'title' => 'Économie circulaire', 'text' => 'Valorisation intégrale du baobab : alimentation, cosmétique et artisanat.'],
                ['icon' => 'verified', 'title' => 'Brevet d’invention', 'text' => 'Innovation protégée, zéro déchet et engagement pour l’innovation africaine.'],
                ['icon' => 'storefront', 'title' => 'Marque KIEL', 'text' => 'Production, transformation et commercialisation depuis Parakou.'],
            ],
            'conseil-nutritionnel' => [
                ['icon' => 'nutrition', 'title' => 'Super-aliments', 'text' => 'Poudres, café, whisky et biscuits de baobab.'],
                ['icon' => 'school', 'title' => 'Programmes', 'text' => 'Lutte contre la malnutrition avec partenaires locaux.'],
                ['icon' => 'health_and_safety', 'title' => 'Conseil sur mesure', 'text' => 'Accompagnement familles, écoles et institutions.'],
            ],
            'gestion-projets' => [
                ['icon' => 'assignment', 'title' => 'Pilotage', 'text' => 'Projets agroécologiques et filière baobab de A à Z.'],
                ['icon' => 'handshake', 'title' => 'Partenariats', 'text' => 'B2B, ONG et institutions au Borgou et au Bénin.'],
                ['icon' => 'eco', 'title' => 'Impact mesurable', 'text' => 'Terres restaurées, emplois verts et autonomisation des femmes.'],
            ],
            'mentorat' => [
                ['icon' => 'diversity_3', 'title' => 'Transmission', 'text' => 'Savoir-faire terrain et standards qualité KIEL.'],
                ['icon' => 'groups', 'title' => 'Coopératives', 'text' => 'Renforcement des femmes rurales et des groupements.'],
                ['icon' => 'lightbulb', 'title' => 'Entrepreneuriat', 'text' => 'Accompagnement des porteurs de projets autour du baobab.'],
            ],
            default => [],
        };
    }

    private function legalCmsPage(string $slug, string $fallbackView): View
    {
        $cmsPage = CmsPage::query()->published()->where('slug', $slug)->first();
        if ($cmsPage) {
            return view('pages.legal.cms', [
                'page' => $slug,
                'title' => $cmsPage->meta_title ?: $cmsPage->title,
                'cmsPage' => $cmsPage,
            ]);
        }

        return view($fallbackView, ['page' => $slug, 'title' => str_replace('-', ' ', ucfirst($slug))]);
    }
}
