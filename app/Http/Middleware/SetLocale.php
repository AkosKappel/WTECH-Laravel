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
     * The language comes from the URL (/de/…, /sk/…; no prefix is English). A visitor who
     * chose another language (cookie), or whose browser prefers one, is sent from an
     * English page to the same page in that language.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->attributes->get(LocalizeUrl::ATTRIBUTE, config('app.fallback_locale'));

        if ($locale === config('app.fallback_locale') && $this->isPageView($request)) {
            $preferred = $this->preferred($request);
            if ($preferred !== $locale) {
                return redirect(localizedUrl($preferred))->header('Vary', 'Cookie, Accept-Language');
            }
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }

    private function preferred(Request $request)
    {
        $available = array_keys(config('app.locales'));
        $chosen = $request->cookie(self::COOKIE);
        if (in_array($chosen, $available, true)) {
            return $chosen;
        }

        // getPreferredLanguage() falls back to the first entry, so keep the default first
        return $request->getPreferredLanguage(array_values(array_unique(array_merge([config('app.fallback_locale')], $available))));
    }

    /**
     * Plain page loads only: no forms, background requests or the JSON API.
     */
    private function isPageView(Request $request)
    {
        return $request->isMethod('GET') && !$request->expectsJson() && !$request->ajax()
            && !$request->header('X-Catalog-Partial');
    }
}
