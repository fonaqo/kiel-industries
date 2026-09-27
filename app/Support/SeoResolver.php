<?php

namespace App\Support;

use App\Models\CmsPage;
use App\Models\ExpertisePole;
use App\Models\Post;
use App\Models\Product;
use App\Services\CmsSettings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SeoResolver
{
    /** @param  array<string, mixed>  $viewData */
    public function resolve(array $viewData = []): array
    {
        $base = config('kiel.seo', []);
        $cmsSeo = app(CmsSettings::class)->get('seo');
        if (is_array($cmsSeo)) {
            $base = array_replace_recursive($base, $cmsSeo);
        }
        $routeName = Route::currentRouteName();

        if ($routeName && str_starts_with($routeName, 'admin.')) {
            $adminLabel = trim((string) ($viewData['title'] ?? 'Administration'));

            return [
                'title' => $adminLabel !== '' ? "{$adminLabel} · KIEL Admin" : 'KIEL Admin',
                'description' => 'Espace d’administration KIEL Industries.',
                'keywords' => '',
                'canonical' => URL::current(),
                'robots' => 'noindex,nofollow',
                'og_type' => 'website',
                'image' => asset($base['default_image'] ?? 'assets/img/brand/logo-kiel.svg'),
                'locale' => $base['locale'] ?? 'fr_BJ',
                'site_name' => $base['site_name'] ?? 'KIEL INDUSTRIES',
                'twitter_card' => 'summary',
                'geo' => $base['geo'] ?? [],
                'organization' => $base['organization'] ?? [],
                'json_ld' => [],
            ];
        }

        $pageMeta = $base['pages'][$routeName] ?? config('kiel.seo.pages.'.$routeName, []);

        $title = $viewData['title'] ?? $pageMeta['title'] ?? $base['default_title'] ?? 'KIEL INDUSTRIES';
        $description = $pageMeta['description'] ?? $base['default_description'] ?? '';
        $keywords = $pageMeta['keywords'] ?? $base['default_keywords'] ?? '';
        $ogType = $pageMeta['og_type'] ?? 'website';
        $robots = $pageMeta['robots'] ?? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1';
        if ($routeName && (str_starts_with($routeName, 'account.')
            || str_starts_with($routeName, 'admin.')
            || in_array($routeName, ['cart.show', 'cart.add', 'cart.sync', 'cart.update', 'cart.remove', 'commande.store', 'commande.success'], true))) {
            $robots = 'noindex,nofollow';
        }
        $image = asset($pageMeta['image'] ?? $base['default_image'] ?? 'assets/img/brand/logo-kiel.svg');
        $canonical = URL::current();

        if (isset($viewData['product']) && $viewData['product'] instanceof Product && $viewData['product']->exists) {
            $product = $viewData['product'];
            $title = $product->meta_title ?: $product->name;
            $description = $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 160);
            $keywords = $product->meta_keywords ?: $keywords;
            $ogType = 'product';
            $image = $product->og_image ? asset(ltrim($product->og_image, '/')) : $product->image_url;
            $canonical = route('boutique.show', $product);
            if ($product->robots) {
                $robots = $product->robots;
            }
        }

        if (isset($viewData['post']) && $viewData['post'] instanceof Post) {
            $post = $viewData['post'];
            $title = $post->meta_title ?: $post->title;
            $description = $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?: $post->body ?? ''), 160);
            $keywords = $post->meta_keywords ?: $keywords;
            $ogType = 'article';
            $image = $post->og_image ? asset(ltrim($post->og_image, '/')) : ($post->resolved_image_url ?? $image);
            $canonical = route('actualites.show', $post);
            if ($post->robots) {
                $robots = $post->robots;
            }
        }

        if (isset($viewData['pole']) && is_array($viewData['pole'])) {
            $title = $viewData['pole']['meta_title'] ?? $viewData['pole']['title'];
            $description = $viewData['pole']['meta_description'] ?? Str::limit($viewData['pole']['intro'] ?? '', 160);
            $keywords = $viewData['pole']['meta_keywords'] ?? $keywords;
            $image = asset($viewData['pole']['og_image'] ?? $viewData['pole']['image'] ?? $base['default_image']);
            $canonical = route('expertises.show', $viewData['pole']['slug']);
            if (! empty($viewData['pole']['robots'])) {
                $robots = $viewData['pole']['robots'];
            }
        }

        if (isset($viewData['expertise']) && $viewData['expertise'] instanceof ExpertisePole) {
            $pole = $viewData['expertise'];
            $title = $pole->meta_title ?: $pole->title;
            $description = $pole->meta_description ?: Str::limit($pole->intro ?? '', 160);
            $keywords = $pole->meta_keywords ?: $keywords;
            $image = asset(ltrim($pole->og_image ?: $pole->image, '/'));
            $canonical = route('expertises.show', $pole);
            if ($pole->robots) {
                $robots = $pole->robots;
            }
        }

        if (isset($viewData['cmsPage']) && $viewData['cmsPage'] instanceof CmsPage) {
            $cmsPage = $viewData['cmsPage'];
            $title = $cmsPage->meta_title ?: $cmsPage->title;
            $description = Str::limit(strip_tags($cmsPage->meta_description ?: $cmsPage->lead ?: ''), 160);
            $keywords = $cmsPage->meta_keywords ?: $keywords;
            if ($cmsPage->hero_image) {
                $image = asset(ltrim($cmsPage->hero_image, '/'));
            }
        }

        $siteName = $base['site_name'] ?? 'KIEL INDUSTRIES';
        $fullTitle = str_contains($title, $siteName) ? $title : "{$title} · {$siteName}";
        $image = $this->absoluteUrl($image);

        return [
            'title' => $fullTitle,
            'description' => $description,
            'keywords' => $keywords,
            'canonical' => $canonical,
            'robots' => $robots,
            'og_type' => $ogType,
            'image' => $image,
            'og_image_width' => $pageMeta['og_image_width'] ?? 1200,
            'og_image_height' => $pageMeta['og_image_height'] ?? 630,
            'locale' => $base['locale'] ?? 'fr_BJ',
            'site_name' => $siteName,
            'twitter_card' => 'summary_large_image',
            'geo' => $base['geo'] ?? [],
            'organization' => $base['organization'] ?? [],
            'json_ld' => $this->jsonLd($base, $viewData, $canonical, $title, $description, $image, $ogType),
        ];
    }

    private function absoluteUrl(string $url): string
    {
        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        if (str_starts_with($url, '//')) {
            return 'https:'.$url;
        }

        return url($url);
    }

    /** @param  array<string, mixed>  $base
     * @param  array<string, mixed>  $viewData
     * @return array<int, array<string, mixed>>
     */
    private function jsonLd(
        array $base,
        array $viewData,
        string $canonical,
        string $title,
        string $description,
        string $image,
        string $ogType
    ): array {
        $org = $base['organization'] ?? [];
        $geo = $base['geo'] ?? [];

        $graphs = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                '@id' => url('/#organization'),
                'name' => $org['legal_name'] ?? 'KIEL INDUSTRIES',
                'url' => url('/'),
                'logo' => asset('assets/img/brand/logo-kiel.svg'),
                'email' => $org['email'] ?? null,
                'telephone' => $org['phone'] ?? null,
                'taxID' => $org['ifu'] ?? null,
                'sameAs' => $org['same_as'] ?? [],
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $geo['city'] ?? 'Parakou',
                    'addressRegion' => $geo['region_name'] ?? 'Borgou',
                    'addressCountry' => $geo['country_code'] ?? 'BJ',
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                '@id' => url('/#localbusiness'),
                'name' => $org['legal_name'] ?? 'KIEL INDUSTRIES',
                'description' => $base['default_description'] ?? '',
                'url' => url('/'),
                'image' => asset($base['default_image'] ?? 'assets/img/brand/logo-kiel.svg'),
                'telephone' => $org['phone'] ?? null,
                'email' => $org['email'] ?? null,
                'priceRange' => 'FCFA',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $geo['street'] ?? 'Parakou',
                    'addressLocality' => $geo['city'] ?? 'Parakou',
                    'addressRegion' => $geo['region_name'] ?? 'Borgou',
                    'postalCode' => $geo['postal_code'] ?? '',
                    'addressCountry' => $geo['country_code'] ?? 'BJ',
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => $geo['latitude'] ?? '9.3372',
                    'longitude' => $geo['longitude'] ?? '2.6303',
                ],
                'areaServed' => [
                    ['@type' => 'Country', 'name' => 'Bénin'],
                    ['@type' => 'AdministrativeArea', 'name' => 'Afrique de l’Ouest'],
                ],
                'hasMap' => 'https://www.google.com/maps?q='.rawurlencode(
                    ($geo['latitude'] ?? '9.3372').','.($geo['longitude'] ?? '2.6303')
                ),
                'knowsAbout' => [
                    'Baobab',
                    'Nutrition',
                    'Cosmétique naturelle',
                    'Économie circulaire',
                    'Parakou',
                    'Borgou',
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                '@id' => url('/#website'),
                'url' => url('/'),
                'name' => $base['site_name'] ?? 'KIEL INDUSTRIES',
                'description' => $base['default_description'] ?? '',
                'inLanguage' => 'fr-BJ',
                'publisher' => ['@id' => url('/#organization')],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => route('boutique').'?q={search_term_string}',
                    'query-input' => 'required name=search_term_string',
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                '@id' => $canonical.'#webpage',
                'url' => $canonical,
                'name' => $title,
                'description' => $description,
                'isPartOf' => ['@id' => url('/#website')],
                'about' => ['@id' => url('/#organization')],
                'inLanguage' => 'fr-BJ',
                'primaryImageOfPage' => $image,
            ],
        ];

        if (isset($viewData['product']) && $viewData['product'] instanceof Product && $viewData['product']->exists && filled($viewData['product']->slug)) {
            $p = $viewData['product'];
            $graphs[] = [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $p->name,
                'description' => strip_tags($p->description),
                'image' => $p->image_url,
                'sku' => $p->slug,
                'brand' => ['@type' => 'Brand', 'name' => 'KIEL INDUSTRIES'],
                'offers' => [
                    '@type' => 'Offer',
                    'url' => route('boutique.show', $p),
                    'priceCurrency' => 'XOF',
                    'price' => (string) $p->price_fcfa,
                    'availability' => $p->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'seller' => ['@id' => url('/#organization')],
                ],
            ];
        }

        if (isset($viewData['post']) && $viewData['post'] instanceof Post) {
            $post = $viewData['post'];
            $graphs[] = [
                '@context' => 'https://schema.org',
                '@type' => 'NewsArticle',
                'headline' => $post->title,
                'description' => strip_tags($post->excerpt ?: ''),
                'datePublished' => $post->published_at?->toIso8601String(),
                'dateModified' => $post->updated_at?->toIso8601String(),
                'author' => ['@type' => 'Organization', 'name' => 'KIEL INDUSTRIES'],
                'publisher' => ['@id' => url('/#organization')],
                'image' => [$post->resolved_image_url ?? asset($base['default_image'])],
                'mainEntityOfPage' => $canonical,
            ];
        }

        if ($ogType === 'website' && Route::currentRouteName() === 'home') {
            $graphs[] = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => collect($base['faq'] ?? [])->map(fn ($item) => [
                    '@type' => 'Question',
                    'name' => $item['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
                ])->all(),
            ];
        }

        if (Route::currentRouteName() === 'contact') {
            $graphs[] = [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'url' => $canonical,
                'name' => $title,
                'description' => $description,
                'isPartOf' => ['@id' => url('/#website')],
                'about' => ['@id' => url('/#localbusiness')],
            ];
        }

        $breadcrumb = $this->breadcrumbList($canonical, $title, $viewData);
        if ($breadcrumb !== null) {
            $graphs[] = $breadcrumb;
        }

        return $graphs;
    }

    /** @param  array<string, mixed>  $viewData
     * @return array<string, mixed>|null
     */
    private function breadcrumbList(string $canonical, string $title, array $viewData): ?array
    {
        $routeName = Route::currentRouteName();
        if ($routeName === null || $routeName === 'home') {
            return null;
        }

        /** @var array<int, array{name: string, url: string}> $items */
        $items = [
            ['name' => 'Accueil', 'url' => route('home')],
        ];

        $staticLabels = [
            'boutique' => 'Boutique',
            'expertises' => 'Nos expertises',
            'a-propos' => 'À propos',
            'actualites' => 'Actualités',
            'nos-astuces' => 'Nos astuces',
            'nos-documents' => 'Nos documents',
            'contact' => 'Contact',
            'partenaire' => 'Partenaires',
            'mentions-legales' => 'Mentions légales',
            'politique-confidentialite' => 'Confidentialité',
            'conditions-generales' => 'CGV',
            'conditions-utilisation' => 'Conditions d’utilisation',
        ];

        if (isset($viewData['product']) && $viewData['product'] instanceof Product) {
            $items[] = ['name' => 'Boutique', 'url' => route('boutique')];
            $items[] = ['name' => $viewData['product']->name, 'url' => $canonical];
        } elseif (isset($viewData['post']) && $viewData['post'] instanceof Post) {
            $items[] = ['name' => 'Actualités', 'url' => route('actualites')];
            $items[] = ['name' => $viewData['post']->title, 'url' => $canonical];
        } elseif (isset($viewData['expertise']) && $viewData['expertise'] instanceof ExpertisePole) {
            $items[] = ['name' => 'Nos expertises', 'url' => route('expertises')];
            $items[] = ['name' => $viewData['expertise']->title, 'url' => $canonical];
        } elseif ($routeName === 'expertises.show' && isset($viewData['pole']['title'])) {
            $items[] = ['name' => 'Nos expertises', 'url' => route('expertises')];
            $items[] = ['name' => (string) $viewData['pole']['title'], 'url' => $canonical];
        } elseif (isset($staticLabels[$routeName])) {
            $items[] = ['name' => $staticLabels[$routeName], 'url' => $canonical];
        } else {
            $items[] = ['name' => Str::before($title, ' ·'), 'url' => $canonical];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(
                fn (array $item, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ]
            )->all(),
        ];
    }
}
