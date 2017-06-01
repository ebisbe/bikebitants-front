<?php

namespace App\Listeners;

use App\Business\Checkout\Events\Confirm;
use App\Business\Deliverea\Shipment;
use App\Events\OrderPushed;
use Illuminate\Queue\InteractsWithQueue;
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
}
