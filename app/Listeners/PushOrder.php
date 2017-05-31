<?php

namespace App\Listeners;

use App\Business\Checkout\Events\Confirm;
use App\Business\Integration\WooCommerce\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notifiable;

class PushOrder
{
    use Notifiable;
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
            $this->order->create($event->order);
        }
    }

    /**
     * @param $queue
     * @param $job
     * @param $data
     */
    public function queue($queue, $job, $data)
    {
        if (config('app.env') == 'production') {
            $queue->push($job, $data);
        }
    }
}
