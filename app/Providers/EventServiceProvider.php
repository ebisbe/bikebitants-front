<?php

namespace App\Providers;

use App\Business\Models\Shop\Product;
use App\Business\Search\ProductSearch;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Event;
use Cart;
use Cache;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\NewOrder' => [
            'App\Listeners\UpdateStockOrder',
        ],
        'App\Events\ConfirmedOrder' => [
            'App\Listeners\CreateOrder'
        ],
        'App\Events\CancelOrder' => [
            'App\Listeners\UpdateStockOrder',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('cart.removed', function () {
            if (Cart::isEmpty()) {
                Cart::clearCartConditions();
            }
        });

        Product::updated(function (Product $product) {
            Cache::tags(array_merge($product->categories, [ProductSearch::GLOBAL_CACHE_TAG]))->flush();
        });
    }
}
