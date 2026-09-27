<?php

namespace App\Http\Controllers;

use App\Models\ExpertisePole;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        $static = [
            'home' => ['priority' => '1.0', 'changefreq' => 'weekly'],
            'boutique' => ['priority' => '0.9', 'changefreq' => 'daily'],
            'expertises' => ['priority' => '0.85', 'changefreq' => 'monthly'],
            'a-propos' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            'actualites' => ['priority' => '0.85', 'changefreq' => 'weekly'],
            'nos-astuces' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'nos-documents' => ['priority' => '0.75', 'changefreq' => 'monthly'],
            'contact' => ['priority' => '0.75', 'changefreq' => 'monthly'],
            'partenaire' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'mentions-legales' => ['priority' => '0.3', 'changefreq' => 'yearly'],
            'politique-confidentialite' => ['priority' => '0.3', 'changefreq' => 'yearly'],
            'conditions-generales' => ['priority' => '0.3', 'changefreq' => 'yearly'],
            'conditions-utilisation' => ['priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach ($static as $name => $meta) {
            if (Route::has($name)) {
                $urls[] = $this->entry(route($name), $meta['priority'], $meta['changefreq']);
            }
        }

        $poleSlugs = ExpertisePole::query()->published()->orderBy('sort_order')->pluck('slug');
        if ($poleSlugs->isEmpty()) {
            $poleSlugs = collect(config('kiel.expertise_poles', []))->pluck('slug');
        }
        foreach ($poleSlugs as $slug) {
            $urls[] = $this->entry(route('expertises.show', $slug), '0.75', 'monthly');
        }

        Product::query()->where('is_active', true)->orderBy('updated_at', 'desc')->each(function (Product $product) use (&$urls) {
            $urls[] = $this->entry(route('boutique.show', $product), '0.8', 'weekly', $product->updated_at);
        });

        Post::query()->published()->orderBy('published_at', 'desc')->each(function (Post $post) use (&$urls) {
            $urls[] = $this->entry(route('actualites.show', $post), '0.7', 'monthly', $post->updated_at);
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            .implode('', $urls)
            .'</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    private function entry(string $loc, string $priority, string $changefreq, $lastmod = null): string
    {
        $last = $lastmod ? $lastmod->toAtomString() : now()->toAtomString();

        return '<url>'
            .'<loc>'.e($loc).'</loc>'
            .'<lastmod>'.e($last).'</lastmod>'
            .'<changefreq>'.e($changefreq).'</changefreq>'
            .'<priority>'.e($priority).'</priority>'
            .'</url>';
    }
}
