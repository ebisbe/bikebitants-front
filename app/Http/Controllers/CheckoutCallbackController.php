<?php

namespace App\Http\Controllers;

use App\Business\Checkout\CheckoutOrder;
use App\Order;
use Illuminate\Http\Request;

/**
 * Class CheckoutCallbackController
 * @package App\Http\Controllers
 */
class CheckoutCallbackController extends Controller
{
    /**
     * @var CheckoutOrder
     */
    protected $orderService;

    /**
     * @var Request
     */
    protected $request;

    /**
     * CheckoutController constructor.
     * @param CheckoutOrder $orderService
     * @param Request $request
     */
    public function __construct(CheckoutOrder $orderService, Request $request)
    {
        $this->orderService = $orderService;
        $this->request = $request;
    }

    public function callback()
    {
        \Log::debug(\Request::getContent());
        $info = json_decode(\Request::getContent(), true);
        if (empty($info['data']['order_id'])) {
            abort(400, 'Missing order_id in the request');
        }

        $order = Order::whereToken((int)$info['data']['order_id'])->first();
        $this->orderService->setOrderAndUpdate($order);
        $this->orderService->setPaymentType($order->payment_method->slug);
        $this->orderService->confirmPayment();

        return ['response' => true];
    }
}
