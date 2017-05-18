<?php

namespace App\Listeners;

use App\Business\Repositories\ProductRepository;
use App\Order;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStockOrder implements ShouldQueue
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * Create the event listener.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($event)
    {
        $event->order->cart()->map(function ($cart) use ($event) {

            $variation = $this->productRepository->findVariationByProduct($cart->product_id, $cart->properties);

            if ($event->order->status == Order::NEW) {
                $variation->decrement('stock', $cart->quantity);
            }

            if ($event->order->status == Order::CANCELLED) {
                $variation->increment('stock', $cart->quantity);
            }
        });
    }
}
