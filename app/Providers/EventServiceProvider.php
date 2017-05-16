<?php

namespace App\Providers;

use App\Business\Checkout\Events\Cancel;
use App\Business\Checkout\Events\Confirm;
use App\Business\Checkout\Events\Create;
use App\Events\OrderPushed;
use App\Listeners\PushOrder;
use App\Listeners\NotifySaleToCarrier;
use App\Listeners\NotifySaleToProvider;
use App\Listeners\UpdateStockOrder;
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
        Create::class => [
            UpdateStockOrder::class,
        ],
        Confirm::class => [
            PushOrder::class,
        ],
        Cancel::class => [
            UpdateStockOrder::class,
        ],
        OrderPushed::class => [
            NotifySaleToCarrier::class,
        ]
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
    }
}
