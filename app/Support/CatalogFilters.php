<?php

namespace App\Support;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Smartphone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Catalog search, filters and sorting, read from clean query parameters such as
 * ?q=pixel&brand=apple,google&color=green&price=100-500&sort=price-asc.
 *
 * Parameters (always in this order, defaults left out):
 *   q        search text, typo-tolerant
 *   brand    brand slugs, comma-separated
 *   color    colour names, comma-separated
 *   price    "min-max", either side optional ("100-", "-500")
 *   ram      4 (≤ 4 GB), 6, 8, 12 (≥ 12 GB)
 *   display  compact (< 6.2"), standard, large (> 6.6")
 *   os       android, ios, other
 *   stock    "in" = in stock only
 *   sort     relevance (default when searching), newest (default), price-asc, price-desc, name
 *   page     > 1
 */
class CatalogFilters
{
    const RAM = ['4', '6', '8', '12'];
    const DISPLAY = ['compact', 'standard', 'large'];
    const OS = ['android', 'ios', 'other'];
    const SORTS = ['relevance', 'newest', 'price-asc', 'price-desc', 'name'];

    /** Minimum trigram word similarity for a fuzzy match; "pixl" → "Pixel" scores ~0.5, unrelated phones ~0.2. */
    const FUZZY_THRESHOLD = 0.4;

    public $q = '';
    public $brands = [];
    public $colors = [];
    public $priceMin = null;
    public $priceMax = null;
    public $ram = [];
    public $display = [];
    public $os = [];
    public $inStock = false;
    public $sort = null;
    public $page = 1;

    /** Whether the request used the old parameter format (?Apple=Apple&min-price=…). */
    public $legacy = false;

    private $brandIds;   // slug => id
    private $brandNames; // slug => name
    private $colorIds;   // name_en => id

    public function __construct()
    {
        $brands = Brand::orderBy('name')->get(['id', 'name']);
        $this->brandIds = $brands->mapWithKeys(function ($brand) {
            return [Str::slug($brand->name) => $brand->id];
        })->all();
        $this->brandNames = $brands->mapWithKeys(function ($brand) {
            return [Str::slug($brand->name) => $brand->name];
        })->all();
        $this->colorIds = Color::orderBy('id')->pluck('id', 'name_en')->all();
    }

    /**
     * Read filters from the request: the clean format, the plain form submit
     * (brand[]=apple, price_min=…), and the old format, for redirects.
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request)
    {
        $filters = new static();
        $input = $request->query();

        $filters->q = trim(Str::limit((string) ($input['q'] ?? ''), 100, ''));
        $filters->brands = $filters->pick($filters->values($input['brand'] ?? []), array_keys($filters->brandIds));
        $filters->colors = $filters->pick($filters->values($input['color'] ?? []), array_keys($filters->colorIds));
        $filters->ram = $filters->pick($filters->values($input['ram'] ?? []), self::RAM);
        $filters->display = $filters->pick($filters->values($input['display'] ?? []), self::DISPLAY);
        $filters->os = $filters->pick($filters->values($input['os'] ?? []), self::OS);
        $filters->inStock = ($input['stock'] ?? '') === 'in';
        $filters->sort = in_array($input['sort'] ?? null, self::SORTS, true) ? $input['sort'] : null;
        $filters->page = max(1, (int) ($input['page'] ?? 1));

        if (isset($input['price']) && preg_match('/^\s*(\d*(?:\.\d+)?)\s*-\s*(\d*(?:\.\d+)?)\s*$/', $input['price'], $m)) {
            [$filters->priceMin, $filters->priceMax] = [$m[1] !== '' ? (float) $m[1] : null, $m[2] !== '' ? (float) $m[2] : null];
        }
        // separate fields from the filter form without JavaScript
        foreach (['price_min' => 'priceMin', 'price_max' => 'priceMax'] as $field => $property) {
            if (isset($input[$field]) && is_numeric($input[$field])) {
                $filters->$property = (float) $input[$field];
            }
        }

        $filters->readLegacy($input);
        $filters->normalise();

        return $filters;
    }

    /**
     * Old URLs: ?search=…&min-price=…&max-price=…&Apple=Apple&green=green&sort=asc
     */
    private function readLegacy(array $input)
    {
        if (isset($input['search'])) {
            $this->q = $this->q !== '' ? $this->q : trim((string) $input['search']);
            $this->legacy = true;
        }
        foreach (['min-price' => 'priceMin', 'max-price' => 'priceMax'] as $key => $property) {
            if (array_key_exists($key, $input)) {
                $this->legacy = true;
                if (is_numeric($input[$key])) {
                    $this->$property = (float) $input[$key];
                }
            }
        }
        foreach ($this->brandNames as $slug => $name) {
            if (array_key_exists($name, $input)) {
                $this->brands[] = $slug;
                $this->legacy = true;
            }
        }
        foreach (array_keys($this->colorIds) as $color) {
            if (array_key_exists($color, $input)) {
                $this->colors[] = $color;
                $this->legacy = true;
            }
        }
        if (in_array($input['sort'] ?? null, ['asc', 'desc'], true)) {
            $this->sort = 'price-' . $input['sort'];
            $this->legacy = true;
        }
    }

    private function normalise()
    {
        $this->brands = $this->ordered(array_unique($this->brands), array_keys($this->brandIds));
        $this->colors = $this->ordered(array_unique($this->colors), array_keys($this->colorIds));
        $this->ram = $this->ordered($this->ram, self::RAM);
        $this->display = $this->ordered($this->display, self::DISPLAY);
        $this->os = $this->ordered($this->os, self::OS);

        if ($this->priceMin !== null && $this->priceMin <= 0) {
            $this->priceMin = null;
        }
        if ($this->priceMin !== null && $this->priceMax !== null && $this->priceMin > $this->priceMax) {
            [$this->priceMin, $this->priceMax] = [$this->priceMax, $this->priceMin];
        }
        if ($this->sort === $this->defaultSort()) {
            $this->sort = null;
        }
        if ($this->sort === 'relevance' && $this->q === '') {
            $this->sort = null;
        }
    }

    public function defaultSort()
    {
        return $this->q !== '' ? 'relevance' : 'newest';
    }

    public function sort()
    {
        return $this->sort ?? $this->defaultSort();
    }

    /**
     * Query parameters in canonical order, without defaults.
     *
     * @param array $overrides e.g. ['brand' => null] to build a "remove this filter" link
     * @param bool $withPage
     * @return array
     */
    public function params(array $overrides = [], $withPage = false)
    {
        $params = [
            'q' => $this->q !== '' ? $this->q : null,
            'brand' => $this->brands ?: null,
            'color' => $this->colors ?: null,
            'price' => $this->priceMin !== null || $this->priceMax !== null
                ? $this->number($this->priceMin) . '-' . $this->number($this->priceMax) : null,
            'ram' => $this->ram ?: null,
            'display' => $this->display ?: null,
            'os' => $this->os ?: null,
            'stock' => $this->inStock ? 'in' : null,
            'sort' => $this->sort,
            'page' => $withPage && $this->page > 1 ? $this->page : null,
        ];

        return array_filter(array_replace($params, $overrides), function ($value) {
            return $value !== null && $value !== [];
        });
    }

    /**
     * Query string with readable commas, e.g. brand=apple,google&price=100-500.
     */
    public static function queryString(array $params)
    {
        return implode('&', array_map(function ($key, $value) {
            $value = is_array($value) ? implode(',', array_map('rawurlencode', $value)) : rawurlencode((string) $value);

            return $key . '=' . $value;
        }, array_keys($params), $params));
    }

    public function url(array $overrides = [], $withPage = false)
    {
        $query = self::queryString($this->params($overrides, $withPage));

        return route('smartphones') . ($query !== '' ? '?' . $query : '');
    }

    /**
     * The query string exactly as it should look for these filters.
     */
    public function canonicalQueryString()
    {
        return self::queryString($this->params([], true));
    }

    /**
     * Link that toggles one value of a multi-value filter.
     */
    public function toggleUrl($filter, $value)
    {
        $current = $this->{$this->property($filter)};
        $next = in_array($value, $current, true) ? array_values(array_diff($current, [$value])) : array_merge($current, [$value]);

        return $this->url([$filter => $next ?: null]);
    }

    public function hasActiveFilters()
    {
        return count($this->params()) > (isset($this->params()['sort']) ? 1 : 0);
    }

    /**
     * Active filters as chips: [label, url that removes it].
     *
     * @return array
     */
    public function chips()
    {
        $chips = [];
        if ($this->q !== '') {
            $chips[] = ['label' => '“' . $this->q . '”', 'url' => $this->url(['q' => null, 'sort' => $this->sort === 'relevance' ? null : $this->sort])];
        }
        foreach ($this->brands as $slug) {
            $chips[] = ['label' => $this->brandNames[$slug], 'url' => $this->toggleUrl('brand', $slug)];
        }
        foreach ($this->colors as $color) {
            $chips[] = ['label' => __($color), 'url' => $this->toggleUrl('color', $color)];
        }
        if ($this->priceMin !== null || $this->priceMax !== null) {
            $chips[] = ['label' => $this->priceLabel(), 'url' => $this->url(['price' => null])];
        }
        foreach ($this->ram as $ram) {
            $chips[] = ['label' => self::ramLabel($ram), 'url' => $this->toggleUrl('ram', $ram)];
        }
        foreach ($this->display as $display) {
            $chips[] = ['label' => self::displayLabel($display), 'url' => $this->toggleUrl('display', $display)];
        }
        foreach ($this->os as $os) {
            $chips[] = ['label' => self::osLabel($os), 'url' => $this->toggleUrl('os', $os)];
        }
        if ($this->inStock) {
            $chips[] = ['label' => __('In stock'), 'url' => $this->url(['stock' => null])];
        }

        return $chips;
    }

    /**
     * Apply the search and filters to a query.
     *
     * @param Builder $query
     * @param string|null $except filter to leave out, used for the per-option counts
     * @return Builder
     */
    public function apply(Builder $query, $except = null)
    {
        if ($this->q !== '') {
            $this->applySearch($query);
        }
        if ($this->brands && $except !== 'brand') {
            $query->whereIn('smartphones.brand_id', array_map(function ($slug) {
                return $this->brandIds[$slug];
            }, $this->brands));
        }
        if ($this->colors && $except !== 'color') {
            $query->whereIn('smartphones.color_id', array_map(function ($color) {
                return $this->colorIds[$color];
            }, $this->colors));
        }
        if ($except !== 'price') {
            if ($this->priceMin !== null) {
                $query->where('smartphones.price', '>=', $this->priceMin);
            }
            if ($this->priceMax !== null) {
                $query->where('smartphones.price', '<=', $this->priceMax);
            }
        }
        foreach (['ram' => 'ramBucketSql', 'display' => 'displayBucketSql', 'os' => 'osBucketSql'] as $filter => $bucketSql) {
            if ($this->$filter && $except !== $filter) {
                $placeholders = implode(',', array_fill(0, count($this->$filter), '?'));
                $query->whereRaw('(' . self::$bucketSql() . ") in ($placeholders)", $this->$filter);
            }
        }
        if ($this->inStock && $except !== 'stock') {
            $query->where('smartphones.quantity', '>', 0);
        }

        return $query;
    }

    private function applySearch(Builder $query)
    {
        $like = '%' . addcslashes(mb_strtolower($this->q), '%_\\') . '%';

        $query->where(function ($where) use ($like) {
            if (mb_strlen($this->q) >= 3) {
                $where->whereRaw(self::similaritySql() . ' >= ?', [$this->q, self::FUZZY_THRESHOLD]);
            }
            $where->orWhereRaw('lower(unaccent(smartphones.name)) like unaccent(?)', [$like])
                ->orWhereRaw("lower(unaccent(concat_ws(' ', smartphones.operating_system, smartphones.description,
                    smartphones.description_translations->>'de', smartphones.description_translations->>'sk'))) like unaccent(?)", [$like]);
        });
    }

    /**
     * Word similarity between the search text and "Brand Model".
     */
    private static function similaritySql()
    {
        return "word_similarity(lower(unaccent(?)), lower(unaccent(concat_ws(' ',
            (select brands.name from brands where brands.id = smartphones.brand_id), smartphones.name))))";
    }

    public function applySort(Builder $query)
    {
        switch ($this->sort()) {
            case 'relevance':
                $like = '%' . addcslashes(mb_strtolower($this->q), '%_\\') . '%';
                // names containing the text first, then by similarity
                $query->orderByRaw('(lower(unaccent(smartphones.name)) like unaccent(?)) desc', [$like])
                    ->orderByRaw(self::similaritySql() . ' desc', [$this->q]);
                break;
            case 'price-asc':
                $query->orderBy('smartphones.price');
                break;
            case 'price-desc':
                $query->orderByDesc('smartphones.price');
                break;
            case 'name':
                $query->orderBy('smartphones.name');
                break;
        }

        return $query->orderByDesc('smartphones.id');
    }

    /**
     * Number of matching phones per option of each filter, with all other filters applied.
     *
     * @return array
     */
    public function facets()
    {
        $count = function ($except, $groupSql) {
            return $this->apply(Smartphone::query(), $except)
                ->selectRaw("$groupSql as bucket, count(*) as total")
                ->groupBy(DB::raw($groupSql))
                ->pluck('total', 'bucket')
                ->all();
        };

        $brands = $count('brand', 'smartphones.brand_id');
        $colors = $count('color', 'smartphones.color_id');

        return [
            'brand' => array_map(function ($id) use ($brands) {
                return $brands[$id] ?? 0;
            }, $this->brandIds),
            'color' => array_map(function ($id) use ($colors) {
                return $colors[$id] ?? 0;
            }, $this->colorIds),
            'ram' => $count('ram', self::ramBucketSql()),
            'display' => $count('display', self::displayBucketSql()),
            'os' => $count('os', self::osBucketSql()),
            'stock' => $this->apply(Smartphone::query(), 'stock')->where('smartphones.quantity', '>', 0)->count(),
        ];
    }

    /**
     * Lowest and highest price in the catalog, for the price slider.
     */
    public static function priceBounds()
    {
        // rounded to tens, so the slider's 10 € steps land on round prices
        $row = Smartphone::selectRaw('floor(min(price) / 10) * 10 as min, ceil(max(price) / 10) * 10 as max')->first();

        return [(int) ($row->min ?? 0), (int) ($row->max ?? 0)];
    }

    public function brandOptions()
    {
        return $this->brandNames;
    }

    public function colorOptions()
    {
        return array_keys($this->colorIds);
    }

    private static function ramBucketSql()
    {
        return "case when smartphones.ram >= 12288 then '12' when smartphones.ram >= 8192 then '8'
            when smartphones.ram >= 6144 then '6' else '4' end";
    }

    private static function displayBucketSql()
    {
        return "case when smartphones.display_size < 6.2 then 'compact' when smartphones.display_size <= 6.6 then 'standard'
            else 'large' end";
    }

    private static function osBucketSql()
    {
        return "case lower(smartphones.operating_system) when 'android' then 'android' when 'ios' then 'ios' else 'other' end";
    }

    public static function ramLabel($ram)
    {
        return ['4' => '≤ 4 GB', '6' => '6 GB', '8' => '8 GB', '12' => '12 GB+'][$ram] ?? $ram;
    }

    public static function displayLabel($display)
    {
        return [
            'compact' => __('Compact (under 6.2")'),
            'standard' => __('Standard (6.2–6.6")'),
            'large' => __('Large (over 6.6")'),
        ][$display] ?? $display;
    }

    public static function osLabel($os)
    {
        return ['android' => 'Android', 'ios' => 'iOS', 'other' => __('Other')][$os] ?? $os;
    }

    public static function sortLabel($sort)
    {
        return [
            'relevance' => __('Best match'),
            'newest' => __('Newest'),
            'price-asc' => __('Price: low to high'),
            'price-desc' => __('Price: high to low'),
            'name' => __('Name: A–Z'),
        ][$sort] ?? $sort;
    }

    public function priceLabel()
    {
        if ($this->priceMin !== null && $this->priceMax !== null) {
            return formattedPrice($this->priceMin) . ' – ' . formattedPrice($this->priceMax);
        }

        return $this->priceMin !== null
            ? __('from :price', ['price' => formattedPrice($this->priceMin)])
            : __('up to :price', ['price' => formattedPrice($this->priceMax)]);
    }

    /**
     * Comma-separated string or array → list of strings.
     */
    private function values($value)
    {
        $values = is_array($value) ? $value : explode(',', (string) $value);

        return array_values(array_filter(array_map(function ($item) {
            return mb_strtolower(trim((string) $item));
        }, $values), 'strlen'));
    }

    private function pick(array $values, array $allowed)
    {
        return array_values(array_intersect($values, $allowed));
    }

    private function ordered(array $values, array $order)
    {
        return array_values(array_intersect($order, $values));
    }

    private function property($filter)
    {
        return ['brand' => 'brands', 'color' => 'colors'][$filter] ?? $filter;
    }

    private function number($value)
    {
        return $value === null ? '' : rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }
}
