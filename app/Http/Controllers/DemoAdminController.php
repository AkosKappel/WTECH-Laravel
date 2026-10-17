<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * "Try the admin demo": a fresh demo admin account per visitor, signed in at once. No password
 * is ever shown; the nightly reset deletes the accounts and everything they created.
 */
class DemoAdminController extends Controller
{
    public function store(Request $request)
    {
        $user = new User([
            'first_name' => 'Demo',
            'last_name' => 'Admin',
            'email' => 'demo-' . Str::lower(Str::random(10)) . '@demo.invalid',
            'password' => bcrypt(Str::random(40)),
        ]);
        $user->forceFill(['role' => User::ROLE_DEMO_ADMIN])->save();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin')->with('success_message', __('Welcome to the admin demo!'));
    }
}
