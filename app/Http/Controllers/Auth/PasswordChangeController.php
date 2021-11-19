<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class PasswordChangeController extends Controller
{
    /**
     * Display the password change link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('layout.user.passwordChange');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'oldPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required', Rules\Password::defaults()],
        ]);

        User::find(Auth()->user()->id)->update(['password' => Hash::make($request->newPassword)]);

//        dd('Password change successfully.');
        return redirect('profile');
    }
}
