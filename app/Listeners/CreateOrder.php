<?php

namespace App\Listeners;

use App\Business\Checkout\Events\Confirm;
use App\Business\Integration\WooCommerce\Order;
use Slack;

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
     * @param Confirm $event
     */
    public function handle(Confirm $event)
    {
        if (config('app.env') == 'production') {
            $order = $this->order->create($event->order);
            //TODO send in a separete event?
            Slack::send("New order #{$order->external_id}!");
        }
    }
}
