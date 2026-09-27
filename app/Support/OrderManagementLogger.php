<?php

namespace App\Support;

use App\Models\Order;
use App\Models\OrderManagementLog;
use App\Models\User;

class OrderManagementLogger
{
    public static function orderViewed(Order $order, User $user): void
    {
        self::write(
            user: $user,
            order: $order,
            action: 'order.viewed',
            summary: sprintf('%s a consulté la commande %s.', $user->display_name, $order->reference),
            properties: [
                'order_reference' => $order->reference,
            ],
        );
    }

    public static function statusChanged(Order $order, User $user, string $from, string $to): void
    {
        $fromLabel = OrderStatus::label($from);
        $toLabel = OrderStatus::label($to);

        self::write(
            user: $user,
            order: $order,
            action: 'order.status_changed',
            summary: sprintf(
                '%s a changé le statut de %s : %s vers %s.',
                $user->display_name,
                $order->reference,
                $fromLabel,
                $toLabel
            ),
            properties: [
                'order_reference' => $order->reference,
                'from' => $from,
                'to' => $to,
                'from_label' => $fromLabel,
                'to_label' => $toLabel,
            ],
        );
    }

    /** @param  array<string, mixed>  $properties */
    private static function write(User $user, ?Order $order, string $action, string $summary, array $properties = []): void
    {
        OrderManagementLog::query()->create([
            'user_id' => $user->id,
            'order_id' => $order?->id,
            'action' => $action,
            'summary' => $summary,
            'properties' => $properties,
        ]);
    }
}
