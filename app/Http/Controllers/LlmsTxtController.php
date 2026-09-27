<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class LlmsTxtController extends Controller
{
    public function __invoke(): Response
    {
        $base = config('kiel.seo', []);
        $org = $base['organization'] ?? [];
        $geo = $base['geo'] ?? [];

        $lines = [
            '# KIEL INDUSTRIES',
            '',
            '> '.($base['default_description'] ?? ''),
            '',
            '## Entité',
            '- Nom : '.($org['legal_name'] ?? 'KIEL INDUSTRIES'),
            '- Siège : '.($geo['city'] ?? 'Parakou').', '.($geo['region_name'] ?? 'Borgou').', Bénin',
            '- IFU : '.($org['ifu'] ?? ''),
            '- E-mail : '.($org['email'] ?? ''),
            '- Téléphone : '.($org['phone'] ?? ''),
            '',
            '## Pages clés',
            '- Accueil : '.route('home'),
            '- Boutique : '.route('boutique'),
            '- Expertises : '.route('expertises'),
            '- À propos : '.route('a-propos'),
            '- Actualités : '.route('actualites'),
            '- Contact : '.route('contact'),
            '- Partenaire : '.route('partenaire'),
            '',
            '## Thématiques',
            '- Filière baobab intégrée, économie circulaire, zéro déchet',
            '- Nutrition, super-aliments, lutte contre la malnutrition (Bénin, Borgou)',
            '- Cosmétique et soins dermo-botaniques (huile de baobab, karité)',
            '- Artisanat, coopératives féminines, impact social à Parakou',
            '- Innovation OAPI, traçabilité, boutique en ligne FCFA',
            '',
            '## Sitemap',
            '- '.url('/sitemap.xml'),
        ];

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
