<?php

namespace Database\Seeders;

use App\Models\TipVideo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TipVideoSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Découvrir la filière baobab KIEL à Parakou',
                'description' => 'Présentation de la transformation locale, de la collecte et des engagements qualité au Borgou.',
                'youtube_id' => 'LXb3EKWsInQ',
                'duration_seconds' => 212,
                'sort_order' => 1,
                'category' => 'filiere',
            ],
            [
                'title' => 'Utiliser la poudre de pulpe de baobab au quotidien',
                'description' => 'Idées simples pour smoothies, céréales et recettes familiales avec les produits KIEL.',
                'youtube_id' => 'ysz5S6PUM-U',
                'duration_seconds' => 180,
                'sort_order' => 2,
                'category' => 'nutrition',
            ],
            [
                'title' => 'Huile et baume baobab : gestes et conservation',
                'description' => 'Conseils d’application pour la peau et les cheveux, et bonnes pratiques de stockage.',
                'youtube_id' => 'aqz-KE-bpKQ',
                'duration_seconds' => 245,
                'sort_order' => 3,
                'category' => 'soins',
            ],
            [
                'title' => 'De la récolte à la boutique : circuits courts',
                'description' => 'Traçabilité, coopératives partenaires et impact social de KIEL INDUSTRIES.',
                'youtube_id' => 'jNQXAC9IVRw',
                'duration_seconds' => 156,
                'sort_order' => 4,
                'category' => 'impact',
            ],
        ];

        foreach ($items as $item) {
            TipVideo::query()->updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    ...$item,
                    'is_published' => true,
                    'published_at' => now()->subDays($item['sort_order']),
                ]
            );
        }
    }
}
