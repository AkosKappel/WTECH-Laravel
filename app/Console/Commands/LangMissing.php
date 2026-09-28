<?php

namespace App\Console\Commands;

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
     * Strings that reach __() through variables, so they can't be found by scanning.
     */
    const DYNAMIC = [
        'red', 'green', 'blue', 'yellow', 'purple', 'pink', 'white', 'gray', 'black',
        'Cheapest', 'Most Expensive',
        'Courier Delivery', 'Personal Pickup', 'Post Office Delivery', 'Parcel Locker',
        'Cash on Delivery', 'Bank Transfer', 'Credit Card', 'Apple Pay', 'Google Pay',
        'Free Shipping', 'Enjoy free delivery on all orders', 'Best Price Guarantee',
        "We match any competitor's price", '2-Year Premium Warranty', 'Extended protection for your device',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $keys = array_unique(array_merge($this->usedKeys(), self::DYNAMIC));
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

    /**
     * Keys passed to the translation helper as literal strings. Keys of PHP
     * translation files (e.g. auth.failed) are skipped.
     *
     * @return array
     */
    private function usedKeys()
    {
        $keys = [];
        foreach ([resource_path('views'), app_path(), base_path('routes')] as $directory) {
            foreach (File::allFiles($directory) as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }
                preg_match_all('/__\(\s*(?:\'((?:[^\'\\\\]|\\\\.)*)\'|"((?:[^"\\\\$]|\\\\.)*)")/', $file->getContents(), $matches, PREG_SET_ORDER);
                foreach ($matches as $match) {
                    $key = isset($match[2]) && $match[2] !== '' ? stripslashes($match[2]) : str_replace("\\'", "'", $match[1]);
                    if ($key !== '' && !preg_match('/^[a-z_]+\.[a-z_.]+$/', $key)) {
                        $keys[] = $key;
                    }
                }
            }
        }

        return array_unique($keys);
    }
}
