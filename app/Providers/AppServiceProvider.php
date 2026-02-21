<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\UserRolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        Gate::define('isAdministration',[UserRolePolicy::class,'isAdministration']);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isAdministration',[UserRolePolicy::class,'isAdministration']);
        Gate::define('isAdmin',[UserRolePolicy::class,'isAdmin']);
        Gate::define('isNotReception',[UserRolePolicy::class,'isNotReception']);
        Gate::define('isMedic',[UserRolePolicy::class,'isMedic']);
        Gate::define('isReceptionist',[UserRolePolicy::class,'isReceptionist']);
        Gate::define('isPatient',[UserRolePolicy::class,'isPatient']);
        Gate::define('isNotRoot',[UserRolePolicy::class,'isNotRoot']);
    }
}
