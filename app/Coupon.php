<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
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

    const PERCENTAGE = '%';
    const DIRECT = '&euro;';

    protected $fillable = [
        'name',
        'value',
        'magnitude',
        'type',
        'expired_at',
        'minimum_cart',
        'maximum_cart',
        'limit_usage_by_coupon',
        'limit_usage_by_user',
        'single_use',
        'emails',
        'external_id'
    ];

    protected $dates = ['created_at', 'updated_at', 'expired_at'];

    protected $casts = [
        'single_use' => 'boolean',
    ];

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
}
