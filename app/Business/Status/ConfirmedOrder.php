<?php

namespace App\Business\Status;

use App\Order;
use Cart;

class ConfirmedOrder extends Status
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $items = $this->order->cart;
        $order = $this->order;

        Cart::clear();
        Cart::clearCartConditions();

        $this->setView('checkout.confirmation');
        $this->setViewVars(compact('items', 'order'));
    }
}