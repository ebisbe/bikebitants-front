<?php

namespace App\Http\Controllers;

use App\Business\Services\CheckoutOrderService;
use App\Http\Middleware\CheckoutMiddleware;
use App\Order;
use Illuminate\Http\Request;

/**
 * Class CheckoutController
 * @package App\Http\Controllers
 */
class CheckoutController extends Controller
{
    /**
     * @var CheckoutOrderService
     */
    protected $orderService;

    /**
     * @var Request
     */
    protected $request;

    /**
     * CheckoutController constructor.
     * @param CheckoutOrderService $orderService
     * @param Request $request
     */
    public function __construct(CheckoutOrderService $orderService, Request $request)
    {
        $this->middleware([CheckoutMiddleware::class]);

        $this->orderService = $orderService;
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $currentOrder = Order::currentOrder()->get();
        if (!$currentOrder->isEmpty()) {
            $order = $currentOrder->first();
            $this->orderService->setOrderAndUpdate($order);
            if (!empty($order->payment_method)) {
                $this->orderService->setPaymentType($order->payment_method->slug);
            }
        }
        $this->orderService->setSessionId($this->request->session()->getId());

        $order = $this->orderService->checkoutOrder();

        $this->request->session()->set('order', $this->orderService->getToken());
        return $order->index();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $this->validate($this->request, [
            'billing.first_name' => 'required',
            'billing.last_name' => 'required',
            'billing.email' => 'required',
            'billing.address_1' => 'required',
            'billing.city' => 'required',
            'billing.postcode' => 'required',
            'billing.phone' => 'required',
            'billing.country' => 'required',
            'billing.state' => 'required',

            'shipping.first_name' => 'required_without:check_shipping',
            'shipping.email' => 'required_without:check_shipping',
            'shipping.last_name' => 'required_without:check_shipping',
            'shipping.address_1' => 'required_without:check_shipping',
            'shipping.city' => 'required_without:check_shipping',
            'shipping.postcode' => 'required_without:check_shipping',
            'shipping.phone' => 'required_without:check_shipping',
            'shipping.country' => 'required_without:check_shipping',
            'shipping.state' => 'required_without:check_shipping',

            'payment' => 'required',
            'checkout-terms-conditions' => 'required',

            'coupon' => 'bail|present|exists:coupons,name|not_expired|minimum_cart|maximum_cart'
        ]);

        $currentOrder = Order::currentOrder()->get();
        if (!$currentOrder->isEmpty()) {
            $this->orderService->setOrderAndUpdate($currentOrder->first());
        }

        $this->orderService->setPaymentType($this->request->input('payment'));
        $this->orderService->setFormParams($this->request->all());
        $this->orderService->setCoupon($this->request->input('coupon', ''));

        /** Posible redirection inside pay() method. It depends on the gateway used. */
        $this->orderService->pay();

        return redirect(route('checkout.index'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cancel()
    {
        $currentOrder = Order::currentOrder()->get();
        if (!$currentOrder->isEmpty()) {
            $this->orderService->setOrderAndUpdate($currentOrder->first());
        }

        $this->orderService->cancel(trans('checkout.order_cancelled_by_user'));
        $this->request->session()->remove('order');
        return redirect(route('cart.index'));
    }
}
