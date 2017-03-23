<?php

namespace App\Business\Checkout\Events;

use App\Events\Event;
use App\Order;
use Illuminate\Queue\SerializesModels;

class Cancel extends Event
{
    use SerializesModels;

    public $order;

    /**
     * CancelOrder constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
