<?php

namespace App\Business\Services;

use App\Business\Interfaces\CartMapper;
use App\Business\Models\Shop\Product;
use App\Business\Repositories\ProductRepository;
use App\Variation;
use \Cart;
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
            Cart::update($variation->sku, $this->getUpdateItem($variation->stock, $item->quantity));
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
            'quantity' => $this->quantity,
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
     * @param $stock
     * @param $item_quantity
     * @return array
     */
    protected function getUpdateItem($stock, $item_quantity)
    {
        if (($item_quantity + $this->quantity) >= $stock) {
            //TODO notify that this is already maximum stock
            $return = [
                'quantity' => [
                    'relative' => false,
                    'value' => $stock
                ],
            ];
        } else {
            $return = [
                'quantity' => $this->quantity,
            ];
        }
        return $return;
    }

    /**
     * TODO Add already added coupons in order to have the discount applied
     * @return array
     */
    protected function getConditions()
    {
        $taxCondition = $this->getTaxCondition();
        $couponsConditions = $this->getCouponsConditions();

        return $couponsConditions->merge($taxCondition);
    }

    /**
     * TODO change tax depending IP
     * @return CartCondition
     */
    protected function getTaxCondition()
    {
        return new CartCondition([
            'name' => '[21%] IVA',
            'type' => 'tax',
            'target' => 'item',
            'value' => '21%',
            'order' => 5
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getCouponsConditions()
    {
        $coupons = collect();
        foreach($this->coupons as $coupon) {
            $coupons->push($this->couponService->createCoupon($coupon));
        }

        return $coupons;
    }
}