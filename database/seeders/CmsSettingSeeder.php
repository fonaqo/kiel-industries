<?php

namespace Database\Seeders;

use App\Models\CmsSetting;
use Illuminate\Database\Seeder;

class CmsSettingSeeder extends Seeder
{
    public function run(): void
    {
        $seo = [
            'site_name' => 'KIEL INDUSTRIES',
            'default_title' => 'KIEL INDUSTRIES — Baobab, nutrition & cosmétique au Bénin',
            'default_description' => 'KIEL INDUSTRIES transforme le baobab à Parakou (Borgou, Bénin) : super-aliments, soins dermo-botaniques, artisanat zéro déchet, 500+ productrices, brevet OAPI. Boutique en ligne FCFA, livraison Bénin et international.',
            'default_keywords' => 'KIEL INDUSTRIES, baobab Bénin, Parakou, Borgou, huile baobab, poudre pulpe, cosmétique naturelle, nutrition afrique, OAPI, économie circulaire, boutique FCFA, femmes rurales, super-aliment',
            'default_image' => 'assets/img/ressources/home-1.png',
            'locale' => 'fr_BJ',
            'geo' => config('kiel.seo.geo'),
            'organization' => config('kiel.seo.organization'),
            'faq' => [
                ['q' => 'Où est située KIEL INDUSTRIES ?', 'a' => 'Siège et ateliers à Parakou, Borgou, Bénin. Filière baobab au Borgou et Alibori.'],
                ['q' => 'Quels produits propose KIEL ?', 'a' => 'Nutrition (pulpe, feuilles, café), cosmétiques (huile, baumes), artisanat upcycling et coffrets cadeaux.'],
                ['q' => 'Livrez-vous au Bénin et à l’étranger ?', 'a' => 'Oui : livraison au Bénin et expédition internationale selon destination et stock.'],
                ['q' => 'KIEL est-elle engagée socialement ?', 'a' => 'Plus de 500 productrices partenaires, emplois verts et restauration des peuplements de baobabs.'],
            ],
            'pages' => config('kiel.seo.pages'),
        ];

        CmsSetting::query()->updateOrCreate(
            ['key' => 'seo'],
            ['value' => $seo]
        );
    }
}
