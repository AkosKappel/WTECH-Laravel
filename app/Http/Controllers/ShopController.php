<?php

namespace App\Http\Controllers;


use App\Models\Smartphone;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $bestSelling = Smartphone::bestSelling()->take(3)->get();
        $topBrands = Brand::inRandomOrder()->take(6)->get();

        return view('layout/app', [
            'smartphones' => $bestSelling,
            'brands' => $topBrands,
        ]);
    }

    /**
     * Hide the demo notice for a year. Fallback for browsers without JavaScript;
     * with JavaScript the cookie is set directly in the browser.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dismissDemoNotice(Request $request)
    {
        return back()->withCookie(cookie('demo_notice_dismissed', '1', 60 * 24 * 365));
    }

    /**
     * Remember the visitor's language for a year and go back to the same page.
     *
     * @param Request $request
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLocale(Request $request, $locale)
    {
        abort_unless(array_key_exists($locale, config('app.locales')), 404);

        return back()->withCookie(cookie(\App\Http\Middleware\SetLocale::COOKIE, $locale, 60 * 24 * 365));
    }

    /**
     * Unknown URLs. Missing files (images, scripts) get a plain 404 instead of the full page.
     */
    public function notFound(Request $request)
    {
        if (preg_match('/\.(png|jpe?g|gif|svg|webp|ico|css|js|map|json|xml|txt|woff2?|ttf|eot|php)$/i', $request->path())) {
            return response('Not Found', 404)->header('Content-Type', 'text/plain');
        }

        abort(404);
    }

    /**
     * Throws on purpose, so admins can check the 500 page and its diagnostics.
     */
    public function errorTest()
    {
        throw new \RuntimeException('Test error triggered from the admin zone. Nothing is broken.');
    }
}
