<?php

namespace App\Http\Controllers;

use App\Business\Services\OrderService;
use App\Http\Middleware\CheckoutMiddleware;
use App\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware([CheckoutMiddleware::class]);
    }

    /**
     * @param OrderService $orderService
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(OrderService $orderService, Request $request)
    {
        if(!Order::currentOrder()->isEmpty()) {
            $order = Order::currentOrder()->first();
            $orderService->setOrder($order);
            if(!empty($order->payment_method)) {
                $orderService->setPaymentType($order->payment_method->code);
            }
        }
        $orderService->setSessionId($request->session()->getId());

        $orderService->checkoutOrder();

        $request->session()->set('order', $orderService->getToken());

        return view($orderService->getView(), $orderService->getViewVars());
    }

    /**
     * @param Request $request
     * @param OrderService $orderService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, OrderService $orderService)
    {
        $this->validate($request, [
            'billing.first_name' => 'required',
            'billing.last_name' => 'required',
            'billing.email' => 'required',
            'billing.address' => 'required',
            'billing.city' => 'required',
            'billing.postcode' => 'required',
            'billing.phone' => 'required',
            'billing.country' => 'required',
            'billing.province' => 'required',

            'shipping.first_name' => 'required_without:check_shipping',
            'shipping.email' => 'required_without:check_shipping',
            'shipping.last_name' => 'required_without:check_shipping',
            'shipping.address' => 'required_without:check_shipping',
            'shipping.city' => 'required_without:check_shipping',
            'shipping.postcode' => 'required_without:check_shipping',
            'shipping.phone' => 'required_without:check_shipping',
            'shipping.country' => 'required_without:check_shipping',
            'shipping.province' => 'required_without:check_shipping',

            'payment' => 'required',
            'checkout-terms-conditions' => 'required',

            'coupon' => 'bail|present|exists:coupons,name|not_expired|minimum_cart|maximum_cart'
        ]);

        if(!Order::currentOrder()->isEmpty()) {
            $orderService->setOrder(Order::currentOrder()->first());
        }

        $orderService->setPaymentType($request->input('payment'));
        $orderService->setFormParams($request->all());
        $orderService->setCoupon($request->input('coupon', ''));

        /** Posible redirection inside pay() method. It depends on the gateway used. */
        $orderService->pay();

        return redirect(route('checkout.index'));
    }

    public function cancel(OrderService $orderService, Request $request)
    {
        if(!Order::currentOrder()->isEmpty()) {
            $orderService->setOrder(Order::currentOrder()->first());
        }

        $orderService->cancel();
        $request->session()->remove('order');
        return redirect(route('cart.index'));
    }
}
