<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Product::query()
            ->with('category')
            ->orderBy('name')
            ->get()
            ->map(fn (Product $p) => [
                $p->id,
                $p->name,
                $p->slug,
                $p->category?->name,
                $p->price_fcfa,
                $p->price_eur,
                $p->price_usd,
                $p->stock,
                $p->is_active ? 'Oui' : 'Non',
                $p->getRawOriginal('image_url'),
            ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Slug',
            'Catégorie',
            'Prix FCFA',
            'Prix EUR',
            'Prix USD',
            'Stock',
            'Actif',
            'Image',
        ];
    }
}
