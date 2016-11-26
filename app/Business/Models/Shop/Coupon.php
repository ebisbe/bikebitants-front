<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\LastCouponTrait;
use App\Cart;

class Coupon extends \App\Coupon
{
    use LastCouponTrait;

    /**
     * Add to cart conditions a valid couponName
     * @param $couponName
     * @return array
     */
    public static function addToCart($couponName)
    {
        if (empty($couponName)) {
            return [];
        }

        $coupon = Coupon::whereName($couponName)->first();

        return [
            'name' => $coupon->name,
            'type' => Coupon::CART_CONDITION_TYPE,
            'target' => Cart::CART_CONDITION_TARGET_ITEM,
            'value' => $coupon->value,
            'order' => 1
        ];
    }
}