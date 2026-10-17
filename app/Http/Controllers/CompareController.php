<?php

namespace App\Http\Controllers;

use App\Models\Smartphone;
use Illuminate\Http\Request;

/**
 * Side-by-side comparison of up to four phones, kept in the session.
 */
class CompareController extends Controller
{
    const SESSION_KEY = 'compare';
    const MAX = 4;

    public function index(Request $request)
    {
        $ids = $request->session()->get(self::SESSION_KEY, []);
        $smartphones = Smartphone::with(['images', 'brand', 'color'])->withAvg('reviews', 'rating')->withCount('reviews')
            ->whereIn('id', $ids)->get()->sortBy(fn ($smartphone) => array_search($smartphone->id, $ids))->values();

        return view('layout.products.compare', ['smartphones' => $smartphones]);
    }

    public function toggle(Request $request, Smartphone $smartphone)
    {
        $ids = $request->session()->get(self::SESSION_KEY, []);

        if (in_array($smartphone->id, $ids, true)) {
            $ids = array_values(array_diff($ids, [$smartphone->id]));
            $message = __(':name was removed from the comparison.', ['name' => $smartphone->name]);
        } elseif (count($ids) >= self::MAX) {
            return back()->withErrors(['compare' => __('You can compare up to :count phones. Remove one first.', ['count' => self::MAX])]);
        } else {
            $ids[] = $smartphone->id;
            $message = __(':name was added to the comparison.', ['name' => $smartphone->name]);
        }
        $request->session()->put(self::SESSION_KEY, $ids);

        return back()->with('success_message', $message);
    }

    public function clear(Request $request)
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('smartphones');
    }
}
