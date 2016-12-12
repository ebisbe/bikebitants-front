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
     * @return Tax
     */
    public function getTax()
    {
        return $this->taxRepository->orderBy('order')->findAll()->first();
    }

    /**
     * @param Float $price
     * @return string
     */
    public function applyTax(Float $price)
    {
        $rate = $this->getTax()->rate;
        return number_format(round($price * (100 +  $rate ) / 100, 2), 2);
    }
}