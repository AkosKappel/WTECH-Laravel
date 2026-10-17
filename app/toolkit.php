<?php

/**
 * Price in the current language's style, as Intl.NumberFormat writes it in details.js:
 * €1,234.56 in English, 1.234,56 € in German, 1 234,56 € in Slovak.
 */
function formattedPrice($price): string
{
    return match (app()->getLocale()) {
        'en' => '€' . number_format((float) $price, 2, '.', ','),
        'de' => number_format((float) $price, 2, ',', '.') . ' €',
        default => number_format((float) $price, 2, ',', ' ') . ' €',
    };
}

/**
 * Number with up to two decimals in the current language's style: 6.1 in English, 6,1 in German and Slovak.
 */
function localizedNumber($number): string
{
    $formatted = rtrim(rtrim(number_format((float) $number, 2, '.', ''), '0'), '.');

    return app()->getLocale() === 'en' ? $formatted : str_replace('.', ',', $formatted);
}

/**
 * A URL of this site in another language: /de/… or /sk/…, or without a prefix for English.
 * Defaults to the current page with its query string.
 */
function localizedUrl(string $locale, ?string $url = null): string
{
    // the same root the URL generator uses (APP_URL in production)
    $root = rtrim(app('url')->formatRoot(app('url')->formatScheme()), '/');
    $path = $url === null ? request()->getRequestUri() : (substr($url, strlen($root)) ?: '/');
    // drop a language prefix the URL may already have
    $path = preg_replace('#^/(' . implode('|', array_keys(config('app.locales'))) . ')(?=/|\?|$)#', '', $path) ?: '/';
    $prefix = $locale === config('app.fallback_locale') ? '' : '/' . $locale;

    return $root . ($prefix !== '' && $path === '/' ? $prefix : $prefix . $path);
}
