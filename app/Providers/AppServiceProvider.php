<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('administrator', function(User $user){
            return $user->hasRole([1,2])
                ? Response::allow()
                : Response::deny('Hanya bisa diakses oleh administrator.');
        });
        
        Gate::define('superadmin', function(User $user){
            return $user->hasRole([1])
                ? Response::allow()
                : Response::deny('Hanya bisa diakses oleh super admin.');
        });
    }
}
