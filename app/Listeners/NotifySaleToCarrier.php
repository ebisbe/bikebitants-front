<?php

namespace App\Listeners;

use App\Business\Deliverea\Shipment;
use App\Events\OrderPushed;
use App\PaymentMethod;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySaleToCarrier implements ShouldQueue
{
    /**
     * @var Shipment
     */
    private $shipment;

    public $tries = 1;

    /**
     * Create the event listener.
     *
     * @param Shipment $shipment
     */
    public function __construct(Shipment $shipment)
    {
        //
        $this->shipment = $shipment;
    }

    /**
     * Handle the event.
     *
     * @param OrderPushed $event
     * @return void
     */
    public function handle(OrderPushed $event)
    {
        $this->shipment->order($event->order);
        $this->shipment->process();
    }

    /**
     * @param $queue
     * @param $job
     * @param $data
     */
    public function queue($queue, $job, $data)
    {
        /** @var OrderPushed $event */
        $event = unserialize($data['data'])[0];
        if ($event->order->payment_method->slug !== PaymentMethod::BANK_TRANSFER) {
            $queue->push($job, $data);
        }
    }
}
