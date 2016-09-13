<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
use Darryldecode\Cart\CartCondition;
use MongoDB\BSON\UTCDatetime;

/**
 * Class Coupon
 * @package App
 *
 * @property UTCDatetime expired_at
 * @property integer minimum_cart
 * @property integer|null maximum_cart
 * @property array type_options
 * @property string email_list
 */
class Coupon extends Model
{
    const CART_CONDITION_TYPE = 'coupon';
    const CART_CONDITION_TARGET = 'subtotal';

    const PERCENTAGE = '%';
    const DIRECT = '&euro;';

    protected $fillable = ['name', 'value', 'magnitude', 'type', 'expired_at', 'minimum_cart', 'maximum_cart', 'limit_usage_by_coupon', 'limit_usage_by_user', 'single_use', 'emails'];

    protected $dates = ['created_at', 'updated_at', 'expired_at'];

    protected $casts = [
        'single_use' => 'boolean',
    ];

    /**
     * Array list of coupon types
     * @return array
     */
    public function getTypeOptionsAttribute()
    {
        return [self::DIRECT => self::DIRECT, self::PERCENTAGE => self::PERCENTAGE];
    }
    /**
     * Array list of coupon types
     * @return array
     */
    public function getEmailsListAttribute()
    {
        return implode(',', $this->emails);
    }

    /**
     * Add to cart conditions a valid couponName
     * @param $couponName
     * @return bool
     */
    public static function addToCart($couponName)
    {
        if (empty($couponName)) {
            return false;
        }

        $coupon = Coupon::whereName($couponName)->first();

        $condition = new CartCondition([
            'name' => $coupon->name,
            'type' => Coupon::CART_CONDITION_TYPE,
            'target' => Coupon::CART_CONDITION_TARGET,
            'value' => $coupon->value,
            'order' => 1
        ]);
        \Cart::condition($condition);

        return true;
    }

    /**
     * Return type options for a coupon
     * @return array
     */
    public static function TypeOptions()
    {
        return (new Coupon())->type_options;
    }
}