<?php

namespace App\Http\Controllers;

use App\Business\Services\OrderService;

class CheckoutCallbackController extends Controller
{
    /**
      * @param OrderService $orderService
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
    public function store(OrderService $orderService)
    {
        $orderService->setPaymentType('redsys');
        $orderService->checkoutCallback();
        return 'true';
    }

}
