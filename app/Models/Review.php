<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['smartphone_id', 'user_id', 'rating', 'body'];

    public function smartphone()
    {
        return $this->belongsTo(Smartphone::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Whether the reviewer ordered this phone, shown as "Verified purchase".
     */
    public function isVerifiedPurchase()
    {
        return Order::where('user_id', $this->user_id)
            ->whereHas('smartphones', fn ($query) => $query->whereKey($this->smartphone_id))
            ->exists();
    }
}
