<?php

namespace App\Business\Validators;

use App\Coupon;
use Carbon\Carbon;
use Cache;
use Cart;

class CouponValidator
{
    /**
     * @param $attribute
     * @param $validator
     * @return Coupon
     */
    public function getCoupon($attribute, $validator)
    {
        $couponName = strtolower($validator->getData()[$attribute]);
        return Cache::remember('coupon_'.$attribute, 10*60, function () use ($couponName) {
            return Coupon::whereName($couponName)->first();
        });
    }

    public function coupon_exists($attribute, $value, $parameters, $validator)
    {
        return !is_null($this->getCoupon($attribute, $validator)) ? true : false;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function not_expired($attribute, $value, $parameters, $validator)
    {
        return true;
        $coupon = $this->getCoupon($attribute, $validator);
        if (is_null($coupon->expired_at)) {
            return true;
        }

        $expiryDate = Carbon::createFromFormat('Y-m-d H:i:s', $coupon->expired_at);
        return Carbon::now()->diffInSeconds($expiryDate, false) > 0 ? true : false;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return mixed
     */
    public function minimum_cart($attribute, $value, $parameters, $validator)
    {
        $coupon = $this->getCoupon($attribute, $validator);
        return Cart::getSubTotal() >= $coupon->minimum_cart;
    }

    /**
 * @param $attribute
 * @param $value
 * @param $parameters
 * @param $validator
 * @return bool
 */
    public function maximum_cart($attribute, $value, $parameters, $validator)
    {
        $coupon = $this->getCoupon($attribute, $validator);
        if (is_null($coupon->maximum_cart) || $coupon->maximum_cart == 0) {
            return true;
        }
        return Cart::getSubTotal() <= $coupon->maximum_cart;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function not_repeated($attribute, $value, $parameters, $validator)
    {
        $coupon = $this->getCoupon($attribute, $validator);
        if (is_null($coupon->maximum_cart) || $coupon->maximum_cart == 0) {
            return true;
        }
        return Cart::getSubTotal() <= $coupon->maximum_cart;
    }
}
