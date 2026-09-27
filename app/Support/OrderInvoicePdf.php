<?php

namespace App\Support;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderInvoicePdf
{
    public static function generate(Order $order): string
    {
        $order->loadMissing('items');

        return Pdf::loadView('emails.invoices.order', [
            'order' => $order,
        ])
            ->setOption('chroot', public_path())
            ->output();
    }
}
