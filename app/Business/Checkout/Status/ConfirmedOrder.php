<?php

namespace App\Business\Checkout\Status;

use App\Order;
use Cart;

class ConfirmedOrder implements Status
{
    protected $order;

    const VIEW_NAME = 'checkout.confirmation';

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $items = $this->order->cart;
        $order = $this->order;

        Cart::clear();
        Cart::clearCartConditions();

        return view(self::VIEW_NAME, compact('items', 'order'));
    }
}
