<?php

namespace App\Business\Services;

use App\Business\Models\Shop\Product;
use App\Business\Repositories\ProductRepository;
use App\Variation;
use Cart;
use Darryldecode\Cart\ItemCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CartService
{
    protected $productRepository;

    protected $request;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $properties = $request->input('properties', []);
        $quantity = $request->input('quantity', 1);

        /** @var Product $product */
        $product = $this->productRepository->find($productId);
        $variationProperties = array_merge([$productId], $properties);
        /** @var Variation $variation */
        $variation = $product->productVariation($variationProperties);

        $item = Cart::get($variation->sku);
        if (!is_null($item)) {
            Cart::update($variation->sku, $this->getUpdateItem($quantity, $variation->stock, $item->quantity));
        } else {
            $cart = Cart::add($this->getNewItem($variation, $product, $variationProperties, $quantity, $properties));
            $item = $cart->get($variation->sku);
        }

        return $this->mapItem($item);
    }

    /**
     * @return Collection
     */
    public function getCartContent()
    {
        return Cart::getContent()
            ->map(function ($item) {
                return $this->mapItem($item);
            })
            ->values();
    }

    /**
     * @param ItemCollection $item
     * @return array
     */
    protected function mapItem($item)
    {
        /** @var Product $product */
        $product = $item->attributes['product'];

        $productArr = [
            'filename' => $item->attributes->filename,
            'alt' => $item->name,
            'name' => $item->name,
            'route' => route('shop.product', ['slug' => $product->slug]),
            'quantity' => $item->quantity,
            'price' => $item->getPriceWithConditions(),
            'currency' => $product->currency,
            '_id' => $item->id
        ];
        return $productArr;
    }

    /**
     * TODO Add already added coupons in order to have the discount applied
     * @return array
     */
    protected function getConditions()
    {
        // TODO change tax depending IP
        $taxCondition = new \Darryldecode\Cart\CartCondition([
            'name' => '[21%] IVA',
            'type' => 'tax',
            'target' => 'item',
            'value' => '21%',
            'order' => 5
        ]);

        return [$taxCondition];
    }

    protected function getNewItem(Variation $variation, Product $product, $variationProperties, $quantity, $properties)
    {
        return [
            'id' => $variation->sku,
            'name' => $product->name,
            'price' => $variation->price,
            'quantity' => $quantity,
            'conditions' => $this->getConditions(),
            'attributes' => [
                'product' => $product,
                'variation_id' => $variation->external_id,
                'properties' => $properties,
                'filename' => $variation->filename
            ]
        ];
    }

    protected function getUpdateItem($quantity, $stock, $item_quantity)
    {
        if( ($item_quantity + $quantity) >= $stock ) {
            //TODO notify that this is already maximum stock
            $return = [
                'quantity' => [
                    'relative' => false,
                    'value' => $stock
                ],
            ];
        } else {
            $return = [
                'quantity' => $quantity,
            ];
        }
        return $return;
    }
}