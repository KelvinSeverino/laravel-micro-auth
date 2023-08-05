<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('users', function($user) {
            return $user->hasPermission('users');
        });

        Gate::define('add_permissions_users', function($user) {
            return $user->hasPermission('add_permissions_users');
        });

        Gate::before(function($user) {
            if($user->isSuperAdmin()){
                return true;
            }
        });
    }
}
