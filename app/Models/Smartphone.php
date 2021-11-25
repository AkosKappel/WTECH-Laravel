<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smartphone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity', 'brand_id', 'color_id', 'description', 'ram',
        'operating_system', 'os_version', 'display_size', 'resolution', 'height', 'width', 'thickness'];

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
        $brand_ids = Brand::all()->whereIn('name', $brandNames)->pluck('id');
        return $query->whereIn('brand_id', $brand_ids);
    }

    public function scopeOfColor($query, $colorNames)
    {
        $color_ids = Color::all()->whereIn('name_en', $colorNames)->pluck('id');
        return $query->whereIn('color_id', $color_ids);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
