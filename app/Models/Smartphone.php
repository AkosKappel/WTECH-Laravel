<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Smartphone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'sale_price', 'sale_starts_at', 'sale_ends_at', 'quantity', 'brand_id', 'color_id', 'description', 'description_translations', 'ram',
        'operating_system', 'os_version', 'display_size', 'resolution', 'height', 'width', 'thickness'];

    /**
     * Products made by demo admins stay out of the shop: only admins and demo admins see them.
     */
    protected static function booted()
    {
        static::addGlobalScope('hideDemoProducts', function ($query) {
            $user = auth()->user();
            if (!$user || !($user->isAdmin() || $user->isDemoAdmin())) {
                $query->whereNull('smartphones.demo_owner_id');
            }
        });
    }

    public function isDemoProduct()
    {
        return $this->demo_owner_id !== null;
    }

    protected $casts = [
        'description_translations' => 'array',
        'sale_starts_at' => 'datetime',
        'sale_ends_at' => 'datetime',
    ];

    /**
     * Whether the sale price applies right now.
     */
    public function isOnSale()
    {
        return $this->sale_price !== null && $this->sale_price < $this->price
            && ($this->sale_starts_at === null || $this->sale_starts_at->isPast())
            && ($this->sale_ends_at === null || $this->sale_ends_at->isFuture());
    }

    /**
     * The price a customer pays now: the sale price during a sale, the regular price otherwise.
     */
    public function getCurrentPriceAttribute()
    {
        return $this->isOnSale() ? (float) $this->sale_price : (float) $this->price;
    }

    /** Whole-number discount in percent, e.g. 20 for "−20 %". */
    public function getDiscountPercentAttribute()
    {
        return $this->isOnSale() ? (int) round((1 - $this->sale_price / $this->price) * 100) : 0;
    }

    /**
     * SQL for the current price, the same rule as isOnSale(), for filtering and sorting.
     */
    public static function currentPriceSql()
    {
        return '(case when ' . self::onSaleSql() . ' then smartphones.sale_price else smartphones.price end)';
    }

    public static function onSaleSql()
    {
        return '(smartphones.sale_price is not null and smartphones.sale_price < smartphones.price'
            . ' and (smartphones.sale_starts_at is null or smartphones.sale_starts_at <= now())'
            . ' and (smartphones.sale_ends_at is null or smartphones.sale_ends_at > now()))';
    }

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
