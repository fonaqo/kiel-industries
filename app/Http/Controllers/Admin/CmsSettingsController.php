<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CmsSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsSettingsController extends Controller
{
    /** @var list<string> */
    private const TABS = ['referencement', 'organisation', 'geo', 'reseaux', 'pages', 'integrations'];

    public function edit(Request $request, CmsSettings $cms): View
    {
        $tab = $request->query('tab', 'referencement');
        if (! in_array($tab, self::TABS, true)) {
            $tab = 'referencement';
        }

        $seo = array_replace_recursive(config('kiel.seo', []), $cms->get('seo') ?? []);
        $social = $cms->get('social') ?? config('kiel.social', []);
        $shop = array_replace_recursive(config('kiel.currency', []), $cms->get('shop') ?? []);
        $integrations = array_replace([
            'google_analytics_id' => '',
            'google_tag_manager_id' => '',
            'meta_pixel_id' => '',
            'head_html' => '',
            'body_html' => '',
        ], $cms->get('integrations') ?? []);

        return view('cms-admin.settings.edit', [
            'page' => 'admin',
            'title' => 'Paramètres',
            'tab' => $tab,
            'tabs' => self::TABS,
            'seoSettings' => $seo,
            'socialLinks' => $social,
            'shopSettings' => $shop,
            'integrationSettings' => $integrations,
        ]);
    }

    public function update(Request $request, CmsSettings $cms): RedirectResponse
    {
        $tab = $request->input('_tab', 'referencement');

        return match ($tab) {
            'referencement' => $this->updateReferencement($request, $cms),
            'organisation' => $this->updateOrganisation($request, $cms),
            'geo' => $this->updateGeo($request, $cms),
            'boutique' => $this->updateShop($request, $cms),
            'reseaux' => $this->updateSocial($request, $cms),
            'pages' => $this->updatePages($request, $cms),
            'integrations' => $this->updateIntegrations($request, $cms),
            default => back()->with('status', 'Onglet inconnu.'),
        };
    }

    private function updateReferencement(Request $request, CmsSettings $cms): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'default_title' => ['required', 'string', 'max:160'],
            'default_description' => ['required', 'string', 'max:500'],
            'default_keywords' => ['nullable', 'string', 'max:500'],
            'default_image' => ['nullable', 'string', 'max:255'],
            'locale' => ['nullable', 'string', 'max:12'],
        ]);

        $this->mergeSeo($cms, $data);

        return redirect()->route('admin.cms.settings.edit', ['tab' => 'referencement'])->with('status', 'Référencement enregistré.');
    }

    private function updateOrganisation(Request $request, CmsSettings $cms): RedirectResponse
    {
        $data = $request->validate([
            'legal_name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'ifu' => ['nullable', 'string', 'max:40'],
            'same_as' => ['nullable', 'string'],
        ]);

        $sameAs = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $data['same_as'] ?? ''))));

        $this->mergeSeo($cms, [
            'organization' => [
                'legal_name' => $data['legal_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'ifu' => $data['ifu'],
                'same_as' => $sameAs,
            ],
        ]);

        return redirect()->route('admin.cms.settings.edit', ['tab' => 'organisation'])->with('status', 'Organisation enregistrée.');
    }

    private function updateGeo(Request $request, CmsSettings $cms): RedirectResponse
    {
        $data = $request->validate([
            'region' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:80'],
            'region_name' => ['nullable', 'string', 'max:80'],
            'country_code' => ['nullable', 'string', 'max:4'],
            'street' => ['nullable', 'string', 'max:160'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'string', 'max:20'],
            'longitude' => ['nullable', 'string', 'max:20'],
        ]);

        $this->mergeSeo($cms, ['geo' => $data]);

        return redirect()->route('admin.cms.settings.edit', ['tab' => 'geo'])->with('status', 'Géolocalisation enregistrée.');
    }

    private function updateShop(Request $request, CmsSettings $cms): RedirectResponse
    {
        $data = $request->validate([
            'default' => ['required', 'string', 'max:8'],
            'fcfa_per_eur' => ['required', 'numeric', 'min:1'],
            'fcfa_per_usd' => ['required', 'numeric', 'min:1'],
        ]);

        $cms->put('shop', $data);

        return redirect()->route('admin.cms.settings.edit', ['tab' => 'boutique'])->with('status', 'Paramètres boutique enregistrés.');
    }

    private function updateSocial(Request $request, CmsSettings $cms): RedirectResponse
    {
        $labels = $request->input('label', []);
        $urls = $request->input('url', []);
        $icons = $request->input('icon', []);
        $links = [];

        foreach ($labels as $i => $label) {
            $label = trim((string) $label);
            $url = trim((string) ($urls[$i] ?? ''));
            if ($label === '' && $url === '') {
                continue;
            }
            $links[] = [
                'label' => $label ?: 'Réseau social',
                'url' => $url ?: '#',
                'icon' => (string) ($icons[$i] ?? 'instagram'),
            ];
        }

        $cms->put('social', $links);

        return redirect()->route('admin.cms.settings.edit', ['tab' => 'reseaux'])->with('status', 'Réseaux sociaux enregistrés.');
    }

    private function updatePages(Request $request, CmsSettings $cms): RedirectResponse
    {
        $routes = $request->input('page_route', []);
        $titles = $request->input('page_title', []);
        $descriptions = $request->input('page_description', []);
        $keywords = $request->input('page_keywords', []);
        $pages = [];

        foreach ($routes as $i => $route) {
            $route = trim((string) $route);
            if ($route === '') {
                continue;
            }
            $pages[$route] = array_filter([
                'title' => trim((string) ($titles[$i] ?? '')),
                'description' => trim((string) ($descriptions[$i] ?? '')),
                'keywords' => trim((string) ($keywords[$i] ?? '')),
            ]);
        }

        $existingPages = ($cms->get('seo') ?? [])['pages'] ?? config('kiel.seo.pages', []);
        $this->mergeSeo($cms, ['pages' => array_replace_recursive($existingPages, $pages)]);

        return redirect()->route('admin.cms.settings.edit', ['tab' => 'pages'])->with('status', 'SEO des pages enregistré.');
    }

    private function updateIntegrations(Request $request, CmsSettings $cms): RedirectResponse
    {
        $data = $request->validate([
            'google_analytics_id' => ['nullable', 'string', 'max:40'],
            'google_tag_manager_id' => ['nullable', 'string', 'max:40'],
            'meta_pixel_id' => ['nullable', 'string', 'max:40'],
            'head_html' => ['nullable', 'string', 'max:50000'],
            'body_html' => ['nullable', 'string', 'max:50000'],
        ]);

        $cms->put('integrations', [
            'google_analytics_id' => trim($data['google_analytics_id'] ?? ''),
            'google_tag_manager_id' => trim($data['google_tag_manager_id'] ?? ''),
            'meta_pixel_id' => trim($data['meta_pixel_id'] ?? ''),
            'head_html' => $data['head_html'] ?? '',
            'body_html' => $data['body_html'] ?? '',
        ]);

        return redirect()->route('admin.cms.settings.edit', ['tab' => 'integrations'])->with('status', 'Intégrations enregistrées.');
    }

    /** @param  array<string, mixed>  $patch */
    private function mergeSeo(CmsSettings $cms, array $patch): void
    {
        $current = array_replace_recursive(config('kiel.seo', []), $cms->get('seo') ?? []);
        $cms->put('seo', array_replace_recursive($current, $patch));
    }
}
