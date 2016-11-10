<?php

namespace App\Listeners;

use App\Events\ConfirmedOrder;

class CreateOrder
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
     * @param  ConfirmedOrder  $event
     * @return void
     */
    public function handle(ConfirmedOrder $event)
    {
        //
    }
}
