<?php

namespace App\Business\Status;


class CancelledOrder extends Status
{

    public function index()
    {
        $message = $this->order->error_message ? $this->order->error_message : trans('checkout.order_cancelled');

        $this->setView('checkout.cancel');
        $this->setViewVars(compact('message'));
    }
}