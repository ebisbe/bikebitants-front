<?php

namespace App\Business\Status;

use App\Order;
use Cart;

class ConfirmedOrder implements Status
{
    protected $order;

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

        return view('checkout.confirmation', compact('items', 'order'));
    }
}