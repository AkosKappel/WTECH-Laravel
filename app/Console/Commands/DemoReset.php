<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DemoReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset {--force : Run without asking, also in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the demo shop: reseed the database and remove uploads, sessions and caches';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->option('force') && !$this->confirm('This deletes all accounts, orders, products and uploads. Continue?')) {
            return 1;
        }

        $this->callSilent('down', ['--retry' => 15]);

        try {
            $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);

            $removed = $this->removeUploadedImages();
            $this->info("Removed {$removed} uploaded image(s).");

            // user IDs start over after the reseed, so old sessions must not survive:
            // a stale login for user #5 would otherwise belong to the next user #5
            // File::files() skips dotfiles, so the directory's .gitignore stays
            File::delete(File::files(storage_path('framework/sessions')));
            $this->call('cache:clear');
        } finally {
            $this->callSilent('up');
        }

        Log::info('Demo shop was reset');
        $this->info('Demo shop was reset.');

        return 0;
    }

    /**
     * Delete product images uploaded through the admin zone. They are named
     * smartphone-{id}-{n}.{ext}; seeded images that happen to match that pattern
     * are still referenced in the freshly seeded database and are kept.
     *
     * @return int
     */
    private function removeUploadedImages()
    {
        $seeded = Image::pluck('source')->map(function ($source) {
            return basename($source);
        })->all();

        $removed = 0;
        foreach (File::files(public_path('images')) as $file) {
            $name = $file->getFilename();
            if (preg_match('/^smartphone-\d+-\d+\.(jpe?g|png|webp)$/i', $name) && !in_array($name, $seeded)) {
                File::delete($file->getPathname());
                $removed++;
            }
        }

        return $removed;
    }
}
