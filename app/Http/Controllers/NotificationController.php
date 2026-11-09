<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * The signed-in customer's notifications (wishlist alerts).
 */
class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return view('layout.user.notifications', [
            'notifications' => $request->user()->notifications()->paginate(20),
        ]);
    }

    public function markAsRead(Request $request, string $notification)
    {
        $request->user()->notifications()->findOrFail($notification)->markAsRead();

        return back();
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return back()->with('success_message', __('All notifications are marked as read.'));
    }
}
