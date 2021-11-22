<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'paid',
        'delivery_method',
        'payment_method',
        'user_id'
    ];

    public function smartphones()
    {
        return $this->belongsToMany(Smartphone::class)
            ->withPivot('count')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
