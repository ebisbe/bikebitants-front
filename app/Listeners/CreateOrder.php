<?php

namespace App\Listeners;

use App\Business\Integration\Wordpress\Order;
use App\Events\ConfirmedOrder;

class CreateOrder
{
    /**
     * @var Order
     */
    private $order;

    /**
     * CreateOrder constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Handle the event.
     *
     * @param  ConfirmedOrder  $event
     * @return void
     */
    public function handle(ConfirmedOrder $event)
    {
        if (config('app.env') == 'production') {
            $this->order->create($event->order);
        }
    }
}
