<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class PublicAssetUrl
{
    public static function fromStoragePath(?string $path, ?string $namedRoute = null): ?string
    {
        if ($path === null || trim($path) === '') {
            return null;
        }

        $normalized = str_replace('\\', '/', ltrim($path, '/'));

        if (str_starts_with($normalized, 'uploads/')) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'avatars/') && $namedRoute !== null) {
            $filename = basename($normalized);

            return $filename !== '' ? route($namedRoute, ['filename' => $filename]) : null;
        }

        return asset('storage/'.$normalized);
    }

    public static function storageExists(?string $path): bool
    {
        if ($path === null || trim($path) === '') {
            return false;
        }

        if (str_starts_with(str_replace('\\', '/', ltrim($path, '/')), 'uploads/')) {
            return is_readable(public_path($path));
        }

        return Storage::disk('public')->exists($path);
    }
}
