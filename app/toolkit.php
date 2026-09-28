<?php

function formattedPrice($price): string
{
    return number_format((float) $price, 2, ',', ' ') . ' €';
}

/**
 * Number with up to two decimals in the current language's style: 6.1 in English, 6,1 in German and Slovak.
 */
function localizedNumber($number): string
{
    $formatted = rtrim(rtrim(number_format((float) $number, 2, '.', ''), '0'), '.');

    return app()->getLocale() === 'en' ? $formatted : str_replace('.', ',', $formatted);
}
