<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Smartphone;
use Illuminate\Http\Request;

/**
 * Reviews on the product page: one per customer and phone (a second one replaces the first).
 */
class ReviewController extends Controller
{
    public function store(Request $request, Smartphone $smartphone)
    {
        $data = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'body' => 'nullable|string|max:2000',
        ]);

        Review::updateOrCreate(
            ['smartphone_id' => $smartphone->id, 'user_id' => $request->user()->id],
            $data,
        );

        return redirect(route('details', $smartphone) . '#reviews')->with('success_message', __('Thank you for your review!'));
    }

    /**
     * Customers delete their own review; admins any review.
     */
    public function destroy(Request $request, Review $review)
    {
        abort_unless($review->user_id === $request->user()->id || $request->user()->isAdmin(), 403);
        $review->delete();

        return back()->with('success_message', __('The review was deleted.'));
    }
}
