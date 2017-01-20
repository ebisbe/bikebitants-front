<?php

namespace App\Business\Status;

use App\Country;
use App\PaymentMethod;
use Cache;
use Cart;

class NewOrder extends Status
{

    protected $country;
    protected $paymentMethod;

    public function __construct(Country $country, PaymentMethod $paymentMethod)
    {
        $this->country = $country;
        $this->paymentMethod = $paymentMethod;
    }

    public function index()
    {
        $countries = Cache::remember('countries_list', 5, function () {
            return $this->country->all()->pluck('name', '_id');
        });

        $states = Cache::remember('states_list', 5, function () {
            return $this->country->first()->states->pluck('name', '_id');
        });

        $paymentMethods = Cache::remember('payment_methods', 5, function () {
            return $this->paymentMethod->all();
        });
        $items = Cart::getContent();

        $this->setView('checkout.index');
        $this->setViewVars(compact('countries', 'states', 'items', 'paymentMethods'));
    }
}