<?php

namespace App\Providers;

use App\Category;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Category::saving(function ($category) {
            //Categories are created at parent level, never on child level
            if (empty($category->order)) {
                $order = Category::where('father_id', 'exists', false)->orderBy('order', 'desc')->first();
                $category->order = !is_null($order) ? $order->order + 1 : 1;
            }
        });

        if($this->app->environment() != 'production') {
            DB::connection('mongodb')->enableQueryLog();
        }

        Blade::directive('injectCss', function ($cssRoute) {
            return "<style><?php echo file_get_contents(resource_path({$cssRoute})); ?></style>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        $this->app->bind('title', 'App\Business\Admin\Title');
        $this->app->bind('breadcrumblinks', 'App\Business\Admin\BreadCrumbLinks');
        $this->app->bind('staticvars', 'App\Business\StaticVars');
        $this->app->bind('taxservice', 'App\Business\Services\TaxService');
        $this->app->bind('orderservice', 'App\Business\Services\OrderService');

        $this->app->bind('App\Business\Services\TwitterService', \App\Business\Services\TwitterService::class);
        $this->app->bind('NewOrder', \App\Business\Status\NewOrder::class);
    }
}
