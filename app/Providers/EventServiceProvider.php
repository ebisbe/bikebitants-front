<?php

namespace App\Providers;

use App\Business\Models\Shop\Product;
use Request;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Event;
use Cart;

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
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('cart.removed', function () {
            if (Cart::isEmpty()) {
                Request::session()->forget('coupons');
                Cart::clearCartConditions();
            }
        });

        Event::listen('cart.updating', function ($items) {
            $coupons = collect(Request::session()->get('coupons', []));
            $conditionsName = collect($items['conditions'])->map(function($condition) {
                return $condition->getName();
            });
            // If the count is one means that the condition is the IVA applied therefore
            // we dont continue the update.
            if ($conditionsName->diff($coupons)->count() == 1) {
                return false;
            }
        });

        Product::updated(function($product) {
            \Cache::tags($product->categories)->flush();
        });

    }
}
