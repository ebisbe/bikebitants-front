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
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * UpdateStockJob constructor.
     * @param Order $order
     * @param ProductRepository $productRepository
     */
    public function __construct(Order $order, ProductRepository $productRepository)
    {
        $this->order = $order;
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->order->cart()->map(function ($cart) {

            $variation = $this->productRepository->findVariationByProduct($cart->product_id, $cart->properties);

            if ($this->order->status == Order::NEW) {
                $variation->decrement('stock', $cart->quantity);
            }

            if ($this->order->status == Order::CANCELLED) {
                $variation->increment('stock', $cart->quantity);
            }
        });
    }
}
