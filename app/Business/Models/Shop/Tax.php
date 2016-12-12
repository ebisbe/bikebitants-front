<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\GeoIpTrait;

/**
 * Class Tax
 * @package App\Business\Models\Shop
 *
 * @property string $name
 * @property float $rate
 */
class Tax extends \App\Tax
{
    use GeoIpTrait;
}