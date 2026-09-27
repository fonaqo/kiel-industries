<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviewers = [
            User::query()->updateOrCreate(
                ['email' => 'avis1@kiel.test'],
                ['name' => 'Aminata D.', 'password' => 'password123', 'city' => 'Parakou']
            ),
            User::query()->updateOrCreate(
                ['email' => 'avis2@kiel.test'],
                ['name' => 'Jean-Marc K.', 'password' => 'password123', 'city' => 'Cotonou']
            ),
            User::query()->updateOrCreate(
                ['email' => 'avis3@kiel.test'],
                ['name' => 'Fatou B.', 'password' => 'password123', 'city' => 'Parakou']
            ),
            User::query()->firstOrCreate(
                ['email' => 'client@kiel.test'],
                ['name' => 'Cliente Démo KIEL', 'password' => 'password123', 'city' => 'Parakou']
            ),
        ];

        $reviews = [
            [
                'product_slug' => 'poudre-feuilles-baobab',
                'user' => $reviewers[0],
                'rating' => 5,
                'body' => 'Excellente qualité, goût neutre et facile à mélanger dans le thiof ou les jus. Livraison rapide à Parakou.',
            ],
            [
                'product_slug' => 'poudre-pulpe-250g',
                'user' => $reviewers[1],
                'rating' => 5,
                'body' => 'La pulpe KIEL est très parfumée, parfaite pour les smoothies du matin. On sent le produit frais et bien transformé.',
            ],
            [
                'product_slug' => 'huile-baobab-50ml',
                'user' => $reviewers[2],
                'rating' => 4,
                'body' => 'Huile légère, pénètre bien la peau. J’utilise aussi quelques gouttes sur les pointes des cheveux, très satisfaite.',
            ],
            [
                'product_slug' => 'baume-baobab',
                'user' => $reviewers[0],
                'rating' => 5,
                'body' => 'Texture fondante, odeur discrète. Idéal après le soleil, toute la famille l’utilise.',
            ],
            [
                'product_slug' => 'cafe-baobab',
                'user' => $reviewers[3],
                'rating' => 4,
                'body' => 'Arôme original, moins amer qu’un café classique. J’aime le côté local et la démarche de KIEL.',
            ],
            [
                'product_slug' => 'biscuits-baobab',
                'user' => $reviewers[1],
                'rating' => 5,
                'body' => 'Croustillants, pas trop sucrés — les enfants adorent. Bonne idée cadeau avec les coffrets.',
            ],
            [
                'product_slug' => 'poudre-feuilles-baobab',
                'user' => $reviewers[2],
                'rating' => 4,
                'body' => 'Je l’ajoute à la bouillie pour les petits. Bon rapport qualité-prix pour un super-aliment local.',
            ],
        ];

        foreach ($reviews as $row) {
            $product = Product::query()->where('slug', $row['product_slug'])->first();
            if (! $product) {
                continue;
            }

            ProductReview::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                    'user_id' => $row['user']->id,
                ],
                [
                    'rating' => $row['rating'],
                    'body' => $row['body'],
                    'is_published' => true,
                ]
            );
        }
    }
}
