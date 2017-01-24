<?php

namespace App\Listeners;

use App\Business\Services\WordpressService;
use App\Events\ConfirmedOrder;

class CreateOrder
{
    protected $wordpressService;

    /**
     * CreateOrder constructor.
     * @param WordpressService $wordpressService
     */
    public function __construct(WordpressService $wordpressService)
    {
        $this->wordpressService = $wordpressService;
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
            $this->wordpressService->createOrder($event->order);
        }
    }
}
