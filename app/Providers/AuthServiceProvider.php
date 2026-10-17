<?php

namespace App\Providers;

use App\Models\Smartphone;
use App\Policies\SmartphonePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Smartphone' => 'App\Policies\SmartphonePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user) {
            return $user->isAdmin();
        });

        // the product part of the admin zone, which demo admins may use too
        Gate::define('adminZone', function($user) {
            return $user->isAdmin() || $user->isDemoAdmin();
        });
        //
    }
}
