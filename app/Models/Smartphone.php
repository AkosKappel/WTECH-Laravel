<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smartphone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity', 'brand_id', 'color_id', 'description', 'description_translations', 'ram',
        'operating_system', 'os_version', 'display_size', 'resolution', 'height', 'width', 'thickness'];

    protected $casts = [
        'description_translations' => 'array',
    ];

    /**
     * Description in the current language, falling back to the English original.
     *
     * @return string|null
     */
    public function getLocalizedDescriptionAttribute()
    {
        $translations = $this->description_translations ?? [];

        return $translations[app()->getLocale()] ?? $this->description;
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
