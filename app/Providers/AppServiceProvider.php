<?php

namespace App\Providers;

use App\Business\Admin\BreadCrumbLinks;
use App\Business\Admin\Title;
use App\Business\StaticVars;
use App\Category;
use App\Coupon;
use App\Jobs\UpdateCategories;
use App\Product;
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
        Coupon::saving(function ($coupon) {
            $coupon->emails = explode(',', $coupon->emails);
            return $coupon;
        });

        Category::saving(function($category) {
            //Categories are created at parent level, never on child level
            if(empty($category->order)) {
                $order = Category::where('father_id', 'exists', false)->orderBy('order', 'desc')->first();
                $category->order = !is_null($order) ? $order->order + 1 : 1;
            }
        });

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

        $this->app['staticvars'] = $this->app->share(function ($app) {
            return new StaticVars();
        });
    }
}
