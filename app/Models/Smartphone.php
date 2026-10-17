<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Smartphone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity', 'brand_id', 'color_id', 'description', 'description_translations', 'ram',
        'operating_system', 'os_version', 'display_size', 'resolution', 'height', 'width', 'thickness'];

    protected $casts = [
        'description_translations' => 'array',
    ];

    /**
     * Readable URL key, "<id>-<slug of the name>"; the ID alone decides which phone it is.
     */
    public function getRouteKey()
    {
        return $this->id . '-' . Str::slug($this->name);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->whereKey((int) $value)->first();
    }

    /**
     * Name without memory and storage, so variants of one model can be told apart from
     * different models: "Samsung Galaxy S24 8GB/256GB" and "… 8GB/512GB" are both "Samsung Galaxy S24".
     */
    public function getModelNameAttribute()
    {
        return trim(preg_replace('#\s+(\d+\s*(GB|TB)?/\d+\s*(GB|TB)?|\d+\s*(GB|TB))\b.*$#i', '', $this->name));
    }

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

    /**
     * Phones worth showing off: in stock, with an image and a description, ranked by
     * units sold in the last 90 days. Unsold phones follow, flagships (highest price)
     * first, so the list stays full and attractive right after the nightly reset.
     */
    public function scopeBestSelling($query)
    {
        return $query
            ->with('images')
            ->where('quantity', '>', 0)
            ->whereNotNull('description')
            ->whereHas('images')
            ->withSum(['orders as units_sold' => fn ($orders) => $orders->where('orders.created_at', '>=', now()->subDays(90))],
                'order_smartphone.count')
            ->orderByRaw('units_sold desc nulls last')
            ->orderByDesc('price')
            ->orderByDesc('id');
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
