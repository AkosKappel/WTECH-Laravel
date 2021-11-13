<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smartphone extends Model
{
    use HasFactory;

    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\Image::class);
    }
}
