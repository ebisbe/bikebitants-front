<?php

namespace App\Business\Services;

use App\Business\Repositories\CouponRepository;
use App\Coupon;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use \Cart;
use Illuminate\Support\Collection;

class CouponService {

    public $couponRepository;

    /**
     * CouponService constructor.
     * @param CouponRepository $couponRepository
     */
    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * @param string $name
     * @return bool|Collection
     */
    public function addCoupon($name)
    {
        $response = Cart::getContent()
            ->map(function ($item) use ($name) {
                $coupon = $this->createCoupon($name);
                return Cart::addItemCondition($item->id, $coupon);
            })
            ->unique();
        // Add condition to cart only to show it on the subtotal. We add it to every item because of how
        //woocommerce works with discounts.
        $coupon = $this->createCoupon($name);
        Cart::condition($coupon);
        return $response;
    }

    /**
     * Returns a coupon formatted as
     * @param string $couponName
     * @return CartCondition
     */
    private function createCoupon(string $couponName)
    {
        $coupon = $this->couponRepository->whereName($couponName)->first();

        return new CartCondition([
            'name' => $coupon->name,
            'type' => Coupon::CART_CONDITION_TYPE,
            'target' => \App\Cart::CART_CONDITION_TARGET_ITEM,
            'value' => $coupon->value,
            'order' => 1
        ]);
    }
}