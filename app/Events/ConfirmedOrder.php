<?php

namespace App\Events;

use App\Order;
use Illuminate\Queue\SerializesModels;

class ConfirmedOrder extends Event
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
