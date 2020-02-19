<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            Gate::define($permission->slug, function($user) use($permission){
                return $user->hasPermissionTo($permission->slug);
            });
        }
    }
}
