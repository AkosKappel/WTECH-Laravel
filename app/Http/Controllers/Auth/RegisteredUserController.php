<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $emailValidation = ['required', 'string', 'email', 'max:255'];

        $potentialUser = User::firstWhere('email', $request->email);
        if (!is_null($potentialUser) && !is_null($potentialUser->password)) {
            array_push($emailValidation, 'unique:users');
        }

        $request->validate([
            'email' => $emailValidation,
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if (!is_null($potentialUser) && is_null($potentialUser->password)) {
            $potentialUser->update([
                'password' => Hash::make($request->password),
            ]);
            $user = $potentialUser;
        } else {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function redirectAfterOrder(Request $request)
    {
        return view('layout.user.finishRegister');
    }

    public function storeAfterOrder(Request $request)
    {
        $request->validate([
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::firstWhere('email', $request->session()->get('email'));
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
