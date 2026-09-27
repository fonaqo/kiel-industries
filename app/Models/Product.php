<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'benefits',
        'price_fcfa',
        'price_eur',
        'price_usd',
        'discount_percent',
        'compare_price_fcfa',
        'compare_price_eur',
        'compare_price_usd',
        'image_url',
        'gallery',
        'badge',
        'rating',
        'stock',
        'is_featured',
        'is_best_seller',
        'on_sale',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'robots',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'on_sale' => 'boolean',
            'is_active' => 'boolean',
            'rating' => 'float',
            'benefits' => 'array',
            'gallery' => 'array',
            'price_eur' => 'float',
            'price_usd' => 'float',
            'compare_price_eur' => 'float',
            'compare_price_usd' => 'float',
        ];
    }

    /**
     * @return list<string>
     */
    public function galleryPaths(): array
    {
        $main = (string) ($this->getRawOriginal('image_url') ?? '');
        $extra = is_array($this->gallery) ? $this->gallery : [];
        return array_values(array_unique(array_filter([...($main !== '' ? [$main] : []), ...array_map('strval', $extra)])));
    }

    public function displayPriceAttributes(): array
    {
        return [
            'fcfa' => (int) $this->price_fcfa,
            'eur' => $this->price_eur,
            'usd' => $this->price_usd,
        ];
    }

    /**
     * @return list<string>
     */
    public function virtuesList(): array
    {
        $items = $this->benefits;
        if (is_array($items) && $items !== []) {
            return array_values(array_filter(array_map('strval', $items)));
        }

        return match ($this->category?->slug) {
            'nutrition' => [
                'Riche en fibres, antioxydants et minéraux issus du baobab africain.',
                'Soutient l’énergie au quotidien et une alimentation équilibrée.',
                'Transformation locale à Parakou, traçabilité filière KIEL.',
                'Sans additifs superflus — valorisation des ressources du Borgou.',
            ],
            'soins' => [
                'Formules dermo-botaniques à base d’huile et de beurre de baobab.',
                'Nutrition cutanée : souplesse, confort et éclat naturel.',
                'Textures pensées pour peaux sensibles et climats tropicaux.',
                'Flacons et pots adaptés à un usage quotidien responsable.',
            ],
            'artisanat' => [
                'Créations artisanales valorisant les coques et fibres de baobab.',
                'Pièces uniques ou petites séries, circuit court depuis le Borgou.',
                'Soutien aux savoir-faire locaux et à l’économie circulaire KIEL.',
                'Idéal comme cadeau responsable et porteur de sens.',
            ],
            default => [
                'Produit de la filière baobab KIEL INDUSTRIES (Parakou, Bénin).',
                'Qualité contrôlée, chaîne locale et impact social mesurable.',
                'Conçu pour révéler les vertus traditionnelles du baobab.',
            ],
        };
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function publishedReviews(): HasMany
    {
        return $this->reviews()->where('is_published', true)->latest();
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function (?string $value): string {
            if ($value === null || $value === '') {
                return asset('assets/img/brand/logo-kiel.png');
            }
            if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                return $value;
            }

            return asset(ltrim($value, '/'));
        });
    }

    public function discountPercent(): ?int
    {
        if ($this->discount_percent !== null && $this->discount_percent > 0) {
            return min(100, (int) $this->discount_percent);
        }

        if (! $this->compare_price_fcfa || $this->compare_price_fcfa <= $this->price_fcfa) {
            return null;
        }

        return (int) round((1 - $this->price_fcfa / $this->compare_price_fcfa) * 100);
    }
}
