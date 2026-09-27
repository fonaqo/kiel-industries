<?php

namespace App\Support;

class CmsSeoRules
{
    /** @return array<string, mixed> */
    public static function rules(bool $withOg = true): array
    {
        $rules = [
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
        ];

        if ($withOg) {
            $rules['og_image'] = ['nullable', 'string', 'max:500'];
            $rules['robots'] = ['nullable', 'string', 'max:120'];
        }

        return $rules;
    }

    /** @param  array<string, mixed>  $data */
    public static function onlyMeta(array $data, bool $withOg = true): array
    {
        $keys = ['meta_title', 'meta_description', 'meta_keywords'];
        if ($withOg) {
            $keys[] = 'og_image';
            $keys[] = 'robots';
        }

        return array_intersect_key($data, array_flip($keys));
    }
}
