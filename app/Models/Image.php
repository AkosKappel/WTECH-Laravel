<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class Image extends Model
{
    use HasFactory;

    /**
     * Images uploaded in the admin zone, relative to public/. The folder is gitignored and
     * emptied by the nightly demo reset; the seed images stay in public/images (tracked).
     */
    const UPLOAD_DIR = 'uploads/products';

    /** Uploads are scaled down to this size (longest side); thumbnails for cards and lists to THUMB_WIDTH. */
    const MAX_SIZE = 1600;
    const THUMB_WIDTH = 480;

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
        // re-encoding drops anything that isn't image data; quality 90 as with Intervention Image 2
        ImageManager::gd()->read($file->getRealPath())->scaleDown(self::MAX_SIZE, self::MAX_SIZE)
            ->save($directory . '/' . $name, quality: 90);

        $image = static::create([
            'name' => $smartphone->name,
            'source' => '/' . self::UPLOAD_DIR . '/' . $name,
            'smartphone_id' => $smartphone->id,
        ]);
        $image->createThumbnail();

        return $image;
    }

    /**
     * public/… path of the WebP thumbnail: images/foo.jpg → images/thumbs/foo.webp.
     */
    public function thumbnailPath()
    {
        $source = ltrim($this->source, '/');

        return dirname($source) . '/thumbs/' . pathinfo($source, PATHINFO_FILENAME) . '.webp';
    }

    /**
     * Write the thumbnail; illustrations (SVG) scale by themselves and get none.
     */
    public function createThumbnail()
    {
        $original = public_path(ltrim($this->source, '/'));
        if ($this->isIllustration() || !File::exists($original)) {
            return false;
        }

        $thumbnail = public_path($this->thumbnailPath());
        File::ensureDirectoryExists(dirname($thumbnail));
        ImageManager::gd()->read($original)->scaleDown(width: self::THUMB_WIDTH)->toWebp(80)->save($thumbnail);

        return true;
    }

    /**
     * public/… path of the small WebP version for cards and lists, or of the original when there is none.
     */
    public function thumbnailOrSource()
    {
        return File::exists(public_path($this->thumbnailPath())) ? $this->thumbnailPath() : ltrim($this->source, '/');
    }

    public function getThumbUrlAttribute()
    {
        return asset($this->thumbnailOrSource());
    }

    /**
     * Public URL of the image, e.g. https://…/images/samsung-galaxy-a52.jpg
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return asset(ltrim($this->source, '/'));
    }

    /**
     * Generated SVG illustrations (as opposed to photos): shown whole on a backdrop, and
     * skipped for link previews, which can't render SVG.
     */
    public function isIllustration()
    {
        return Str::endsWith($this->source, '.svg');
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
            File::delete([public_path(ltrim($this->source, '/')), public_path($this->thumbnailPath())]);
        }
    }
}
