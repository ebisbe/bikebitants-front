<?php

namespace App\Business\Services;

use App\Business\Interfaces\CartMapper;
use App\Business\Models\Shop\Product;
use App\Business\Repositories\ProductRepository;
use App\Variation;
use \Cart;
use \TaxService;
use Darryldecode\Cart\CartCondition;

class CartService
{
    protected $productRepository;
    protected $couponService;
    protected $cart;

    protected $request;

    protected $product_id;
    protected $properties;
    protected $quantity;
    protected $coupons;

    /**
     * CartService constructor.
     * @param ProductRepository $productRepository
     * @param CouponService $couponService
     */
    public function __construct(ProductRepository $productRepository, CouponService $couponService)
    {
        $this->productRepository = $productRepository;
        $this->couponService = $couponService;
    }

    /**
     * @param string $product_id
     */
    public function setProductId(string $product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @param array $properties
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param array $coupons
     */
    public function setCoupons(array $coupons)
    {
        $this->coupons = $coupons;
    }

    /**
     * @param CartMapper $cartMapper
     * @return mixed
     */
    public function store(CartMapper $cartMapper)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($this->product_id);
        $variationProperties = array_merge([$this->product_id], $this->properties);
        /** @var Variation $variation */
        $variation = $product->productVariation($variationProperties);

        $item = Cart::get($variation->sku);
        if (!is_null($item)) {
            Cart::update($variation->sku, [
                'quantity' => $this->getQuantity($variation->stock, $item->quantity, false)
            ]);
        } else {
            $cart = Cart::add($this->getNewItem($variation, $product));
            $item = $cart->get($variation->sku);
        }

        return $cartMapper->mapItem($item);
    }

    /**
     * @param CartMapper $cartMapper
     * @return static
     */
    public function getCartContent(CartMapper $cartMapper)
    {
        return Cart::getContent()
            ->map(function ($item) use ($cartMapper) {
                return $cartMapper->mapItem($item);
            })
            ->values();
    }

    /**
     * @param Variation $variation
     * @param Product $product
     * @return array
     */
    protected function getNewItem(Variation $variation, Product $product)
    {
        return [
            'id' => $variation->sku,
            'name' => $product->name,
            'price' => $variation->price,
            'quantity' => $this->getQuantity($variation->stock),
            'conditions' => $this->getConditions(),
            'attributes' => [
                'product' => $product,
                'variation_id' => $variation->external_id,
                'properties' => $this->properties,
                'filename' => $variation->filename
            ]
        ];
    }

    /**
     * TODO notify that this is already maximum stock
     * @param $stock
     * @param $item_quantity
     * @return array
     */
    protected function getQuantity($stock, $item_quantity = 0, $relative = true)
    {
        if (($item_quantity + $this->quantity) >= $stock) {
            $value = $stock;
        } else {
            $value = $this->quantity;
        }

        if (!$relative) {
            $return = [
                'relative' => false,
                'value' => $value
            ];
        } else {
            $return = $value;
        }

        return $return;
    }

    /**
     * All coupons are applied per Item but the condition is also added to the main conditions. But it is added
     * as per item and not per subtotal in order to not calculate 2 times the discount.
     * It's just a dirty work arround.
     * @return array
     */
    protected function getConditions()
    {
        $taxCondition = $this->getTaxCondition();
        $couponsConditions = Cart::getConditionsByType('coupon');

        return array_merge([$taxCondition], $couponsConditions->toArray());
    }

    /**
     * @return CartCondition
     */
    protected function getTaxCondition()
    {
        $tax = TaxService::getTax();
        return new CartCondition([
            'name' => $tax->name,
            'type' => 'tax',
            'target' => 'item',
            'value' => $tax->rate . '%',
            'order' => 5
        ]);
    }
}