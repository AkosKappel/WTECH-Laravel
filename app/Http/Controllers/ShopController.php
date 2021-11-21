<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Color;
use App\Models\Image;
use App\Models\Smartphone;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $recommendedSmartphones = Smartphone::inRandomOrder()->take(3)->get();
        return view('layout/app', [
            'smartphones' => $recommendedSmartphones,
        ]);
    }
}
