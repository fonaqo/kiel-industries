<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ExpertisePole extends Model
{
    protected $fillable = [
        'slug',
        'tag',
        'title',
        'intro',
        'paragraphs',
        'image',
        'boutique_category',
        'sort_order',
        'is_published',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'robots',
    ];

    protected function casts(): array
    {
        return [
            'paragraphs' => 'array',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /** @return array<string, mixed> */
    public function toPoleArray(): array
    {
        return [
            'slug' => $this->slug,
            'tag' => $this->tag,
            'title' => $this->title,
            'intro' => $this->intro,
            'paragraphs' => $this->paragraphs ?? [],
            'image' => $this->image,
            'boutique_category' => $this->boutique_category,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'og_image' => $this->og_image,
            'robots' => $this->robots,
        ];
    }
}
