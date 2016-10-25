<?php

namespace App\Business\Services;

use App\Business\Repositories\TaxRepository;

class TaxService
{
    /**
     * @param Float $price
     * @return string
     */
    public static function applyTax(Float $price)
    {
        $rate = (new TaxRepository())->orderBy('order')->get()->first()->rate;
        return number_format(round($price * (100 +  $rate ) / 100, 2), 2);
    }
}