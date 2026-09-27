<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CmsUploads
{
    public static function storeDocument(?UploadedFile $file, string $subdir = 'cms/documents'): ?string
    {
        if ($file === null || ! $file->isValid()) {
            return null;
        }

        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'document';
        $name = $base.'-'.Str::random(6).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($subdir, $name, 'public');

        return 'storage/'.$path;
    }

    public static function storeImage(?UploadedFile $file, string $subdir = 'cms'): ?string
    {
        if ($file === null || ! $file->isValid()) {
            return null;
        }

        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $name = $base.'-'.Str::random(6).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($subdir, $name, 'public');

        return 'storage/'.$path;
    }

    public static function resolvePath(Request $request, string $urlField, string $fileField, ?string $existing = null): ?string
    {
        if ($request->hasFile($fileField)) {
            $stored = self::storeImage($request->file($fileField));

            return $stored ?? $existing;
        }

        $url = trim((string) $request->input($urlField, ''));
        if ($url !== '') {
            return $url;
        }

        return $existing;
    }

    /**
     * @return list<string>
     */
    public static function resolveGallery(Request $request, string $linesField, string $filesField, ?array $existing = null): array
    {
        $items = is_array($existing) ? array_values(array_filter(array_map('strval', $existing))) : [];

        $lines = trim((string) $request->input($linesField, ''));
        if ($lines !== '') {
            foreach (preg_split('/\r\n|\r|\n|,/', $lines) as $line) {
                $line = trim($line);
                if ($line !== '') {
                    $items[] = $line;
                }
            }
        }

        if ($request->hasFile($filesField)) {
            foreach ($request->file($filesField) as $file) {
                $stored = self::storeImage($file, 'cms/products');
                if ($stored !== null) {
                    $items[] = $stored;
                }
            }
        }

        return array_values(array_unique($items));
    }

    public static function publicUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}
