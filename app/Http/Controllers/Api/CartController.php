<?php

namespace App\Http\Controllers\Api;

use App\Business\Interfaces\CartMapper;
use App\Business\Services\CartService;
use App\Http\Middleware\CartMiddleware;
use App\Order;
use App\Product;
use Darryldecode\Cart\ItemCollection;
use Illuminate\Http\Request;
use Cart;

class CartController extends ApiController implements CartMapper
{

    public function __construct()
    {
        $this->middleware(CartMiddleware::class);
    }

    /**
     * @param CartService $cartService
     * @return \Illuminate\Support\Collection
     */
    public function index(CartService $cartService)
    {
        return $cartService->getCartContent($this);
    }

    /**
     * @param Request $request
     * @param CartService $cartService
     * @return array
     */
    public function store(Request $request, CartService $cartService)
    {
        $order = Order::currentOrder();
        if (!$order->isEmpty() && $order->first()->status > Order::New) {
            //TODO throw response in json form  if it is an ajax request
            abort(402, 'Unable to add more products while checking out the cart.');
        }

        $this->validate($request, ['product_id' => 'required']);

        $cartService->setProductId($request->input('product_id'));
        $cartService->setProperties($request->input('properties', []));
        $cartService->setQuantity((int)$request->input('quantity', 1));
        $cartService->setCoupons($request->session()->get('coupons', []));

        return $cartService->store($this);
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
     * @param ItemCollection $item
     * @return array
     */
    public function mapItem(ItemCollection $item)
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