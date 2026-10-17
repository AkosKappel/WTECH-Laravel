<?php

namespace App\Support;

use Illuminate\Contracts\Translation\Loader;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Loads the JSON translations as usual and lays the ones edited in the admin zone (the
 * translations table) over them. The overrides are cached until the next edit.
 */
class TranslationOverrideLoader implements Loader
{
    public function __construct(private Loader $files)
    {
    }

    public static function cacheKey($locale)
    {
        return "translation-overrides.$locale";
    }

    public function load($locale, $group, $namespace = null)
    {
        $lines = $this->files->load($locale, $group, $namespace);
        if ($group !== '*' || $namespace !== '*') {
            return $lines;
        }

        return array_merge($lines, $this->overrides($locale));
    }

    public function overrides($locale)
    {
        try {
            return Cache::rememberForever(self::cacheKey($locale), function () use ($locale) {
                return DB::table('translations')->where('locale', $locale)->pluck('value', 'key')->all();
            });
        } catch (Throwable $e) {
            // no database or no table yet (fresh install, migrations): the JSON files alone
            return [];
        }
    }

    public function addNamespace($namespace, $hint)
    {
        $this->files->addNamespace($namespace, $hint);
    }

    public function addJsonPath($path)
    {
        $this->files->addJsonPath($path);
    }

    public function namespaces()
    {
        return $this->files->namespaces();
    }
}
