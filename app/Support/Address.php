<?php

namespace App\Support;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Personal and delivery details, as entered at checkout and on the profile: the countries the
 * shop delivers to and the validation rules both forms share.
 */
class Address
{
    /**
     * Countries the shop delivers to (EU, EEA, Switzerland, United Kingdom), stored by their
     * English name and translated for display.
     */
    const COUNTRIES = [
        'Austria', 'Belgium', 'Bulgaria', 'Croatia', 'Cyprus', 'Czechia', 'Denmark', 'Estonia', 'Finland',
        'France', 'Germany', 'Greece', 'Hungary', 'Iceland', 'Ireland', 'Italy', 'Latvia', 'Liechtenstein',
        'Lithuania', 'Luxembourg', 'Malta', 'Netherlands', 'Norway', 'Poland', 'Portugal', 'Romania',
        'Slovakia', 'Slovenia', 'Spain', 'Sweden', 'Switzerland', 'United Kingdom',
    ];

    /** Letters (any alphabet) with spaces, hyphens, apostrophes and dots: "Anna-Mária", "O'Neill", "St. Pölten". */
    const NAME_PATTERN = "/^[\\pL\\pM][\\pL\\pM\\s'’.\\-]*$/u";

    /**
     * English name => name in the current language, sorted for the current language.
     */
    public static function countries()
    {
        $countries = array_combine(self::COUNTRIES, array_map(fn ($name) => __($name), self::COUNTRIES));
        // by the name without accents, so Česko and Österreich sort under C and O (no intl extension here)
        uasort($countries, fn ($a, $b) => strcasecmp(Str::ascii($a), Str::ascii($b)));

        return $countries;
    }

    /**
     * @param bool $required checkout needs everything; on the profile every field is optional
     */
    public static function rules($required)
    {
        $presence = $required ? 'required' : 'nullable';

        return [
            'first_name' => [$presence, 'string', 'max:100', 'regex:' . self::NAME_PATTERN],
            'last_name' => [$presence, 'string', 'max:100', 'regex:' . self::NAME_PATTERN],
            // digits with the usual separators; 7 to 15 digits as in the international (E.164) format
            'phone_number' => [$presence, 'string', 'max:25', 'regex:/^\+?[0-9][0-9 ()\/.\-]*$/', function ($attribute, $value, $fail) {
                $digits = strlen(preg_replace('/\D/', '', (string) $value));
                if ($digits < 7 || $digits > 15) {
                    $fail(__('Enter a phone number with 7 to 15 digits, e.g. +421 900 123 456.'));
                }
            }],
            // must name a street, not only a number
            'street' => [$presence, 'string', 'max:120', 'regex:/\pL/u'],
            // a house number, optionally with letters or a second number: 12, 12A, 1234/56
            'descriptive_number' => [$presence, 'string', 'max:20', 'regex:/^[0-9]+[0-9A-Za-z\/\- ]*$/'],
            'city' => [$presence, 'string', 'max:100', "regex:/^[\\pL\\pM][\\pL\\pM0-9\\s'’.()\\-]*$/u"],
            'country' => [$presence, Rule::in(self::COUNTRIES)],
        ];
    }

    public static function messages()
    {
        return [
            'first_name.regex' => __('Use letters only (spaces, hyphens and apostrophes are fine).'),
            'last_name.regex' => __('Use letters only (spaces, hyphens and apostrophes are fine).'),
            'phone_number.regex' => __('Enter a phone number with 7 to 15 digits, e.g. +421 900 123 456.'),
            'street.regex' => __('Enter the street name; the house number has its own field.'),
            'descriptive_number.regex' => __('Enter a house number, e.g. 12, 12A or 1234/56.'),
            'city.regex' => __('Enter a city name.'),
            'country.in' => __('Choose a country from the list.'),
        ];
    }
}
