<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'access_token',
        'status',
        'subtotal_fcfa',
        'shipping_fcfa',
        'total_fcfa',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_city',
        'shipping_address',
        'payment_method',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethodLabel(): string
    {
        $key = $this->payment_method ?? '';

        return (string) (config('kiel.payment_methods.'.$key)
            ?? ucfirst(str_replace('_', ' ', $key)));
    }

    public function canBeViewedBy(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        if ($this->user_id !== null && (int) $this->user_id === (int) $user->id) {
            return true;
        }

        return strcasecmp((string) $this->customer_email, (string) $user->email) === 0;
    }

    public function attachToUserIfEligible(User $user): void
    {
        if ($this->user_id !== null) {
            return;
        }

        if (strcasecmp((string) $this->customer_email, (string) $user->email) !== 0) {
            return;
        }

        $this->forceFill(['user_id' => $user->id])->save();
    }
}
