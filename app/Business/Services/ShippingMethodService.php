<?php

namespace App\Business\Services;

use App\ShippingMethod;
use App\Zone;

class ShippingMethodService
{
    /**
     * @param string $state
     * @param float $total
     * @return ShippingMethod
     */
    public function getFromState(string $state, float $total)
    {
        /** @var Zone $zone */
        $zone = Zone::inState($state)->first();

        $shippingMethod = $this->filterByPriceCondition($zone, $total);

        return $shippingMethod;
    }

    /**
     * @param Zone $zone
     * @param float $total
     * @return mixed
     */
    public function filterByPriceCondition(Zone $zone, float $total)
    {
        return $zone->shipping_methods()
            ->sortByDesc('price_condition')
            ->filter(function ($item) use ($total) {
                return $total >= $item->price_condition;
            })
            ->shift();
    }
}
