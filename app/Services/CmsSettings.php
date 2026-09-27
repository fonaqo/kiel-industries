<?php

namespace App\Services;

use App\Models\CmsSetting;
use Illuminate\Support\Facades\Cache;

class CmsSettings
{
    private const CACHE_KEY = 'kiel.cms.settings';

    /** @return array<string, mixed>|null */
    public function get(string $key): ?array
    {
        $all = $this->all();

        return $all[$key] ?? null;
    }

    /** @return array<string, array<string, mixed>> */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return CmsSetting::query()
                ->pluck('value', 'key')
                ->map(fn ($v) => is_array($v) ? $v : [])
                ->all();
        });
    }

    /** @param  array<string, mixed>  $value */
    public function put(string $key, array $value): void
    {
        CmsSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget(self::CACHE_KEY);
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
