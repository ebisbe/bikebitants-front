<?php
namespace App\Business\Repositories;

use App\Business\Models\Shop\Coupon;
use App\Cart;
use Rinvex\Repository\Repositories\EloquentRepository;

class CouponRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.coupon';

    protected $model = 'App\Business\Models\Shop\Coupon';

    /**
     * Add to cart conditions a valid couponName
     * @param $couponName
     * @return array
     */
    public function addToCart($couponName)
    {
        if (empty($couponName)) {
            return [];
        }

        $coupon = $this->createModel()->whereName($couponName)->first();

        return [
            'name' => $coupon->name,
            'type' => Coupon::CART_CONDITION_TYPE,
            'target' => Cart::CART_CONDITION_TARGET_ITEM,
            'value' => $coupon->value,
            'order' => 1
        ];
    }
}