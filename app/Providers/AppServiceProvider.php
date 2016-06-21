<?php

namespace App\Providers;

use App\Business\Admin\BreadCrumbLinks;
use App\Business\Admin\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::connection('mongodb')->enableQueryLog();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['title'] = $this->app->share(function ($app) {
            return new Title();
        });

        $this->app['breadcrumblinks'] = $this->app->share(function ($app) {
            return new BreadCrumbLinks();
        });
    }
}
