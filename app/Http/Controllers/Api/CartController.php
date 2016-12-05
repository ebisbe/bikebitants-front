<?php

namespace App\Http\Controllers\Api;

use App\Business\Repositories\ProductRepository;
use App\Business\Services\TaxService;
use App\Http\Middleware\CartMiddleware;
use App\Order;
use App\Product;
use App\Variation;
use Illuminate\Http\Request;
use MetaTag;
use Cart;
use BreadCrumbLinks;

class CartController extends ApiController
{

    public function __construct()
    {
        $this->middleware(CartMiddleware::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        return Cart::getContent()
            ->map(function ($item) {
                return $this->mapItem($item);
            })
            ->values();
    }

    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return array
     */
    public function store(Request $request, ProductRepository $productRepository)
    {
        $order = Order::currentOrder();
        if (!$order->isEmpty() && $order->first()->status > Order::New) {
            //TODO throw response in json form  if it is an ajax request
            abort(402, 'Unable to add more products while checking out the cart.');
        }

        $productId = $request->input('product_id');
        $properties = $request->input('properties', []);
        $quantity = $request->input('quantity', 1);

        $variationProperties = array_merge([$productId], $properties);

        /** @var Product $product */
        $product = $productRepository->find($productId);
        $variation = $product->productVariation($variationProperties);

        $item = Cart::get($variation->sku);
        if (!is_null($item) && ($item->quantity + $quantity) >= $variation->stock) {
            //TODO notify that this is already maximum stock
            Cart::update($variation->sku, [
                'quantity' => [
                    'relative' => false,
                    'value' => $variation->stock
                ],
            ]);
        } else {
            Cart::add([
                'id' => $variation->sku,
                'name' => $product->name,
                'price' => $product->finalPrice($variationProperties),
                'quantity' => $quantity,
                // TODO change tax depending IP
                /*'conditions' => new \Darryldecode\Cart\CartCondition([
                    'name' => '[21%] IVA',
                    'type' => 'tax',
                    'target' => 'item',
                    'value' => '21%',
                    'order' => 5
                ]),*/
                'attributes' => [
                    'product' => $product,
                    'variation_id' => $variation->external_id,
                    'properties' => $properties,
                    'filename' => $variation->filename
                ]
            ]);
        }

        return $this->mapItem(Cart::get($variation->sku));
    }

    /**
     * @param $id
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if (!Cart::isEmpty()) {
            Cart::remove($id);
        }

        return \Response::json(['success' => true]);
    }

    /**
     * @param $item
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
}