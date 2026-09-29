<?php

namespace App\Providers;

use App\Support\Cart;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cart::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // behind a TLS-terminating proxy the app itself only sees plain HTTP
        if (str_starts_with(config('app.url'), 'https://')) {
            \URL::forceScheme('https');
            // absolute links (password resets) always use APP_URL's host, never a forwarded one
            \URL::forceRootUrl(config('app.url'));
        }
    }
}
