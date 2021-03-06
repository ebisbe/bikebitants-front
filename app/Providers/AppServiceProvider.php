<?php

namespace App\Providers;

use App\Business\Checkout\Status\NewOrder;
use App\Category;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Blade;
use Jenssegers\Mongodb\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('injectCss', function ($cssRoute) {
            return "<style><?php echo file_get_contents(resource_path({$cssRoute})); ?></style>";
        });

        view()->composer('*', function ($view) {
            $view_name = str_replace('.', '_', $view->getName());
            view()->share('view_name', $view_name);
            view()->share('isProduct', '');
        });

        if ($this->app->isLocal()) {
            DB::connection('mongodb')->enableQueryLog();
        } else {
            \Request::setTrustedProxies(['172.18.0.0/16']);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        $this->app->bind('title', \App\Business\Admin\Title::class);
        $this->app->bind('breadcrumblinks', \App\Business\Admin\BreadCrumbLinks::class);
        $this->app->bind('staticvars', \App\Business\StaticVars::class);
        $this->app->bind('taxservice', \App\Business\Services\TaxService::class);
        $this->app->bind('orderservice', \App\Business\Services\OrderService::class);
        $this->app->bind('canonical', \App\Business\Canonical\Canonical::class);

        $this->app->bind(\App\Business\Services\TwitterService::class, \App\Business\Services\TwitterService::class);
        $this->app->bind('NewOrder', NewOrder::class);

        Builder::macro('getName', function () {
            return 'mongodb';
        });
    }
}
