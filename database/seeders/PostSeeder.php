<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'slug' => '500-productrices-filiere-borgou',
                'title' => '500+ productrices : la filière s’élargit au Borgou',
                'category' => 'Impact social',
                'excerpt' => 'Coopératives, formation qualité et revenus stables : retour sur une saison de récolte record.',
                'body' => '<p>KIEL INDUSTRIES franchit un cap symbolique avec plus de 500 productrices au Borgou. Formation, traçabilité et prix équitables renforcent la filière baobab.</p>',
                'image_url' => 'assets/img/galleries/2.png',
                'is_featured' => true,
                'published_at' => '2025-09-01 09:00:00',
            ],
            [
                'slug' => 'brevet-oapi-zero-dechet',
                'title' => 'Brevet OAPI : zéro déchet confirmé',
                'category' => 'Innovation',
                'excerpt' => 'Innovation africaine reconnue pour la valorisation intégrale du baobab.',
                'body' => '<p>Les procédés KIEL protégés par l’OAPI confirment un modèle d’économie circulaire sans gaspillage, de la pulpe à la coque.</p>',
                'image_url' => 'assets/img/sections/about/about-1.jpg',
                'is_featured' => false,
                'published_at' => '2025-07-08 09:30:00',
            ],
            [
                'slug' => 'boutique-en-ligne-livraison-benin',
                'title' => 'Boutique en ligne : livraison suivie au Bénin',
                'category' => 'Boutique',
                'excerpt' => 'Commandez pulpe, huiles et soins KIEL avec suivi de commande depuis Parakou.',
                'body' => '<p>La boutique KIEL INDUSTRIES permet de commander en ligne avec un parcours panier simplifié et une préparation des colis depuis nos ateliers.</p>',
                'image_url' => 'assets/img/sections/about/about-2.jpg',
                'is_featured' => false,
                'published_at' => '2025-06-12 10:00:00',
            ],
            [
                'slug' => 'programme-nutrition-communautaire',
                'title' => 'Programme nutrition : super-aliments au Borgou',
                'category' => 'Nutrition',
                'excerpt' => 'Poudres de feuilles et pulpe de baobab au service de la lutte contre la malnutrition.',
                'body' => '<p>KIEL INDUSTRIES déploie des actions de sensibilisation et de distribution de produits nutritifs avec des partenaires locaux.</p>',
                'image_url' => 'assets/img/sections/decouvre/decouvre-2.jpg',
                'is_featured' => false,
                'published_at' => '2025-05-20 08:45:00',
            ],
            [
                'slug' => 'huile-baobab-certification-qualite',
                'title' => 'Huile de baobab : lot traçable, pression à froid',
                'category' => 'Cosmétique',
                'excerpt' => 'Contrôle qualité renforcé sur la gamme dermo-botanique KIEL.',
                'body' => '<p>Chaque flacon d’huile pure est issu de graines sélectionnées et pressées à froid à Parakou, avec fiche lot et traçabilité coopérative.</p>',
                'image_url' => 'assets/img/sections/decouvre/decouvre-1.jpg',
                'is_featured' => false,
                'published_at' => '2025-04-03 11:15:00',
            ],
            [
                'slug' => 'artisanat-coques-upcycling',
                'title' => 'Artisanat : les coques deviennent créations',
                'category' => 'Artisanat',
                'excerpt' => 'Boucles, coffrets et accessoires valorisent les coques de baobab.',
                'body' => '<p>L’atelier artisanal KIEL transforme les coques en pièces uniques, créant des emplois verts et un revenu complémentaire pour les coopératives.</p>',
                'image_url' => 'assets/img/sections/about/about-2.jpg',
                'is_featured' => false,
                'published_at' => '2025-03-18 14:00:00',
            ],
            [
                'slug' => 'partenariat-pavrib-land-accelerator',
                'title' => 'PAVRIB & Land Accelerator : filière renforcée',
                'category' => 'Partenariats',
                'excerpt' => 'Des appuis stratégiques pour la restauration des paysages et l’export.',
                'body' => '<p>KIEL INDUSTRIES s’appuie sur des partenaires reconnus pour accélérer la filière baobab, la R&amp;D et l’accès aux marchés.</p>',
                'image_url' => 'assets/img/sections/about/about-1.jpg',
                'is_featured' => false,
                'published_at' => '2025-02-07 09:00:00',
            ],
            [
                'slug' => 'cafe-baobab-torrefaction-parakou',
                'title' => 'Café de baobab : torréfaction à Parakou',
                'category' => 'Produits',
                'excerpt' => 'Une boisson sans caféine, 100 % locale, issue des graines valorisées.',
                'body' => '<p>Le café de baobab KIEL est torréfié au Borgou et s’inscrit dans la valorisation intégrale du fruit, sans gaspillage.</p>',
                'image_url' => 'assets/img/sections/about/about-3.jpg',
                'is_featured' => false,
                'published_at' => '2025-01-22 16:30:00',
            ],
        ];

        Post::query()->whereNotIn('slug', collect($posts)->pluck('slug'))->delete();

        foreach ($posts as $index => $post) {
            if (! isset($post['published_at']) || $post['published_at'] === null) {
                $post['published_at'] = now()->subDays($index + 1);
            }
            Post::query()->updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
