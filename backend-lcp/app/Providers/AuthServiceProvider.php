<?php

namespace App\Providers;

use App\Models\DataBase;
use App\Models\DataSource;
use App\Models\DataSourceAccess;
use App\Models\User;
use App\Policies\DataBasePolicy;
use App\Policies\DataSourceAccessPolicy;
use App\Policies\DataSourcePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        DataBase::class => DataBasePolicy::class,
        DataSource::class => DataSourcePolicy::class,
        DataSourceAccess::class => DataSourceAccessPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
