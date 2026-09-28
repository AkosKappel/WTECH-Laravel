<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as InterventionImage;

class Image extends Model
{
    use HasFactory;

    /**
     * Images uploaded in the admin zone, relative to public/. The folder is gitignored and
     * emptied by the nightly demo reset; the seed images stay in public/images (tracked).
     */
    const UPLOAD_DIR = 'uploads/products';

    protected $fillable = ['name', 'source', 'smartphone_id'];

    public function smartphone()
    {
        return $this->belongsTo(\App\Models\Smartphone::class);
    }

    /**
     * Save an uploaded image for a phone. It is re-encoded, so only the image data is kept.
     *
     * @param UploadedFile $file
     * @param Smartphone $smartphone
     * @return static
     */
    public static function storeUpload(UploadedFile $file, Smartphone $smartphone)
    {
        $directory = public_path(self::UPLOAD_DIR);
        File::ensureDirectoryExists($directory);

        $name = 'smartphone-' . $smartphone->id . '-' . Str::lower(Str::random(12)) . '.' . $file->extension();
        InterventionImage::make($file->getRealPath())->save($directory . '/' . $name);

        return static::create([
            'name' => $smartphone->name,
            'source' => '/' . self::UPLOAD_DIR . '/' . $name,
            'smartphone_id' => $smartphone->id,
        ]);
    }

    /**
     * Public URL of the image, e.g. https://…/wtech/images/samsung-galaxy-a52.jpg
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('wtech/' . ltrim($this->source, '/'));
    }

    public function isUpload()
    {
        return Str::startsWith(ltrim($this->source, '/'), self::UPLOAD_DIR . '/');
    }

    /**
     * Delete the file of an uploaded image. Seed images are part of the repository and are
     * never deleted, so a product removed in the demo gets its images back after the reset.
     */
    public function deleteFile()
    {
        if ($this->isUpload()) {
            File::delete(public_path(ltrim($this->source, '/')));
        }
    }
}
