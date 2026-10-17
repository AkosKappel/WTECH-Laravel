<?php

namespace App\Http\Controllers;

use App\Models\Smartphone;
use Illuminate\Http\Request;

/**
 * The signed-in customer's wishlist.
 */
class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $smartphones = $request->user()->wishlist()->with(['images'])->withAvg('reviews', 'rating')->withCount('reviews')
            ->orderByPivot('created_at', 'desc')->get();

        return view('layout.user.wishlist', ['smartphones' => $smartphones]);
    }

    /**
     * Add the phone, or remove it when it's already on the list.
     */
    public function toggle(Request $request, Smartphone $smartphone)
    {
        $added = count($request->user()->wishlist()->toggle($smartphone->id)['attached']) > 0;

        return back()->with('success_message', $added
            ? __(':name is on your wishlist.', ['name' => $smartphone->name])
            : __(':name was removed from your wishlist.', ['name' => $smartphone->name]));
    }
}
