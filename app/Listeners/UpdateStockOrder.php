<?php

namespace App\Listeners;

use App\Business\Repositories\ProductRepository;
use App\Events\CancelOrder;
use App\Events\NewOrder;
use App\Jobs\UpdateStockJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UpdateStockOrder
{
    use DispatchesJobs;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProductRepository $productRepository)
    {
        //
        $this->productRepository = $productRepository;
    }

    /**
     * Handle the event.
     *
     * @param  NewOrder|CancelOrder  $event
     * @return void
     */
    public function handle($event)
    {
        $job = (new UpdateStockJob($event->order, $this->productRepository));
        $this->dispatch($job);
    }
}
