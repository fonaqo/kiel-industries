<?php

namespace App\Services;

use App\Models\CmsBlock;
use Illuminate\Support\Facades\Cache;

class CmsBlocks
{
    private const CACHE_KEY = 'kiel.cms.blocks';

    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();
        if (array_key_exists($key, $all)) {
            return $all[$key];
        }

        return $default;
    }

    /** @return array<string, mixed> */
    public function group(string $prefix): array
    {
        $out = [];
        $needle = $prefix.'.';
        foreach ($this->all() as $key => $value) {
            if (str_starts_with($key, $needle)) {
                $out[substr($key, strlen($needle))] = $value;
            }
        }

        return $out;
    }

    /** @return array<string, mixed> */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return CmsBlock::query()
                ->orderBy('key')
                ->get()
                ->mapWithKeys(function (CmsBlock $block) {
                    return [$block->key => $block->decodedContent()];
                })
                ->all();
        });
    }

    public function assetUrl(?string $path, string $fallback = 'assets/img/brand/logo-kiel.png'): string
    {
        if ($path === null || $path === '') {
            return asset($fallback);
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    /** @param  array<int, array<string, mixed>>|null  $default */
    public function json(string $key, ?array $default = null): array
    {
        $value = $this->get($key, $default ?? []);
        if (is_array($value)) {
            return $value;
        }

        return $default ?? [];
    }

    public function put(string $key, mixed $content, string $type = 'text'): void
    {
        $stored = $type === 'json' ? json_encode($content, JSON_UNESCAPED_UNICODE) : (string) $content;
        CmsBlock::query()->where('key', $key)->update(['content' => $stored, 'type' => $type]);
        Cache::forget(self::CACHE_KEY);
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
