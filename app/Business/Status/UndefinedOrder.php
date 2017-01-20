<?php

namespace App\Business\Status;


use App\Order;

class UndefinedOrder extends Status
{
    /**
     * @var Order
     */
    private $order;

    /**
     * UndefinedOrder constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $this->setView('checkout.error');
        $this->setViewVars(['message' => $this->order->message]);
    }
}