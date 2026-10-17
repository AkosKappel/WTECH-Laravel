<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Maintenance;
use Illuminate\Foundation\Http\MaintenanceModeBypassCookie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Maintenance in the admin zone: plan a window (announced in a banner), take the shop down
 * and bring it back. The admin who turns it on gets the bypass cookie and stays in.
 */
class MaintenanceController extends Controller
{
    public function index()
    {
        return view('layout.admin.maintenance', ['plan' => Maintenance::plan(), 'down' => Maintenance::isDown()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:300',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date' . ($request->filled('starts_at') ? '|after:starts_at' : ''),
        ]);
        $time = fn ($value) => filled($value) ? Carbon::parse($value, config('demo.reset.timezone')) : null;
        Maintenance::savePlan($request->message, $time($request->starts_at), $time($request->ends_at));

        if ($request->input('action') === 'start') {
            $secret = Maintenance::start();

            return redirect()->route('admin.maintenance')
                ->withCookie(MaintenanceModeBypassCookie::create($secret))
                ->with('success_message', __('The shop is in maintenance mode. You can still use it; visitors see the maintenance page.'));
        }

        return redirect()->route('admin.maintenance')->with('success_message', __('Maintenance plan saved.'));
    }

    public function destroy()
    {
        Maintenance::stop();

        return redirect()->route('admin.maintenance')->with('success_message', __('The shop is open again.'));
    }
}
