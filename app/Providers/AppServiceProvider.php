<?php

namespace App\Providers;

use App\Category;
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

        DB::connection('mongodb')->enableQueryLog();

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
        $this->app->bind('title', 'App\Business\Admin\Title');
        $this->app->bind('breadcrumblinks', 'App\Business\Admin\BreadCrumbLinks');
        $this->app->bind('staticvars', 'App\Business\StaticVars');
        $this->app->bind('App\Business\Services\TwitterService', 'App\Business\Services\TwitterService');

    }
}
