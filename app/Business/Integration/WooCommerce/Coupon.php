<?php

namespace App\Business\Integration\WooCommerce;

use App\Coupon as AppCoupon;

class Coupon extends Importer
{
    public $wooCommerceCallback = 'coupons';

    public function sync($entity)
    {
        /** @var AppCoupon $coupon */
        $coupon = AppCoupon::whereExternalId($entity['id'])->first();
        if (empty($coupon)) {
            $coupon = new AppCoupon();
        }

        $coupon->external_id = $entity['id'];
        $coupon->name = $entity['code'];
        $coupon->magnitude = -(float)$entity['amount'];
        $coupon->type = $this->couponStatus($entity);
        $coupon->description = $entity['description'];
        $coupon->expired_at = $this->convertDate($entity['expiry_date'], false);
        $coupon->minimum_cart = (float)$entity['minimum_amount'];
        $coupon->maximum_cart = (float)$entity['maximum_amount'];

        //$coupon->limit_usage_by_coupon = 3;
        //$coupon->limit_usage_by_user = 1;
        //$coupon->single_use = 1;
        //$coupon->emails = $faker->email.','.$faker->email.','.$faker->emai;
        return $coupon->save();
    }

    public function delete(int $id):bool
    {
        return AppCoupon::whereExternalId($id)->delete();
    }

    /**
     * Status mirroring from wp to laravel
     * @param $entity
     * @return mixed
     */
    protected function couponStatus($entity)
    {
        $status = isset($entity['discount_type']) ? $entity['discount_type'] : $entity['type'];

        $statusTypes = [
            'fixed_cart' => AppCoupon::DIRECT,
            'fixed_product' => AppCoupon::DIRECT,
            'percent' => AppCoupon::PERCENTAGE,
            'percent_product' => AppCoupon::PERCENTAGE,
        ];

        return $statusTypes[$status];
    }
}
