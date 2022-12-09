<?php

namespace App\Providers;

use App\Models\Project;
use App\Observers\ProjectObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
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
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
//        Paginator::defaultSimpleView('vendor.pagination.bootstrap-4');
//        Project::observe(ProjectObserver::class);
//        Blade::component(HeadMenu::class, 'head-menu');
    }
}
