<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

/**
 * Language prefixes in URLs: /de/smartphones and /sk/smartphones are the German and Slovak
 * versions of /smartphones (English has no prefix). The prefix is taken off before routing,
 * so every route works in every language, and added to all URLs the app generates.
 */
class LocalizeUrl
{
    const ATTRIBUTE = 'url_locale';

    public function handle(Request $request, Closure $next)
    {
        $prefixed = array_diff(array_keys(config('app.locales')), [config('app.fallback_locale')]);
        $segments = explode('/', ltrim($request->getPathInfo(), '/'), 2);

        if (in_array($segments[0], $prefixed, true)) {
            $locale = $segments[0];
            $uri = $request->server->get('REQUEST_URI');
            $request->server->set('REQUEST_URI', preg_replace('#^/' . $locale . '(?=/|\?|$)#', '', $uri) ?: '/');
            // re-read the path from the changed REQUEST_URI
            $request->initialize($request->query->all(), $request->request->all(), $request->attributes->all(),
                $request->cookies->all(), $request->files->all(), $request->server->all(), $request->getContent());
            $request->attributes->set(self::ATTRIBUTE, $locale);

            URL::formatPathUsing(fn ($path) => '/' . $locale . ($path === '/' ? '' : $path));
        }

        return $next($request);
    }

    /**
     * The generator outlives the request in tests and long-running workers; start the next one clean.
     */
    public function terminate()
    {
        URL::formatPathUsing(fn ($path) => $path);
    }
}
