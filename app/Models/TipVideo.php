<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TipVideo extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'youtube_id',
        'duration_seconds',
        'sort_order',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
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

    public function embedUrl(): string
    {
        return 'https://www.youtube-nocookie.com/embed/'.urlencode($this->youtube_id);
    }

    public function watchUrl(): string
    {
        return 'https://www.youtube.com/watch?v='.urlencode($this->youtube_id);
    }

    public function thumbnailUrl(string $quality = 'hqdefault'): string
    {
        return 'https://img.youtube.com/vi/'.urlencode($this->youtube_id).'/'.$quality.'.jpg';
    }

    public function categoryLabel(): string
    {
        return config('kiel.tip_video_categories.'.$this->category, ucfirst($this->category));
    }

    public function formattedDuration(): ?string
    {
        if ($this->duration_seconds === null || $this->duration_seconds <= 0) {
            return null;
        }

        $m = intdiv($this->duration_seconds, 60);
        $s = $this->duration_seconds % 60;

        return sprintf('%d:%02d', $m, $s);
    }
}
