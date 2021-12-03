<?php

namespace App\Http\Controllers;


use App\Models\Smartphone;
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

        return view('layout/app', [
            'smartphones' => $recommendedSmartphones,
        ]);
    }
}
