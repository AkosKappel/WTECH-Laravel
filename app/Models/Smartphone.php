<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smartphone extends Model
{
    use HasFactory;

    public function scopeMaxPrice($query, $price)
    {
        if (!is_null($price)) {
            return $query->where('price', '<', $price);
        }
        return $query;
    }

    public function scopeMinPrice($query, $price)
    {
        if (!is_null($price)) {
            return $query->where('price', '>', $price);
        }
        return $query;
    }

    public function scopeOfBrand($query, $brandNames)
    {
        $brands = Brand::all()->whereIn('name', $brandNames);

        $brandArray = [];
        foreach ($brands as $key => $value) {
            array_push($brandArray, $value->id);
        }
        return $query->whereIn('brand_id', $brandArray);
    }

    public function scopeOfColor($query, $color)
    {
        if (!is_null($color)) {
            return $query->where('color', '=', $color);
        }
        return $query;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
