<?php

namespace App\Http\Controllers\Api;

use App\Shipping;
use App\Zone;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Cart;
use App\Cart as CartModel;

use App\Http\Requests;

class CartConditionsController extends ApiController
{
    /**
     * @return array
     */
    public function index()
    {
        return $this->cartResponse();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'region' => 'required|exists:zones,region'
        ]);

        //Remove cart condition before checking for total of cart because result will be not correct
        Cart::removeConditionsByType('shipping');

        /** @var Zone $zone */
        $zone = Zone::whereIn('region', [$request->input('region')])->first();
        $shippingMethod = $zone->shippingMethods()
            ->sortByDesc('price_condition')
            ->filter(function ($item) {
                return Cart::getTotal() >= $item->price_condition;
            })
            ->shift();

        $condition = new CartCondition([
            'name' => $shippingMethod->name,
            'type' => Shipping::CART_CONDITION_TYPE,
            'target' => CartModel::CART_CONDITION_TARGET_SUBTOTAL,
            'value' => number_format($shippingMethod->cost, 2) . ' &euro;',
            'order' => 4
        ]);
        Cart::condition($condition);

        return $this->cartResponse();
    }

    /**
     * @return array
     */
    private function cartResponse()
    {
        $conditions = Cart::getConditions()
            ->map(function ($item, $key) {
                /** @var CartCondition $item */
                return [
                    'name' => $item->getName(),
                    'value' => $item->getValue()
                ];
            })->values();

        return array_merge(
            //[['name' => trans('checkout.total_products'), 'value' => Cart::getSubTotal() . ' &euro;']],
            $conditions->toArray(),
            [['name' => trans('checkout.total'), 'value' => Cart::getTotal() . ' &euro;']]
        );
    }
}
