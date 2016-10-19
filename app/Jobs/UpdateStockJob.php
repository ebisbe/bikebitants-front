<?php

namespace App\Jobs;

use App\Business\Repositories\ProductRepository;
use App\Order;
use App\Variation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStockJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var  Order $order */
    protected $order;

    /**
     * UpdateStockJob constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->order->cart()->map(function ($cart) {
            /** @var Variation $variation */
            $variation = (new ProductRepository())->findBy('_id', $cart->product_id)
                ->productVariation(array_merge([$cart->product_id], $cart->attributes));
            if ($this->order->status == Order::New) {
                $variation->decrement('stock', $cart->quantity);
            }

            if ($this->order->status == Order::Cancelled) {
                $variation->increment('stock', $cart->quantity);
            }
        });
    }
}
