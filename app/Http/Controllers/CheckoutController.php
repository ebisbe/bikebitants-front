<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Country;
use App\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use \Omnipay;

class CheckoutController extends Controller
{
    public function index(Country $country, PaymentMethod $paymentMethod, Cart $cart)
    {
        $countries = Cache::remember('countries_list', 5, function () use ($country) {
            return $country->all()->pluck('name', '_id');
        });

        $paymentMethods = Cache::remember('payment_methods', 5, function () use ($paymentMethod) {
            return $paymentMethod->all();
        });

        $cart = $cart->with('product.brand')->get();
        return view('checkout.index', compact('countries', 'cart', 'paymentMethods'));
    }

    public function store(Request $request, Cart $cart)
    {
        //dd($request);
        $this->validate($request, [
            'billing.first_name' => 'required',
            'billing.last_name' => 'required',
            'billing.email' => 'required',
            'billing.address' => 'required',
            'billing.city' => 'required',
            'billing.postal_code' => 'required',
            'billing.phone' => 'required',
            'billing.country' => 'required',

            'shipping.first_name' => 'required_without:check_shipping',
            'shipping.email' => 'required_without:check_shipping',
            'shipping.last_name' => 'required_without:check_shipping',
            'shipping.address' => 'required_without:check_shipping',
            'shipping.city' => 'required_without:check_shipping',
            'shipping.postal_code' => 'required_without:check_shipping',
            'shipping.phone' => 'required_without:check_shipping',
            'shipping.country' => 'required_without:check_shipping',

            'payment' => 'required',
            'checkout-terms-conditions' => 'required'
        ]);

        Omnipay::setGateway($request->input('payment'));
        $gateway = Omnipay::gateway();
        //dd(Omnipay::getDefaultParameters());

        //$formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2016', 'cvv' => '123');
        $params = [
            'amount' => number_format($cart->all()->sum('subtotal'), 2),
            'currency' => 'EUR',
            'returnUrl' => route('checkout.confirmation'),
            'cancelUrl' => route('checkout.cancellation'),
            //'card' => $formData,
        ];
        $request->session()->put('payment', $request->input('payment'));
        $request->session()->put('params', $params);
        $request->session()->save();
        $response = $gateway->purchase($params)->send();

        if ($response->isSuccessful()) {
            // payment was successful: update database
            print_r($response);
        } elseif ($response->isRedirect()) {
            // redirect to offsite payment gateway
            $response->redirect();
        } else {
            // payment failed: display message to customer
            echo $response->getMessage();
        }
    }

    public function confirmation(Request $request)
    {
        Omnipay::setGateway($request->session()->get('payment'));
        $response = Omnipay::completePurchase(array_merge($request->all(), $request->session()->get('params', [])))->send();

        $items = Cart::with('product.brand')->get();
        $discount = 0;

        return view('checkout.confirmation', compact('items', 'discount'));
    }

    public function cancel()
    {

    }
}
