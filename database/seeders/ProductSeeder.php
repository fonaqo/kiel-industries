<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Alimentation & nutrition',
                'slug' => 'nutrition',
                'sort_order' => 1,
                'nav_teaser' => 'Poudres, feuilles et super-aliments de baobab.',
                'image' => 'assets/img/categories/nutrition.webp',
            ],
            [
                'name' => 'Breuvages',
                'slug' => 'breuvages',
                'sort_order' => 2,
                'nav_teaser' => 'Café et whisky de baobab.',
                'image' => 'assets/img/categories/breuvage.webp',
            ],
            [
                'name' => 'Cosmétiques, bien-être & soins',
                'slug' => 'soins',
                'sort_order' => 3,
                'nav_teaser' => 'Huile, baume et pommade au baobab.',
                'image' => 'assets/img/categories/cosmetique.webp',
            ],
            [
                'name' => 'Artisanat & accessoires',
                'slug' => 'artisanat',
                'sort_order' => 4,
                'nav_teaser' => 'Boucles d’oreilles et créations filière.',
                'image' => 'assets/img/categories/artisanat.jpeg',
            ],
        ];

        foreach ($categories as $cat) {
            Category::query()->updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $bySlug = Category::query()->pluck('id', 'slug');

        $products = [
            [
                'category_id' => $bySlug['nutrition'],
                'name' => 'Poudre de feuilles de baobab',
                'slug' => 'poudre-feuilles-baobab',
                'description' => 'Feuilles séchées et moulues, super-aliment riche en nutriments. Récolte et transformation au Borgou.',
                'benefits' => [
                    'Apport en fer, calcium et antioxydants pour renforcer l’organisme.',
                    'Feuilles séchées à basse température pour préserver les nutriments.',
                    'Idéal en infusion, smoothie ou incorporation culinaire.',
                    'Collecte et mouture à Parakou — filière 100 % locale.',
                ],
                'price_fcfa' => 5500,
                'image_url' => 'assets/img/galleries/4.png',
                'badge' => 'Nutrition',
                'rating' => 4.8,
                'is_featured' => true,
            ],
            [
                'category_id' => $bySlug['nutrition'],
                'name' => 'Poudre de pulpe de baobab 250 g',
                'slug' => 'poudre-pulpe-250g',
                'description' => 'Vitamine C naturelle et calcium bioassimilable. Best-seller marque KIEL.',
                'benefits' => [
                    'Pulpe de baobab : vitamine C naturelle et fibres prébiotiques.',
                    'Soutient l’immunité et la vitalité des enfants comme des adultes.',
                    'Format 250 g pratique pour le petit-déjeuner et les recettes.',
                    'Best-seller KIEL — le plus demandé en boutique.',
                ],
                'price_fcfa' => 6500,
                'compare_price_fcfa' => 8000,
                'image_url' => 'assets/img/galleries/4.png',
                'badge' => 'Best-seller',
                'rating' => 4.9,
                'is_featured' => true,
                'is_best_seller' => true,
                'on_sale' => true,
            ],
            [
                'category_id' => $bySlug['breuvages'],
                'name' => 'Café de baobab',
                'slug' => 'cafe-baobab',
                'description' => 'Breuvage aromatique à base de baobab, torréfaction maîtrisée à Parakou.',
                'price_fcfa' => 4800,
                'image_url' => 'assets/img/categories/breuvage.webp',
                'badge' => 'Breuvage',
                'rating' => 4.7,
                'is_featured' => true,
            ],
            [
                'category_id' => $bySlug['breuvages'],
                'name' => 'Whisky de baobab',
                'slug' => 'whisky-baobab',
                'description' => 'Spiritueux innovant issu de la filière baobab KIEL — édition limitée.',
                'price_fcfa' => 18500,
                'image_url' => 'assets/img/categories/breuvage.webp',
                'badge' => 'Innovation',
                'rating' => 4.6,
            ],
            [
                'category_id' => $bySlug['nutrition'],
                'name' => 'Biscuits de baobab',
                'slug' => 'biscuits-baobab',
                'description' => 'Snacking nutritif enrichi à la pulpe de baobab, idéal familles et écoles.',
                'price_fcfa' => 3200,
                'image_url' => 'assets/img/categories/nutrition.webp',
                'badge' => 'Nutrition',
                'rating' => 4.8,
            ],
            [
                'category_id' => $bySlug['soins'],
                'name' => 'Huile de baobab 50 ml',
                'slug' => 'huile-baobab-50ml',
                'description' => 'Première pression à froid, flacon pipette verre ambré.',
                'benefits' => [
                    'Première pression à froid : acides gras essentiels préservés.',
                    'Pénètre sans film gras — visage, corps et pointes des cheveux.',
                    'Flacon verre ambré protégant de la lumière.',
                    'Ingrédient star des soins KIEL au baobab.',
                ],
                'price_fcfa' => 12500,
                'compare_price_fcfa' => 15000,
                'image_url' => 'assets/img/galleries/3.png',
                'badge' => 'Pressée à froid',
                'rating' => 4.9,
                'is_featured' => true,
                'is_best_seller' => true,
                'on_sale' => true,
            ],
            [
                'category_id' => $bySlug['soins'],
                'name' => 'Baume à base de baobab',
                'slug' => 'baume-baobab',
                'description' => 'Soin dermo-botanique karité–baobab pour visage et corps.',
                'price_fcfa' => 7800,
                'image_url' => 'assets/img/categories/cosmetique.webp',
                'badge' => 'Soin',
                'rating' => 4.8,
                'is_featured' => true,
            ],
            [
                'category_id' => $bySlug['soins'],
                'name' => 'Pommade à base de baobab',
                'slug' => 'pommade-baobab',
                'description' => 'Texture onctueuse pour soins localisés, formulée à Parakou.',
                'price_fcfa' => 6200,
                'image_url' => 'assets/img/categories/cosmetique.webp',
                'badge' => 'Bien-être',
                'rating' => 4.7,
            ],
            [
                'category_id' => $bySlug['artisanat'],
                'name' => 'Boucles d’oreilles baobab',
                'slug' => 'boucles-oreilles-baobab',
                'description' => 'Artisanat circulaire à partir de coques et fibres valorisées — pièces uniques.',
                'price_fcfa' => 4500,
                'image_url' => 'assets/img/ressources/artisanat.png',
                'badge' => 'Artisanat',
                'rating' => 4.9,
                'is_featured' => true,
            ],
            [
                'category_id' => $bySlug['artisanat'],
                'name' => 'Accessoires baobab (assortiment)',
                'slug' => 'accessoires-baobab',
                'description' => 'Boucles, bracelets et créations à base de matériaux valorisés de la filière.',
                'price_fcfa' => 5200,
                'image_url' => 'assets/img/categories/artisanat.jpeg',
                'badge' => 'Fait main',
                'rating' => 4.8,
            ],
        ];

        $slugs = collect($products)->pluck('slug');
        Product::query()->whereNotIn('slug', $slugs)->delete();

        foreach ($products as $row) {
            Product::query()->updateOrCreate(
                ['slug' => $row['slug']],
                $row + ['stock' => 120, 'is_active' => true]
            );
        }

        User::query()->updateOrCreate(
            ['email' => 'client@kiel.test'],
            [
                'name' => 'Cliente Démo KIEL',
                'password' => 'password123',
                'phone' => '+229 0165728584',
                'city' => 'Parakou',
                'is_admin' => false,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@kiel.test'],
            [
                'name' => 'Admin KIEL',
                'password' => 'password123',
                'phone' => '+229 0165728584',
                'city' => 'Parakou',
                'is_admin' => true,
                'is_super_admin' => true,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'super@kiel.test'],
            [
                'name' => 'Super Admin KIEL',
                'password' => 'password123',
                'phone' => '+229 0165728584',
                'city' => 'Parakou',
                'is_admin' => true,
                'is_super_admin' => true,
            ]
        );
    }
}
