<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsBlock extends Model
{
    protected $fillable = [
        'key',
        'group',
        'label',
        'type',
        'content',
    ];

    public function decodedContent(): mixed
    {
        if ($this->type === 'json') {
            return json_decode($this->content ?? '[]', true) ?? [];
        }

        return $this->content ?? '';
    }
}
