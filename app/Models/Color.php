<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name_en', 'name_sk'];

    /**
     * Swatch colours for the catalog filter, matching the product illustrations.
     */
    const HEX = [
        'red' => '#c8303a', 'green' => '#4f8a6b', 'blue' => '#4a78b8', 'yellow' => '#e8c547', 'purple' => '#8e7cc3',
        'pink' => '#e8a5b8', 'white' => '#f5f5f4', 'gray' => '#8a8d91', 'black' => '#2b2d31',
    ];

    public static function hex($name)
    {
        return self::HEX[$name] ?? '#9ca3af';
    }

    public function smartphones()
    {
        return $this->hasMany(\App\Models\Smartphone::class);
    }
}
