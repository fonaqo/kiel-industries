<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class KielImage
{
    /**
     * URL publique : préfère une variante .webp à côté du fichier source.
     */
    public static function url(string $path): string
    {
        $path = trim($path);
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path) || str_starts_with($path, '//')) {
            return $path;
        }

        $relative = ltrim($path, '/');
        if (! str_starts_with($relative, 'assets/')) {
            $relative = 'assets/'.ltrim($relative, '/');
        }

        $webpRelative = preg_replace('/\.(jpe?g|png)$/i', '.webp', $relative);
        if ($webpRelative && is_file(public_path($webpRelative))) {
            return asset($webpRelative);
        }

        return asset($relative);
    }

    /**
     * @param  array<string, scalar|null>  $attributes
     */
    public static function tag(string $path, string $alt = '', array $attributes = []): string
    {
        $relative = self::relativePublicPath($path);
        if ($relative === null) {
            return '';
        }

        $webpRelative = preg_replace('/\.(jpe?g|png)$/i', '.webp', $relative);
        $hasWebp = $webpRelative && is_file(public_path($webpRelative));
        $fallback = asset($relative);

        $defaults = [
            'alt' => $alt,
            'loading' => 'lazy',
            'decoding' => 'async',
        ];
        $attrs = array_merge($defaults, $attributes);
        $attrString = self::attributes($attrs);

        if (! $hasWebp) {
            return '<img src="'.e($fallback).'"'.$attrString.'/>';
        }

        return '<picture>'
            .'<source srcset="'.e(asset($webpRelative)).'" type="image/webp"/>'
            .'<img src="'.e($fallback).'"'.$attrString.'/>'
            .'</picture>';
    }

    public static function relativePublicPath(string $path): ?string
    {
        if (preg_match('#^https?://#i', $path)) {
            return null;
        }

        $relative = ltrim($path, '/');
        if (! str_starts_with($relative, 'assets/')) {
            $relative = 'assets/'.ltrim($relative, '/');
        }

        return is_file(public_path($relative)) ? $relative : null;
    }

    /** @param  array<string, scalar|null>  $attributes */
    private static function attributes(array $attributes): string
    {
        $html = '';
        foreach ($attributes as $key => $value) {
            if ($value === null || $value === false) {
                continue;
            }
            if ($value === true) {
                $html .= ' '.e($key);

                continue;
            }
            $html .= ' '.e($key).'="'.e((string) $value).'"';
        }

        return $html;
    }

    public static function ensureWebp(string $absolutePath, int $quality = 82): bool
    {
        if (! extension_loaded('gd') || ! is_file($absolutePath)) {
            return false;
        }

        $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $absolutePath);
        if (! $webpPath) {
            return false;
        }

        $image = self::loadImage($absolutePath);
        if ($image === null) {
            return false;
        }

        $ok = imagewebp($image, $webpPath, $quality);
        imagedestroy($image);

        return $ok && is_file($webpPath);
    }

    public static function resizeInPlace(string $absolutePath, int $maxWidth = 1920, int $jpegQuality = 82): bool
    {
        if (! extension_loaded('gd') || ! is_file($absolutePath)) {
            return false;
        }

        $image = self::loadImage($absolutePath);
        if ($image === null) {
            return false;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        if ($width <= $maxWidth) {
            imagedestroy($image);

            return true;
        }

        $ratio = $maxWidth / $width;
        $newW = $maxWidth;
        $newH = (int) round($height * $ratio);
        $resized = imagecreatetruecolor($newW, $newH);
        if ($resized === false) {
            imagedestroy($image);

            return false;
        }

        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newW, $newH, $width, $height);
        imagedestroy($image);

        $ext = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
        $ok = match ($ext) {
            'jpg', 'jpeg' => imagejpeg($resized, $absolutePath, $jpegQuality),
            'png' => imagepng($resized, $absolutePath, 6),
            default => false,
        };
        imagedestroy($resized);

        return $ok;
    }

    /** @return \GdImage|null */
    private static function loadImage(string $path): ?\GdImage
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($ext) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path) ?: null,
            'png' => @imagecreatefrompng($path) ?: null,
            'webp' => @imagecreatefromwebp($path) ?: null,
            default => null,
        };
    }

    /** @return list<string> */
    public static function scanAssetImages(string $directory = 'assets/img'): array
    {
        $root = public_path($directory);
        if (! is_dir($root)) {
            return [];
        }

        $files = [];
        foreach (File::allFiles($root) as $file) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}
