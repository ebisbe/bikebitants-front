<?php

namespace App\Business\Services;

use App\Business\Repositories\TaxRepository;

class TaxService
{
    /**
     * @return mixed
     */
    public static function getTax()
    {
        return (new TaxRepository())->orderBy('order')->get()->first();
    }

    /**
     * @param Float $price
     * @return string
     */
    public static function applyTax(Float $price)
    {
        $rate = self::getTax()->rate;
        return number_format(round($price * (100 +  $rate ) / 100, 2), 2);
    }
}