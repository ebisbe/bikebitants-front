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
        $order = Order::currentOrder()->get();
        if (!$order->isEmpty() && $order->first()->status > Order::New) {
            //TODO throw response in json form  if it is an ajax request
            abort(402, 'Unable to add more products while checking out the cart.');
        }

        $this->validate($request, ['product_id' => 'required']);

        $cartService->setProductId($request->input('product_id'));
        $cartService->setProperties($request->input('properties', []));
        $cartService->setQuantity($request->input('quantity', 1));

        return $cartService->store($this);
    }

    /**
     * @param $id
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if (Cart::isEmpty()) {
            $is_deleted = false;
            $message = trans('api.cart_empty');
        } else {
            if ($is_deleted = Cart::remove($id)) {
                $message = trans('api.product_deleted');
            } else {
                $is_deleted = false;
                $message = trans('api.product_not_deleted');
            }
        }

        return \Response::json([
            'success' => $is_deleted,
            'message' => $message
        ]);
    }

    /**
     * @param ItemCollection $item
     * @return array
     */
    public function mapItem(ItemCollection $item)
    {
        return [
            'filename' => $item->attributes->filename,
            'file' => assetCDN('/img/70/' . $item->attributes->filename), //not present in ItemCollection
            'alt' => $item->name,
            'name' => $item->name,
            'is_max_stock' => $item->attributes['is_max_stock'],
            'route' => route('shop.slug', ['slug' => $item->attributes['slug']]),
            'quantity' => $item->quantity,
            'price' => $item->getPriceWithConditions(),
            'currency' => $item->attributes['currency']. ' '. trans('catalogue.iva'),
            'image_alt' => $item->attributes['image_alt'],
            'brand' => $item->attributes['brand'],
            '_id' => $item->id,
        ];
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function mapNotFoundItem(string $message)
    {
        return \Response::json([
            'success' => false,
            'message' => $message
        ]);
    }
}