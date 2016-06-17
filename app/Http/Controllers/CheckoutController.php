<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Country;
use App\PaymentMethod;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;

class CheckoutController extends Controller
{
    public function index()
    {
        $countries = Cache::remember('countries_list', 5, function() {
            return Country::all()->pluck('name', '_id');
        });

        $paymentMethods = Cache::remember('payment_methods', 5, function(){
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
            'billing.email' => 'required',
            'billing.password' => 'required',
            'billing.last_name' => 'required',
            'billing.address' => 'required',
            'billing.city' => 'required',
            'billing.postal_code' => 'required',
            'billing.phone' => 'required',
            'billing.country' => 'required',

            'shipping.first_name' => 'required_without:check_shipping',
            'shipping.email' => 'required_without:check_shipping',
            'shipping.password' => 'required_without:check_shipping',
            'shipping.last_name' => 'required_without:check_shipping',
            'shipping.address' => 'required_without:check_shipping',
            'shipping.city' => 'required_without:check_shipping',
            'shipping.postal_code' => 'required_without:check_shipping',
            'shipping.phone' => 'required_without:check_shipping',
            'shipping.country' => 'required_without:check_shipping',

            'payment' => 'required'
        ]);
    }
}
