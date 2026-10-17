<?php

namespace App\Console\Commands;

use App\Support\TranslationKeys;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LangMissing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List __() strings used in views and app code that are missing from resources/lang/{locale}.json';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $keys = array_keys(TranslationKeys::used());
        $missingTotal = 0;

        foreach (array_keys(config('app.locales')) as $locale) {
            if ($locale === config('app.fallback_locale')) {
                continue; // the keys themselves are English
            }

            $file = resource_path("lang/$locale.json");
            $translations = File::exists($file) ? json_decode(File::get($file), true) : [];
            $missing = array_values(array_filter($keys, function ($key) use ($translations) {
                return !array_key_exists($key, $translations);
            }));
            sort($missing);

            $missingTotal += count($missing);
            $this->line(sprintf('<info>%s</info>: %d of %d strings translated', $locale, count($keys) - count($missing), count($keys)));
            foreach ($missing as $key) {
                $this->line("  - $key");
            }
        }

        return $missingTotal > 0 ? 1 : 0;
    }
}
