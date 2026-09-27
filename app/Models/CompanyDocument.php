<?php

namespace App\Models;

use App\Support\CmsUploads;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'file_path',
        'issuer',
        'issued_at',
        'sort_order',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'issued_at' => 'date',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->where(function (Builder $q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function categoryLabel(): string
    {
        return config('kiel.document_categories.'.$this->category, ucfirst($this->category));
    }

    public function fileUrl(): ?string
    {
        return CmsUploads::publicUrl($this->file_path);
    }
}
