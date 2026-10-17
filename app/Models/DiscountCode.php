<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A code entered in the cart: a percentage or a fixed amount off the order, with an optional
 * minimum order value, expiry date and usage limits (in total and per customer).
 */
class DiscountCode extends Model
{
    use HasFactory;

    const TYPES = ['percent', 'fixed'];

    protected $fillable = ['code', 'type', 'value', 'min_order', 'expires_at', 'usage_limit', 'per_customer_limit', 'active'];

    protected $casts = [
        'expires_at' => 'datetime',
        'active' => 'boolean',
        'value' => 'float',
        'min_order' => 'float',
    ];

    /** Codes are stored and compared in upper case. */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = mb_strtoupper(trim($value));
    }

    public static function findByCode(?string $code): ?self
    {
        return $code ? static::firstWhere('code', mb_strtoupper(trim($code))) : null;
    }

    /**
     * Why the code can't be used for this order, or null when it can.
     */
    public function problem(float $subtotal, ?User $user = null): ?string
    {
        if (!$this->active || ($this->expires_at && $this->expires_at->isPast())) {
            return __('This code has expired.');
        }
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return __('This code has been used up.');
        }
        if ($user && $this->per_customer_limit !== null
            && Order::where('user_id', $user->id)->where('discount_code', $this->code)->count() >= $this->per_customer_limit) {
            return __('You have already used this code.');
        }
        if ($subtotal < $this->min_order) {
            return __('This code needs an order of at least :amount.', ['amount' => formattedPrice($this->min_order)]);
        }

        return null;
    }

    /**
     * The amount taken off, never more than the order itself.
     */
    public function discountFor(float $subtotal): float
    {
        $amount = $this->type === 'percent' ? $subtotal * $this->value / 100 : $this->value;

        return round(min($amount, $subtotal), 2);
    }

    /** Short description, e.g. "10 %" or "€20.00". */
    public function getLabelAttribute()
    {
        return $this->type === 'percent' ? localizedNumber($this->value) . ' %' : formattedPrice($this->value);
    }
}
