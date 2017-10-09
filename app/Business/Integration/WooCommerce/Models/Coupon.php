<?php

namespace App\Business\Integration\WooCommerce\Models;

use App\Cart;

/**
 * Class Tag
 * @package App\Business\Integration\WooCommerce\Models
 *
 * @method whereExternalId($id)
 */
class Coupon extends ApiImporter
{
    public $wooCommerceCallback = 'coupons';

    const CART_CONDITION_TYPE = 'coupon';

    const PERCENTAGE = '%';
    const DIRECT = '&euro;';

    protected $fillable = [
        'name',
        'value',
        'magnitude',
        'type',
        'target',
        'expired_at',
        'minimum_cart',
        'maximum_cart',
        'limit_usage_by_coupon',
        'limit_usage_by_user',
        'exclude_sale_items',
        'single_use',
        'emails',
        'external_id'
    ];

    protected $dates = ['created_at', 'updated_at', 'expired_at'];

    protected $casts = [
        'single_use' => 'boolean',
        'minimum_cart' => 'float',
        'maximum_cart' => 'float',
        'exclude_sale_items' => 'float'
    ];

    public function sync($entity)
    {
        $entity['name'] = $entity['code'];
        $entity['type'] = $this->couponStatus($entity);
        $entity['target'] = $this->couponTarget($entity);
        $entity['magnitude'] = -(float)$entity['amount'];
        $entity['expired_at'] = $this->convertDate($entity['date_expires']);
        $entity['minimum_cart'] = $entity['minimum_amount'];
        $entity['maximum_cart'] = $entity['maximum_amount'];
        $entity['exclude_sale_items'] = $entity['exclude_sale_items'];

        $this->fill($entity);
    }

    /**
     * Status mirroring from wp to laravel
     * @param $entity
     * @return mixed
     */
    protected function couponStatus($entity)
    {
        // Entity['type'] is from old API Version
        $status = $entity['discount_type'] ?? $entity['type'];

        $statusTypes = [
            'fixed_cart' => self::DIRECT,
            'fixed_product' => self::DIRECT,
            'percent' => self::PERCENTAGE,
            'percent_product' => self::PERCENTAGE,
        ];

        return $statusTypes[$status];
    }

    private function couponTarget($entity)
    {
        return $entity['discount_type'] == 'fixed_cart'
            ? Cart::CART_CONDITION_TARGET_SUBTOTAL : Cart::CART_CONDITION_TARGET_ITEM;
    }
}
