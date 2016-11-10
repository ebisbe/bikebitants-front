<?php

namespace App\Listeners;

use App\Events\CancelOrder;
use App\Events\NewOrder;
use App\Jobs\UpdateStockJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UpdateStockOrder
{
    use DispatchesJobs;

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
     * @param  NewOrder|CancelOrder  $event
     * @return void
     */
    public function handle($event)
    {
        $job = (new UpdateStockJob($event->order));
        $this->dispatch($job);
    }
}
