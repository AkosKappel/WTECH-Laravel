<?php

namespace App\Support;

use App\Models\Smartphone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

/**
 * Phones to suggest on the 404 page: a fuzzy search for the words in the missing URL
 * (/wtech/smartphones/galaxy-s24 → "galaxy s24"), or the newest phones in stock.
 */
class NotFoundSuggestions
{
    /**
     * @param Request $request
     * @return array|null ['query' => string, 'matched' => bool, 'phones' => Collection, 'product' => bool], null on failure
     */
    public static function for(Request $request)
    {
        try {
            $segments = array_values(array_filter(explode('/', $request->path()), function ($segment) {
                return !in_array(strtolower($segment), ['wtech', 'smartphones', 'smartphone', 'products', 'product'], true);
            }));
            $query = trim(preg_replace('/\s+/', ' ', preg_replace('/[^\pL\pN]+/u', ' ', urldecode(implode(' ', $segments)))));
            $query = trim(preg_replace('/^\d+\s+/', '', $query)); // "42-google-pixel-8a" → "google pixel 8a"
            $query = ctype_digit(str_replace(' ', '', $query)) ? '' : Str::limit($query, 60, '');

            $phones = collect();
            if (mb_strlen($query) >= 3) {
                $filters = new CatalogFilters();
                $filters->q = $query;
                $phones = $filters->applySort($filters->apply(Smartphone::query()))->with(['images', 'brand'])->limit(4)->get();
            }
            $matched = $phones->isNotEmpty();
            if (!$matched) {
                $phones = Smartphone::with(['images', 'brand'])->where('quantity', '>', 0)->orderByDesc('id')->limit(4)->get();
            }

            return [
                'query' => $query,
                'matched' => $matched,
                'phones' => $phones,
                'product' => (bool) preg_match('#^wtech/smartphones/[^/]+/?$#', $request->path()),
            ];
        } catch (Throwable $e) {
            return null;
        }
    }
}
