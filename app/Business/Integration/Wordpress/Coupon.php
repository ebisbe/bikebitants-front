<?php

namespace App\Business\Integration\Wordpress;

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
        $coupon->type = $this->couponStatus($entity['discount_type']);
        $coupon->description = $entity['description'];
        $coupon->expired_at = $this->convertDate($entity['expiry_date']);
        $coupon->minimum_cart = (float)$entity['minimum_amount'];
        $coupon->maximum_cart = (float)$entity['maximum_amount'];

        //$coupon->limit_usage_by_coupon = 3;
        //$coupon->limit_usage_by_user = 1;
        //$coupon->single_use = 1;
        //$coupon->emails = $faker->email.','.$faker->email.','.$faker->emai;
        $coupon->save();
    }

    /**
     * Status mirroring from wp to laravel
     * @param $status
     * @return mixed
     */
    protected function couponStatus($status)
    {
        $statusTypes = [
            'fixed_cart' => AppCoupon::DIRECT,
            'fixed_product' => AppCoupon::DIRECT,
            'percent' => AppCoupon::PERCENTAGE,
            'percent_product' => AppCoupon::PERCENTAGE,
        ];

        return $statusTypes[$status];
    }
}
