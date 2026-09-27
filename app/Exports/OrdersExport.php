<?php

namespace App\Exports;

use App\Models\Order;
use App\Support\OrderStatus;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Order::query()
            ->withCount('items')
            ->latest()
            ->get()
            ->map(fn (Order $o) => [
                $o->reference,
                $o->created_at?->format('d/m/Y H:i'),
                $o->customer_name,
                $o->customer_email,
                $o->customer_phone,
                OrderStatus::label($o->status),
                $o->items_count,
                $o->total_fcfa,
                $o->payment_method,
                $o->shipping_city,
            ]);
    }

    public function headings(): array
    {
        return [
            'Référence',
            'Date',
            'Client',
            'E-mail',
            'Téléphone',
            'Statut',
            'Articles',
            'Total FCFA',
            'Paiement',
            'Ville',
        ];
    }
}
