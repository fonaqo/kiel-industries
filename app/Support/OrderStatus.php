<?php

namespace App\Support;

class OrderStatus
{
    /** @return array<string, string> */
    public static function labels(): array
    {
        return config('kiel.order_statuses', []);
    }

    /** @return list<string> */
    public static function keys(): array
    {
        return array_keys(self::labels());
    }

    public static function label(?string $status): string
    {
        if ($status === null || $status === '') {
            return 'Inconnu';
        }

        $normalized = self::normalize($status);

        return (string) (self::labels()[$normalized]
            ?? self::labels()[$status]
            ?? ucfirst(str_replace('_', ' ', $status)));
    }

    public static function normalize(string $status): string
    {
        return match ($status) {
            'paid', 'pending', 'confirmed' => 'processing',
            'shipped' => 'shipping',
            default => $status,
        };
    }
}
