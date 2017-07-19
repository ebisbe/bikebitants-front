<?php

namespace App\Http\Controllers;

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

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware(CartMiddleware::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ProductRepository $productRepository)
    {
        BreadCrumbLinks::set(['value' => 'Home', 'href' => route('shop.home')]);
        BreadCrumbLinks::set(['value' => 'Shop', 'href' => route('shop.catalogue')]);
        BreadCrumbLinks::set(['value' => trans('cart.cart')]);

        MetaTag::set('title', trans('cart.cart'));
        MetaTag::set('description', trans('cart.cart'));
        MetaTag::set('slug', trans('cart.cart'));

        $title = trans('layout.shop');
        $subtitle = trans('cart.cart');

        $cartCollect = Cart::getContent();

        $lastProduct = $cartCollect->last();
        $crossSellShop = $productRepository->find($lastProduct['attributes']['_id'])->cross_sell_shop;
        if ($cartCollect->isEmpty()) {
            return view('cart.empty', compact('title', 'subtitle'));
        }

        return view('cart.index', compact('cartCollect', 'title', 'subtitle', 'crossSellShop'));
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

        return redirect()->back();
    }
}
