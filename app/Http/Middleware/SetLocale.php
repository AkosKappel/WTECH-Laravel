<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Name of the cookie that remembers the visitor's language.
     */
    const COOKIE = 'locale';

    /**
     * Use the language the visitor chose (cookie), otherwise the best match for
     * their browser's languages, otherwise the default locale.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $available = array_keys(config('app.locales'));
        $chosen = $request->cookie(self::COOKIE);

        if (in_array($chosen, $available, true)) {
            $locale = $chosen;
        } else {
            // getPreferredLanguage() falls back to the first entry, so keep the default first
            $candidates = array_values(array_unique(array_merge([config('app.locale')], $available)));
            $locale = $request->getPreferredLanguage($candidates);
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
