<?php

namespace App\Business\Services;

use App\Business\Interfaces\CartMapper;
use App\Business\Models\Shop\Product;
use App\Business\Repositories\ProductRepository;
use App\Variation;
use \Cart;
use Darryldecode\Cart\ItemCollection;
use \TaxService;
use Darryldecode\Cart\CartCondition;

class CartService
{
    protected $productRepository;
    protected $cart;

    protected $request;

    protected $product_id;
    protected $properties;
    protected $quantity;

    protected $stock;

    /**
     * CartService constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @param CartMapper $cartMapper
     * @return mixed
     */
    public function store(CartMapper $cartMapper)
    {
        //list($product, $variation) = $this->variation();
        $variation = $this->productRepository->findVariationByProduct($this->product_id, $this->properties);
        $product = $variation->product;

        $this->setStock($variation->stock);

        $item = Cart::get($variation->sku);
        if (!is_null($item)) {
            Cart::update($variation->sku, [
                'quantity' => $this->getQuantity($item->quantity),
                'attributes' => $this->getAttributesFromItem($item, $item->quantity)
            ]);
        } else {
            Cart::add($this->getNewItem($variation, $product));
        }
        $item = Cart::get($variation->sku);

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
            'quantity' => $this->getQuantity(),
            'conditions' => $this->getConditions(),
            'attributes' => [
                'is_max_stock' => $this->isMaxStock(),
                'slug' => $product->slug,
                'currency' => $product->html_currency,
                'variation_id' => $variation->external_id,
                'properties' => $this->properties,
                'filename' => $variation->filename,
                'image_alt' => $product->front_image->alt,
                'brand' => $product->brand->name ?? '',
                '_id' => $product->_id,
            ]
        ];
    }

    /**
     * @param $quantity_already_in_cart
     * @return array
     */
    public function getQuantity($quantity_already_in_cart = 0)
    {
        return $this->isMaxStock($quantity_already_in_cart)
            ? $this->stock - $quantity_already_in_cart
            : $this->quantity;
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

    /**
     * @param $item_quantity
     * @return bool
     */
    public function isMaxStock($item_quantity = 0)
    {
        if (is_null($this->stock)) {
            return false;
        }

        return ($item_quantity + $this->quantity) >= $this->stock;
    }

    protected function getAttributesFromItem(ItemCollection $item, $quantity)
    {
        return array_merge(
            $item->attributes->toArray(),
            ['is_max_stock' => $this->isMaxStock($quantity)]
        );
    }
}
