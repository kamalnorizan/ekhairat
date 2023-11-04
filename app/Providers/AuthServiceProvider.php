<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('access-admin', function ($user) {
            return in_array($user->kodstatuspengguna,['1','2','3','4','5','6']);
        });

        Gate::define('access-systemadmin', function ($user) {
            return in_array($user->kodstatuspengguna,['5','1']);
        });

        Gate::define('access-superadmin', function ($user) {
            return in_array($user->kodstatuspengguna,['1']);
        });
    }
}
