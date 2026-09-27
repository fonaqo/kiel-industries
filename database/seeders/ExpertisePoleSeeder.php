<?php

namespace Database\Seeders;

use App\Models\ExpertisePole;
use Illuminate\Database\Seeder;

class ExpertisePoleSeeder extends Seeder
{
    public function run(): void
    {
        $poles = [
            [
                'slug' => 'filiere-baobab-kiel',
                'tag' => 'Marque KIEL · Économie circulaire',
                'title' => 'Valorisation du baobab',
                'intro' => 'Production, transformation et commercialisation via la marque KIEL selon un modèle d’économie circulaire zéro déchet.',
                'paragraphs' => [
                    'KIEL INDUSTRIES intervient sur toute la chaîne du baobab : récolte raisonnée au Borgou, ateliers de transformation à Parakou et mise en marché des gammes alimentaires, cosmétiques et artisanales.',
                    'Chaque composante du fruit est valorisée — pulpe, feuilles, graines, coques — dans une logique de restauration des terres dégradées et de création d’emplois verts pour les femmes rurales. Une innovation clé est protégée par un brevet d’invention (OAPI).',
                ],
                'image' => 'assets/img/poles/1.png',
                'boutique_category' => null,
                'sort_order' => 1,
            ],
            [
                'slug' => 'conseil-nutritionnel',
                'tag' => 'Conseil nutritionnel',
                'title' => 'Conseil nutritionnel',
                'intro' => 'Accompagnement nutritionnel ancré au Bénin : super-aliments baobab, programmes et sensibilisation.',
                'paragraphs' => [
                    'KIEL INDUSTRIES propose un conseil nutritionnel autour des produits de la marque KIEL : poudres de pulpe et de feuilles, café et biscuits de baobab, riches en vitamine C et fibres.',
                    'Familles, écoles, ONG et partenaires institutionnels bénéficient d’approches adaptées pour lutter contre la malnutrition et promouvoir une alimentation locale à forte valeur ajoutée.',
                ],
                'image' => 'assets/img/poles/2.png',
                'boutique_category' => 'nutrition',
                'sort_order' => 2,
            ],
            [
                'slug' => 'gestion-projets',
                'tag' => 'Gestion de projets',
                'title' => 'Gestion de projets',
                'intro' => 'Pilotage de projets agroécologiques, filière baobab et partenariats à impact au Borgou et au Bénin.',
                'paragraphs' => [
                    'De la faisabilité au déploiement, KIEL INDUSTRIES accompagne distributeurs, industriels, ONG et institutions sur des projets liés à la nutrition, à la restauration des paysages et à l’économie circulaire.',
                    'Notre expérience terrain — transformation agroalimentaire, développement communautaire et restauration des écosystèmes — sécurise la mise en œuvre et le suivi des initiatives partenaires.',
                ],
                'image' => 'assets/img/poles/4.png',
                'boutique_category' => null,
                'sort_order' => 3,
            ],
            [
                'slug' => 'mentorat',
                'tag' => 'Mentorat',
                'title' => 'Mentorat & transmission',
                'intro' => 'Transmission de savoir-faire, accompagnement des entrepreneurs et renforcement des coopératives féminines.',
                'paragraphs' => [
                    'KIEL INDUSTRIES investit dans le mentorat des acteurs de la filière baobab : qualité, traçabilité, marketing de la marque KIEL et bonnes pratiques agroécologiques.',
                    'Le mentorat relie les savoirs des productrices du Borgou, l’innovation brevetée et les exigences des marchés locaux et internationaux.',
                ],
                'image' => 'assets/img/galleries/2.png',
                'boutique_category' => null,
                'sort_order' => 4,
            ],
        ];

        $slugs = collect($poles)->pluck('slug');
        ExpertisePole::query()->whereNotIn('slug', $slugs)->delete();

        foreach ($poles as $pole) {
            ExpertisePole::query()->updateOrCreate(['slug' => $pole['slug']], $pole + ['is_published' => true]);
        }
    }
}
