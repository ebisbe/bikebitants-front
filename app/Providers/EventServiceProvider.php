<?php

namespace App\Providers;

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
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        Event::listen('cart.removed', function ($id, $cart) {
            if (Cart::isEmpty()) {
                Request::session()->forget('coupons');
                Cart::clearCartConditions();
            }
        });

        Event::listen('cart.updating', function ($items, $cart) {
            $coupons = collect(Request::session()->get('coupons', []));
            if (
                !empty($items['conditions'])
                && $coupons
                    ->pluck('name')
                    ->contains($items['conditions'][0]->getName())
            ) {
                return false;
            }
        });

    }
}
