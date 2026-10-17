<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'status',
        'delivery_method',
        'payment_method',
        'user_id'
    ];

    /** Statuses in the order they happen; "cancelled" can follow any of the others. */
    const STATUSES = ['new', 'paid', 'shipped', 'delivered', 'cancelled'];

    /** Badge colours (Tailwind classes) per status. */
    const STATUS_STYLES = [
        'new' => 'bg-blue-50 text-blue-700',
        'paid' => 'bg-indigo-50 text-indigo-700',
        'shipped' => 'bg-yellow-100 text-yellow-800',
        'delivered' => 'bg-green-50 text-green-700',
        'cancelled' => 'bg-gray-100 text-gray-600',
    ];

    protected $attributes = [
        'status' => 'new',
    ];

    /**
     * Translated status, e.g. "Shipped".
     */
    public static function statusLabel($status)
    {
        return __(ucfirst($status));
    }

    public function smartphones()
    {
        return $this->belongsToMany(Smartphone::class)
            ->withPivot('count', 'price')->withTimestamps();
    }

    /**
     * Order number shown to customers, e.g. ST-000042.
     *
     * @return string
     */
    public function getNumberAttribute()
    {
        return 'ST-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
