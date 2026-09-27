<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'lead',
        'body',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'hero_image',
        'section',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function heroImageUrl(): ?string
    {
        if (! $this->hero_image) {
            return null;
        }

        return str_starts_with($this->hero_image, 'http')
            ? $this->hero_image
            : asset(ltrim($this->hero_image, '/'));
    }
}
