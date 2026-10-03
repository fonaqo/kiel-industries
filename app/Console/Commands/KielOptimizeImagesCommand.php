<?php

namespace App\Console\Commands;

use App\Support\KielImage;
use Illuminate\Console\Command;

class KielOptimizeImagesCommand extends Command
{
    protected $signature = 'kiel:optimize-images
                            {--max-width=1920 : Largeur max des JPEG/PNG}
                            {--webp-quality=82 : Qualité WebP}
                            {--min-kb=180 : Ignorer les fichiers plus petits que ce seuil}';

    protected $description = 'Redimensionne les grosses images et génère des variantes WebP dans public/assets/img';

    public function handle(): int
    {
        if (! extension_loaded('gd')) {
            $this->error('Extension PHP GD requise.');

            return self::FAILURE;
        }

        if (! function_exists('imagewebp')) {
            $this->error('WebP non supporté par GD sur ce serveur.');

            return self::FAILURE;
        }

        $maxWidth = (int) $this->option('max-width');
        $webpQuality = (int) $this->option('webp-quality');
        $minBytes = max(0, (int) $this->option('min-kb')) * 1024;

        $files = KielImage::scanAssetImages();
        $resized = 0;
        $webpCreated = 0;
        $skipped = 0;

        foreach ($files as $path) {
            $size = filesize($path) ?: 0;
            if ($size < $minBytes) {
                $skipped++;

                continue;
            }

            if (KielImage::resizeInPlace($path, $maxWidth)) {
                $resized++;
            }

            $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);
            if ($webpPath && (! is_file($webpPath) || filemtime($webpPath) < filemtime($path))) {
                if (KielImage::ensureWebp($path, $webpQuality)) {
                    $webpCreated++;
                }
            }
        }

        $this->info("Images scannées : ".count($files));
        $this->info("Redimensionnées (≥ {$minBytes} o) : {$resized}");
        $this->info("WebP générés : {$webpCreated}");
        $this->info("Ignorées (< seuil) : {$skipped}");

        return self::SUCCESS;
    }
}
