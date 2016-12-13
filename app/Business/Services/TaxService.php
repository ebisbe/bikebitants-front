<?php

namespace App\Business\Services;

use App\Business\Models\Shop\Tax;
use App\Business\Repositories\TaxRepository;

class TaxService
{
    protected $taxRepository;

    public function __construct(TaxRepository $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getTax()
    {
        return $this->taxRepository->orderBy('order')->findAll();
    }

    /**
     * @param Float $price
     * @return string
     */
    public function applyTax(Float $price)
    {
        $rate = 0;
        $tax = $this->getTax();
        if(!$tax->isEmpty()) {
            $rate = $tax->first()->rate;
        }

        return number_format(round($price * (100 +  $rate ) / 100, 2), 2);
    }
}