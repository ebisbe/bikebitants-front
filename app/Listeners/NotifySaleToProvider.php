<?php

namespace App\Listeners;

use App\Business\Checkout\Events\Confirm;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySaleToProvider implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Confirm $event
     * @return void
     */
    public function handle(Confirm $event)
    {
        $event->order->cart()->each(function ($product) {
            //Provider
            $email = $product->product->drop_shipping;
            if(!is_null($email)) {

            }
            //Shipping method

        });
    }
}
