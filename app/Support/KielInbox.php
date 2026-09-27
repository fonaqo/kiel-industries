<?php

namespace App\Support;

use App\Services\CmsBlocks;
use App\Services\CmsSettings;

class KielInbox
{
    public static function contactEmail(): string
    {
        try {
            $fromBlocks = trim((string) (app(CmsBlocks::class)->group('contact')['email'] ?? ''));
            if ($fromBlocks !== '' && filter_var($fromBlocks, FILTER_VALIDATE_EMAIL)) {
                return $fromBlocks;
            }
        } catch (\Throwable) {
            // CMS indisponible.
        }

        try {
            $seo = array_replace_recursive(config('kiel.seo', []), app(CmsSettings::class)->get('seo') ?? []);
            $fromSeo = trim((string) ($seo['organization']['email'] ?? ''));
            if ($fromSeo !== '' && filter_var($fromSeo, FILTER_VALIDATE_EMAIL)) {
                return $fromSeo;
            }
        } catch (\Throwable) {
            // Paramètres CMS indisponibles.
        }

        $fallback = trim((string) config('kiel.seo.organization.email', ''));

        return filter_var($fallback, FILTER_VALIDATE_EMAIL)
            ? $fallback
            : 'kielbienetre@gmail.com';
    }
}
