<?php

namespace App;

use MongoDB\BSON\UTCDatetime;

/**
 * Class Coupon
 * @package App
 *
 * @property integer external_id
 * @property string name
 * @property float magnitude
 * @property string value
 * @property string type
 * @property string description
 * @property UTCDatetime expired_at
 * @property integer minimum_cart
 * @property integer|null maximum_cart
 * @property array type_options
 * @property string email_list
 * @property boolean exclude_sale_items
 */
class Coupon extends \App\Business\Integration\WooCommerce\Models\Coupon
{

    /**
     * Set the user's first name.
     *
     * @param  string $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public static function boot()
    {
        parent::boot();

        Coupon::saving(function ($coupon) {
            if (!empty($coupon->emails) && !is_array($coupon->emails)) {
                $coupon->emails = explode(',', $coupon->emails);
            }
            $coupon->value = "{$coupon->magnitude}{$coupon->type}";
            return $coupon;
        });
    }

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
     * Return type options for a coupon
     * @return array
     */
    public static function typeOptions()
    {
        return (new Coupon())->type_options;
    }

    public function getNameAttribute($name)
    {
        $asterisk = '';
        if ($this->exclude_sale_items) {
            $asterisk = '* ';
        }

        return $asterisk . $name;
    }
}
