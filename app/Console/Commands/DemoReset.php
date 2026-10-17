<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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

        // planned maintenance that is already on stays on: the reset must not lift it
        $wasDown = app()->maintenanceMode()->active();
        if (!$wasDown) {
            $this->callSilent('down', ['--retry' => 15]);
        }

        try {
            // visitor statistics survive the reset (the last 90 days)
            $backup = $this->exportPageViews();
            $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
            $this->importPageViews($backup);

            $removed = $this->removeUploadedImages();
            $this->info("Removed {$removed} uploaded image(s).");

            // user IDs start over after the reseed, so old sessions must not survive:
            // a stale login for user #5 would otherwise belong to the next user #5
            // File::files() skips dotfiles, so the directory's .gitignore stays
            File::delete(File::files(storage_path('framework/sessions')));
            $this->call('cache:clear');
        } finally {
            if (!$wasDown) {
                $this->callSilent('up');
            }
        }

        Log::info('Demo shop was reset');
        $this->info('Demo shop was reset.');

        return 0;
    }

    /**
     * Delete product images uploaded through the admin zone (public/uploads/products).
     * Also removes uploads from before they had their own folder: files named
     * smartphone-{id}-{n}.{ext} in public/images that no seeded product uses.
     *
     * @return int
     */
    /**
     * Write the page views of the last 90 days to a JSON-lines file; null when there are none.
     */
    private function exportPageViews()
    {
        if (!Schema::hasTable('page_views')) {
            return null;
        }

        $file = storage_path('app/page-views-backup.jsonl');
        $handle = fopen($file, 'w');
        DB::table('page_views')->where('created_at', '>=', now()->subDays(90))->orderBy('id')
            ->lazyById(1000)->each(fn ($row) => fwrite($handle, json_encode((array) $row) . "\n"));
        fclose($handle);

        return $file;
    }

    private function importPageViews(?string $file)
    {
        if ($file === null) {
            return;
        }

        $chunk = [];
        foreach (new \SplFileObject($file) as $line) {
            if (trim($line) === '') {
                continue;
            }
            $chunk[] = json_decode($line, true);
            if (count($chunk) === 1000) {
                DB::table('page_views')->insert($chunk);
                $chunk = [];
            }
        }
        if ($chunk) {
            DB::table('page_views')->insert($chunk);
        }
        // the ids carried over; the sequence has to continue after them
        DB::statement("select setval(pg_get_serial_sequence('page_views', 'id'), coalesce((select max(id) from page_views), 1))");
        File::delete($file);
    }

    private function removeUploadedImages()
    {
        $removed = 0;
        $uploads = public_path(Image::UPLOAD_DIR);
        if (File::isDirectory($uploads)) {
            $removed += count(File::allFiles($uploads));
            File::cleanDirectory($uploads);
        }

        $seeded = Image::pluck('source')->map(function ($source) {
            return basename($source);
        })->all();
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
