<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public function smartphone()
    {
        return $this->belongsTo(\App\Models\Smartphone::class);
    }
}