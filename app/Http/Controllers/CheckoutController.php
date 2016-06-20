<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Country;
use App\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Omnipay\Omnipay;

class CheckoutController extends Controller
{
    public function index()
    {
        $countries = Cache::remember('countries_list', 5, function () {
            return Country::all()->pluck('name', '_id');
        });

        $paymentMethods = Cache::remember('payment_methods', 5, function () {
            return PaymentMethod::all();
        });

        $cart = Cart::with('product.brand')->get();
        return view('checkout.index', compact('countries', 'cart', 'paymentMethods'));
    }

    public function store(Request $request)
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

            'payment' => 'required'
        ]);


        $gateway = Omnipay::create('PayPal_Express');

        $formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2016', 'cvv' => '123');
        $response = $gateway->purchase([
            'amount' => '10.00',
            'currency' => 'USD',
            'card' => $formData,
            'returnUrl' => env('APP_URL') . '/confirmation',
            'cancelUrl' => env('APP_URL') . '/cancel',
            'username' => 'miguel-facilitator_api1.bikebitants.com',
            'password' => 'W5JLH95872M8F4UB',
            'signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AqhU.JcFYXI2hr-gd0RFTwI1sknm',
            "testMode" => true,
            "brandName" => "Bikebitants",
            "headerImageUrl" => "",
            "logoImageUrl" => "",
            "borderColor" => "",
        ])->send();

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
}
