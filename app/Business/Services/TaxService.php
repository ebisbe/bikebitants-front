<?php

namespace App\Business\Services;

use App\Business\Models\Shop\Tax;
use App\Business\Repositories\TaxRepository;
use App\Exceptions\TaxNotFoundException;

class TaxService
{
    protected $taxRepository;

    public function __construct(TaxRepository $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * @return mixed
     * @throws TaxNotFoundException
     */
    public function getTax()
    {
        $tax = $this->taxRepository->orderBy('order')->findAll();
        if ($tax->isEmpty()) {
            throw new TaxNotFoundException('Tax not found.');
        }
        return $tax->first();
    }

    /**
     * @param Float $price
     * @return string
     */
    public function applyTax(Float $price)
    {
        $tax = $this->getTax();
        return number_format(round($price * (100 +  $tax->rate ) / 100, 2), 2);
    }
}
