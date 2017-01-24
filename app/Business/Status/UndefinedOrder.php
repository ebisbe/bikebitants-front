<?php

namespace App\Business\Status;

use App\Order;

class UndefinedOrder implements Status
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('checkout.error', ['message' => $this->order->message]);
    }
}
