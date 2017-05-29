<?php

namespace App\Business\Checkout\Events;

use App\Events\Event;
use App\Order;
use Illuminate\Queue\SerializesModels;

class Confirm extends Event
{
    use SerializesModels;

    /** @var  Order $order */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
