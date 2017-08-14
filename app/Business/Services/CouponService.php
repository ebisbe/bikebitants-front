<?php

namespace App\Business\Services;

use App\Business\Models\Shop\Product;
use App\Business\Repositories\CouponRepository;
use App\Business\Repositories\ProductRepository;
use App\Coupon;
use Darryldecode\Cart\CartCondition;
use \Cart;

class CouponService
{

    public $couponRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * CouponService constructor.
     * @param CouponRepository $couponRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(CouponRepository $couponRepository, ProductRepository $productRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $name
     */
    public function addCoupon($name)
    {
        $name = strtolower($name);
        /** @var Coupon $coupon */
        $coupon = $this->couponRepository->whereName($name)->first();

        if ($coupon->target == \App\Cart::CART_CONDITION_TARGET_ITEM) {
            Cart::getContent()
                ->each(function ($item) use ($coupon) {
                    /** @var Product $product */
                    $product = $this->productRepository->findBy('_id', $item->attributes['_id']);

                    if ($product->is_discounted && $coupon->exclude_sale_items) {
                        //TODO add message that coupon is no appliable
                        return;
                    }

                    $cartCoupon = $this->createCoupon($coupon);
                    Cart::removeItemCondition($item->id, $cartCoupon->getName());
                    Cart::addItemCondition($item->id, $cartCoupon);
                });
        }


        // Add condition to cart only to show it on the subtotal. We add it to every item because of how
        //woocommerce works with discounts.
        $cartCoupon = $this->createCoupon($coupon);
        Cart::condition($cartCoupon);
    }

    /**
     * Returns a coupon formatted as
     * @param Coupon $coupon
     * @return CartCondition
     */
    private function createCoupon(Coupon $coupon)
    {
        return new CartCondition([
            'name' => $coupon->name,
            'type' => Coupon::CART_CONDITION_TYPE,
            'target' => $coupon->target,
            'value' => $coupon->value,
            'order' => 1
        ]);
    }
}
