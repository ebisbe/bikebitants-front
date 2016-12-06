<?php

namespace App\Http\Controllers\Api;

use App\Business\Repositories\ProductRepository;
use App\Business\Services\CartService;
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
     * @param CartService $cartService
     * @return \Illuminate\Support\Collection
     */
    public function index(CartService $cartService)
    {
        return $cartService->getCartContent();
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

        return $cartService->store($request);
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
}