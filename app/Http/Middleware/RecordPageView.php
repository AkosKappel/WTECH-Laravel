<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * Counts successful page views by people (not bots, not admins) for the admin statistics,
 * after the response has been sent. See the page_views migration for what is stored.
 */
class RecordPageView
{
    private const BOTS = '/bot|crawl|spider|slurp|curl|wget|python|httpclient|java\/|go-http|monitor|uptime|headless|lighthouse|preview|facebookexternalhit|scan/i';

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        $agent = (string) $request->userAgent();
        if (!$request->isMethod('GET') || $response->getStatusCode() !== 200
            || !Str::startsWith((string) $response->headers->get('Content-Type'), 'text/html')
            || $request->header('X-Catalog-Partial') || $agent === '' || preg_match(self::BOTS, $agent)
            || $request->user()?->isAdmin()) {
            return;
        }

        try {
            $referrer = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST);
            $smartphone = $request->route('smartphone');

            DB::table('page_views')->insert([
                'path' => Str::limit('/' . ltrim($request->path(), '/'), 250, ''),
                'smartphone_id' => $request->routeIs('details') && is_object($smartphone) ? $smartphone->id : null,
                'referrer_host' => $referrer && $referrer !== $request->getHost() ? Str::limit($referrer, 250, '') : null,
                'device' => self::device($agent),
                'browser' => self::browser($agent),
                'visitor' => substr(hash('sha256', now()->toDateString() . config('app.key') . $request->ip() . $agent), 0, 16),
                'created_at' => now(),
            ]);
        } catch (Throwable $e) {
            // statistics must never break a page
            report($e);
        }
    }

    public static function device(string $agent)
    {
        if (preg_match('/iPad|Tablet|Android(?!.*Mobile)/i', $agent)) {
            return 'tablet';
        }

        return preg_match('/Mobi|iPhone|Android/i', $agent) ? 'mobile' : 'desktop';
    }

    public static function browser(string $agent)
    {
        foreach (['Edg' => 'Edge', 'OPR' => 'Opera', 'SamsungBrowser' => 'Samsung', 'Firefox' => 'Firefox', 'Chrome' => 'Chrome', 'Safari' => 'Safari'] as $token => $name) {
            if (str_contains($agent, $token)) {
                return $name;
            }
        }

        return 'Other';
    }
}
