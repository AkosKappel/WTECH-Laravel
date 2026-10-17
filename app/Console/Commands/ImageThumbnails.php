<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * WebP thumbnails for product photos that have none yet, e.g. the seed images after adding new
 * ones (their thumbnails are committed next to them, in public/images/thumbs).
 */
class ImageThumbnails extends Command
{
    protected $signature = 'images:thumbnails {--force : also replace existing thumbnails}';

    protected $description = 'Create WebP thumbnails for product photos';

    public function handle()
    {
        $created = 0;
        foreach (Image::all() as $image) {
            if (!$this->option('force') && File::exists(public_path($image->thumbnailPath()))) {
                continue;
            }
            $created += $image->createThumbnail() ? 1 : 0;
        }
        $this->info("Created {$created} thumbnail(s).");

        return 0;
    }
}
