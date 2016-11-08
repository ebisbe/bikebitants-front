<?php

namespace App\Http\Controllers;

use App\Business\Services\OrderService;
use App\Http\Middleware\CartMiddleware;
use App\Http\Middleware\CheckoutMiddleware;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware([CheckoutMiddleware::class, CartMiddleware::class]);
    }

    /**
     * @param OrderService $orderService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(OrderService $orderService)
    {
        $orderService->checkoutOrder();
        return view($orderService->getView(), $orderService->getViewVars());
    }

    /**
     * @param $oderId
     * @param OrderService $orderService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($oderId, OrderService $orderService) {
        $orderService->checkoutOrder($oderId);
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
            'billing.postal_code' => 'required',
            'billing.phone' => 'required',
            'billing.country' => 'required',
            'billing.province' => 'required',

            'shipping.first_name' => 'required_without:check_shipping',
            'shipping.email' => 'required_without:check_shipping',
            'shipping.last_name' => 'required_without:check_shipping',
            'shipping.address' => 'required_without:check_shipping',
            'shipping.city' => 'required_without:check_shipping',
            'shipping.postal_code' => 'required_without:check_shipping',
            'shipping.phone' => 'required_without:check_shipping',
            'shipping.country' => 'required_without:check_shipping',
            'shipping.province' => 'required_without:check_shipping',

            'payment' => 'required',
            'checkout-terms-conditions' => 'required',

            'coupon' => 'bail|present|exists:coupons,name|not_expired|minimum_cart|maximum_cart'
        ]);

        $orderService->pay();

        return redirect(route('checkout.index'));
    }

    public function cancel(OrderService $orderService)
    {
        $orderService->cancel();
        return redirect(route('cart.index'));
    }
}
