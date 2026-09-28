<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function smartphones()
    {
        return $this->hasMany(\App\Models\Smartphone::class);
    }

    /**
     * URL of the brand's logo in public/images/brands/{slug}.svg, or null when
     * there is none, so views can fall back to the first letter.
     *
     * @return string|null
     */
    public function getLogoUrlAttribute()
    {
        $file = 'images/brands/' . \Illuminate\Support\Str::slug($this->name) . '.svg';

        return file_exists(public_path($file)) ? url('wtech/' . $file) : null;
    }
}
