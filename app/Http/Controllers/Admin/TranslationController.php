<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\TranslationKeys;
use App\Support\TranslationOverrideLoader;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

/**
 * Translation manager: every UI string with its German and Slovak text. Edits are stored as
 * overrides in the translations table (resources/lang/*.json stays the base) and can be
 * exported as JSON to commit them.
 */
class TranslationController extends Controller
{
    const FILTERS = ['all', 'missing', 'same', 'changed', 'warnings'];

    private function locales()
    {
        return array_values(array_diff(array_keys(config('app.locales')), [config('app.fallback_locale')]));
    }

    private function fileLines($locale)
    {
        $file = resource_path("lang/$locale.json");

        return File::exists($file) ? json_decode(File::get($file), true) : [];
    }

    /**
     * One row per string: the English key, where it's used, and per language the file text,
     * the override and what is shown.
     */
    private function rows()
    {
        $locales = $this->locales();
        $files = collect($locales)->mapWithKeys(fn ($locale) => [$locale => $this->fileLines($locale)]);
        $overrides = collect($locales)->mapWithKeys(fn ($locale) => [$locale => DB::table('translations')->where('locale', $locale)->pluck('value', 'key')->all()]);

        return collect(TranslationKeys::used())->map(function ($locations, $key) use ($locales, $files, $overrides) {
            $values = [];
            foreach ($locales as $locale) {
                $file = $files[$locale][$key] ?? null;
                $override = $overrides[$locale][$key] ?? null;
                $value = $override ?? $file;
                $values[$locale] = [
                    'file' => $file,
                    'override' => $override,
                    'value' => $value,
                    'warnings' => $value === null || $value === '' ? [] : self::warnings($key, $value),
                ];
            }

            return ['key' => $key, 'locations' => $locations, 'values' => $values];
        })->values();
    }

    /**
     * Placeholders (:count, :name) and plural forms that don't match the English text.
     */
    public static function warnings($key, $value)
    {
        $warnings = [];
        preg_match_all('/:([a-z_]+)/i', $key, $placeholders);
        foreach (array_unique($placeholders[1]) as $placeholder) {
            if (!str_contains($value, ':' . $placeholder)) {
                $warnings[] = __('Missing placeholder :placeholder', ['placeholder' => ':' . $placeholder]);
            }
        }
        if (str_contains($key, '|') !== str_contains($value, '|')) {
            $warnings[] = str_contains($key, '|') ? __('The English text has plural forms (|), this one has none') : __('Plural forms (|) where the English text has none');
        }

        return $warnings;
    }

    public function index(Request $request)
    {
        $filter = in_array($request->query('filter'), self::FILTERS, true) ? $request->query('filter') : 'all';
        $search = trim((string) $request->query('q', ''));
        $rows = $this->rows();

        $progress = collect($this->locales())->mapWithKeys(fn ($locale) => [
            $locale => $rows->filter(fn ($row) => filled($row['values'][$locale]['value']))->count(),
        ]);

        $filtered = $rows->filter(function ($row) use ($filter, $search) {
            $values = collect($row['values']);
            if ($search !== '' && !str_contains(mb_strtolower($row['key'] . ' ' . $values->pluck('value')->implode(' ')), mb_strtolower($search))) {
                return false;
            }

            return match ($filter) {
                'missing' => $values->contains(fn ($v) => blank($v['value'])),
                'same' => $values->contains(fn ($v) => $v['value'] === $row['key']),
                'changed' => $values->contains(fn ($v) => $v['override'] !== null),
                'warnings' => $values->contains(fn ($v) => $v['warnings'] !== []),
                default => true,
            };
        })->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginator = new LengthAwarePaginator($filtered->forPage($page, 40), $filtered->count(), 40, $page, [
            'path' => route('admin.translations'),
            'query' => array_filter(['q' => $search, 'filter' => $filter === 'all' ? null : $filter]),
        ]);

        return view('layout.admin.translations', [
            'rows' => $paginator,
            'locales' => $this->locales(),
            'total' => $rows->count(),
            'progress' => $progress,
            'filter' => $filter,
            'search' => $search,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'values' => 'array',
            'values.*' => 'nullable|string|max:5000',
        ]);

        foreach ($this->locales() as $locale) {
            $value = $data['values'][$locale] ?? null;
            $file = $this->fileLines($locale)[$data['key']] ?? null;
            if (blank($value) || $value === $file) {
                DB::table('translations')->where(['locale' => $locale, 'key' => $data['key']])->delete();
            } else {
                DB::table('translations')->updateOrInsert(
                    ['locale' => $locale, 'key' => $data['key']],
                    ['value' => $value, 'updated_by' => $request->user()->id, 'updated_at' => now(), 'created_at' => now()],
                );
            }
            Cache::forget(TranslationOverrideLoader::cacheKey($locale));
        }

        return back()->with('success_message', __('Translation saved.'));
    }

    /**
     * The JSON file with the edits applied, to replace resources/lang/{locale}.json and commit.
     */
    public function export($locale)
    {
        abort_unless(in_array($locale, $this->locales(), true), 404);

        $lines = array_merge($this->fileLines($locale), DB::table('translations')->where('locale', $locale)->pluck('value', 'key')->all());
        ksort($lines);

        return response(json_encode($lines, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', "attachment; filename=\"$locale.json\"");
    }

    /**
     * Take the texts of an uploaded {locale}.json as edits, where they differ from the file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'locale' => ['required', Rule::in($this->locales())],
            'file' => 'required|file|mimetypes:application/json,text/plain|max:1024',
        ]);
        $lines = json_decode($request->file('file')->get(), true);
        if (!is_array($lines)) {
            return back()->withErrors(['file' => __('The file is not a valid JSON object.')]);
        }

        $known = TranslationKeys::used();
        $file = $this->fileLines($request->locale);
        $count = 0;
        foreach ($lines as $key => $value) {
            if (!array_key_exists($key, $known) || !is_string($value) || $value === '' || $value === ($file[$key] ?? null)) {
                continue;
            }
            DB::table('translations')->updateOrInsert(
                ['locale' => $request->locale, 'key' => $key],
                ['value' => $value, 'updated_by' => $request->user()->id, 'updated_at' => now(), 'created_at' => now()],
            );
            $count++;
        }
        Cache::forget(TranslationOverrideLoader::cacheKey($request->locale));

        return back()->with('success_message', trans_choice(':count text imported.|:count texts imported.', $count, ['count' => $count]));
    }
}
