<?php

namespace App\Business\Checkout\Status;

use App\Business\Repositories\CountryRepository;
use App\Business\Repositories\PaymentMethodRepository;
use App\Country;
use App\PaymentMethod;
use Cache;
use Cart;

class NewOrder implements Status
{

    protected $country;
    protected $paymentMethod;
    /**
     * @var PaymentMethodRepository
     */
    private $paymentMethodRepository;
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * NewOrder constructor.
     * @param Country $country
     * @param PaymentMethodRepository $paymentMethodRepository
     * @param CountryRepository $countryRepository
     * @internal param PaymentMethod $paymentMethod
     */
    public function __construct(
        Country $country,
        PaymentMethodRepository $paymentMethodRepository,
        CountryRepository $countryRepository
    ) {
        $this->country = $country;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->countryRepository = $countryRepository;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $countries = $this->countryRepository->findAll()->pluck('name', '_id');
        $paymentMethods = $this->paymentMethodRepository->findAll();
        $states = $this->states();

        $items = Cart::getContent();

        return view('checkout.index', compact('countries', 'states', 'items', 'paymentMethods'));
    }

    /**
     * @return mixed
     * @internal param $countries
     * @internal param $states
     */
    protected function states()
    {
        $states = [];
        $states_list = $this->countryRepository->findAll()->pluck('states', '_id')->toArray();
        foreach ($states_list as $country_iso => $state) {
            $states["data-$country_iso"] = json_encode($this->appendPlaceHolder($state));
        }
        return $states;
    }

    /**
     * @param $state
     * @return array
     */
    protected function appendPlaceHolder($state): array
    {
        return array_merge([['_id' => '', 'name' => trans('checkout.choose_one_state')]], $state);
    }
}
