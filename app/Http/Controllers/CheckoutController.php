<?php

namespace App\Http\Controllers;

use App\Business\Checkout\CheckoutOrder;
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
        $this->orderService->setUserAgent($this->request->header('user-agent'));

        $order = $this->orderService->checkoutOrder();

        $this->request->session()->put('order', $this->orderService->getToken());
        return $order->index();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $this->validate($this->request, [
            'shipping.first_name' => 'required',
            'shipping.email' => 'required|email',
            'shipping.last_name' => 'required',
            'shipping.address_1' => 'required',
            'shipping.city' => 'required',
            'shipping.postcode' => 'required',
            'shipping.phone' => 'required|digits_between:9,13',
            'shipping.country' => 'required',
            'shipping.state' => 'required',

            'billing.first_name' => 'required_without:check_billing',
            'billing.last_name' => 'required_without:check_billing',
            'billing.email' => 'required_without:check_billing|nullable|email',
            'billing.address_1' => 'required_without:check_billing',
            'billing.city' => 'required_without:check_billing',
            'billing.postcode' => 'required_without:check_billing',
            'billing.phone' => 'required_without:check_billing|nullable|digits_between:9,13',
            'billing.country' => 'required_without:check_billing',
            'billing.state' => 'required_without:check_billing',

            'payment' => 'required',
            'checkout-terms-conditions' => 'required',

            'coupon' => 'bail|nullable|coupon_exists|not_expired|minimum_cart|maximum_cart'
        ]);

        $currentOrder = Order::currentOrder()->get();
        if (!$currentOrder->isEmpty()) {
            $this->orderService->setOrderAndUpdate($currentOrder->first());
        }

        $this->orderService->setPaymentType($this->request->input('payment'));
        $this->orderService->setFormParams($this->request->all());
        $this->orderService->setCoupon($this->request->input('coupon'));

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
