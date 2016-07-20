<?php

namespace App\Http\Controllers;

use App\Business\Services\OrderService;
use App\Cart;
use App\Country;
use App\PaymentMethod;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use \Omnipay;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkout');
    }

    /**
     * @param Country $country
     * @param PaymentMethod $paymentMethod
     * @param OrderService $orderService
     * @param Cart $cart
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Country $country, PaymentMethod $paymentMethod, OrderService $orderService, Cart $cart, Request $request)
    {
        $orderService->getOrder($request);

        $countries = Cache::remember('countries_list', 5, function () use ($country) {
            return $country->all()->pluck('name', '_id');
        });

        $provinces = Cache::remember('provinces_list', 5, function () use ($country) {
            return $country->first()->provinces->pluck('name', '_id');
        });

        $paymentMethods = Cache::remember('payment_methods', 5, function () use ($paymentMethod) {
            return $paymentMethod->all();
        });
        $discount = 0;
        $products = $orderService->getCart()->with('product.brand')->get();
        return view('checkout.index', compact('countries', 'provinces', 'products', 'paymentMethods', 'discount'));
    }

    /**
     * @param Request $request
     * @param Cart $cart
     * @param OrderService $orderService
     * @param User $user
     */
    public function store(Request $request, OrderService $orderService, User $user)
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
            'checkout-terms-conditions' => 'required'
        ]);

        $response = $orderService->pay($request);
    }

    /**
     * @param Request $request
     * @param OrderService $orderService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmation(Request $request, OrderService $orderService)
    {
        $orderService->confirmPayment($request);

        $items = $orderService->getCart()->with('product.brand')->get();
        $discount = 0;

        $order = $orderService->getOrder($request);

        return view('checkout.confirmation', compact('items', 'discount', 'order'));
    }

    public function cancel()
    {
        // TODO on anem??
        return view('checkout.cancel');
    }
}
