<?php

namespace App\Listeners;

use App\Facades\Cart;
use Illuminate\Auth\Events\Login;

class RestoreSavedCart
{
    /**
     * Merge the cart saved at the last logout into the session cart. Runs for every login,
     * including remember-me logins that never pass the login form.
     */
    public function handle(Login $event): void
    {
        Cart::restore($event->user->email);
    }
}
