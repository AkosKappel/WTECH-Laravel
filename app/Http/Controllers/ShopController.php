<?php

namespace App\Http\Controllers;


use App\Models\Smartphone;
use App\Models\Brand;
use Gloudemans\Shoppingcart\Facades\Cart;
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
        $recommendedSmartphones = Smartphone::inRandomOrder()->take(3)->get();
        $topBrands = Brand::inRandomOrder()->take(6)->get();

        return view('layout/app', [
            'smartphones' => $recommendedSmartphones,
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
}
