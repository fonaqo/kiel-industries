<?php

namespace App\Models;

use App\Support\CmsUploads;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'nav_teaser',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => CmsUploads::publicUrl($this->image));
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
