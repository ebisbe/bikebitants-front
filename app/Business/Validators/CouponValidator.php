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
    private function getCoupon($attribute, $validator)
    {
        $couponName = $validator->getData()[$attribute];
        return Cache::remember('coupon_'.$attribute, 10*60, function() use ($couponName){
            return Coupon::whereName($couponName)->first();
        });
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
        $coupon = $this->getCoupon($attribute, $validator);
        $expiryDate = Carbon::createFromFormat('Y-m-d H:i:s',$coupon->expired_at);
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
        if(is_null($coupon->maximum_cart)) {
            return true;
        }
        return Cart::getSubTotal() <= $coupon->maximum_cart;
    }

}