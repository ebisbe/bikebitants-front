<?php

namespace App\Http\Controllers\Api;

use App\Business\Services\ShippingMethodService;
use App\Shipping;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Cart;
use App\Cart as CartModel;

use App\Http\Requests;

class CartConditionsController extends ApiController
{
    protected $shippingMethodService;

    public function __construct(ShippingMethodService $shippingMethodService)
    {
        $this->shippingMethodService = $shippingMethodService;
    }

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
            'state' => 'required|exists:zones,state'
        ]);

        //Remove cart condition before checking for total of cart because result will be not correct
        Cart::removeConditionsByType('shipping');

        $shippingMethod = $this->shippingMethodService
            ->getFromState($request->input('state'), Cart::getTotal());

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
            ->map(function ($item) {
                /** @var CartCondition $item */
                return [
                    'name' => $item->getName(),
                    'value' => $item->getValue()
                ];
            })->values();

        return array_merge(
            $conditions->toArray(),
            [['name' => trans('checkout.total'), 'value' => Cart::getTotal() . ' &euro;']]
        );
    }
}
