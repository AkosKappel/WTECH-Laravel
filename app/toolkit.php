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
