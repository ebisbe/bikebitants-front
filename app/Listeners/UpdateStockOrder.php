<?php

namespace App\Listeners;

use App\Business\Checkout\Events\Create;
use App\Business\Repositories\ProductRepository;
use App\Cart;
use App\Variation;
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
        $event
            ->order
            ->cart()
            ->each(function (Cart $cart) use ($event) {
                /** @var Variation $variation */
                $variation = $this->productRepository->findVariationByProduct($cart->product_id, $cart->properties);
                $variation->updateStock($cart->quantity, $event->order->status);
            });
    }
}
