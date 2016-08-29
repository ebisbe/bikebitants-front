<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
use Darryldecode\Cart\CartCondition;
use MongoDB\BSON\UTCDatetime;

/**
 * Class Coupon
 * @package App
 *
 * @property UTCDatetime expiry_date
 * @property integer minimum_cart
 * @property integer|null maximum_cart
 */
class Coupon extends Model
{
    const PERCENTAGE = '%';
    const DIRECT = '&euro;';

    /**
     * Add to cart conditions a valid couponName
     * @param $couponName
     * @return bool
     */
    public static function addToCart($couponName)
    {
        if(empty($couponName)) {
            return false;
        }

        $coupon = Coupon::whereName($couponName)->first();

        $condition = new CartCondition([
            'name' => $coupon->name,
            'type' => $coupon->type,
            'target' => $coupon->target,
            'value' => $coupon->value,
            'order' => 1
        ]);
        \Cart::condition($condition);

        return true;
    }
}
