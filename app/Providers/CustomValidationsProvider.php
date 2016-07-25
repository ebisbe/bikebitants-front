<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class CustomValidationsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('not_expired', 'App\Business\Validators\CouponValidator@not_expired');
        Validator::extend('minimum_cart', 'App\Business\Validators\CouponValidator@minimum_cart');
        Validator::extend('maximum_cart', 'App\Business\Validators\CouponValidator@maximum_cart');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
