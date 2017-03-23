<?php

namespace App\Business\Checkout\Status;

use App\Order;

class CancelledOrder implements Status
{
    /**
     * @var Order
     */
    private $order;

    /**
     * CancelledOrder constructor.
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
        $message = $this->order->error_message ? $this->order->error_message : trans('checkout.order_cancelled');

        return view('checkout.cancel', compact('message'));
    }
}
