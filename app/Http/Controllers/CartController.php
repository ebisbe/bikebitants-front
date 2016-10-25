<?php

namespace App\Http\Controllers;

use App\Business\Services\ProductService;
use App\Http\Middleware\CartMiddleware;
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
    public function index()
    {
        BreadCrumbLinks::set(['value' => 'Home', 'href' => route('shop.home')]);
        BreadCrumbLinks::set(['value' => 'Shop', 'href' => route('shop.catalogue')]);
        BreadCrumbLinks::set(['value' => 'Cart']);

        MetaTag::set('title', 'Cart');
        MetaTag::set('description', 'cart');
        MetaTag::set('slug', 'cart');

        $title = 'Shop';
        $subtitle = 'Cart';

        $cartCollect = Cart::getContent();

        if ($cartCollect->isEmpty()) {
            return view('cart.empty', compact('title', 'subtitle'));
        }
        return view('cart.index', compact('cartCollect', 'title', 'subtitle'));
    }

    /**
     * @param Request $request
     * @param ProductService $productService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function store(Request $request, ProductService $productService)
    {
//        $order = Order::currentOrder();
//        if($order->isEmpty() || $order->first()->status == Order::Confirmed) {
//            $request->session()->forget('order');
//            $order = new Order();
//        }
//        if(!$order->isEmpty() && $order->first()->status != Order::New) {
//            //TODO throw response in json form  if it is an ajax request
//            abort(402, 'Unable to add more products while checking out the cart.');
//        }

        $productId = $request->input('product_id');
        $attributes = $request->input('attributes', []);
        $variationProperties = array_merge([$productId], $attributes);

        /** @var Product $product */
        $product = Product::find($productId);

        $variation = $productService->productVariation($variationProperties);

        $item = Cart::get($variation->sku);
        if (!is_null($item) && ($item->quantity + $request->input('quantity', 1)) >= $variation->stock) {
            //TODO notify that this is already maximum stock
            Cart::update($variation->sku, [
                'quantity' => [
                    'relative' => false,
                    'value' => $variation->stock
                ]
            ]);
        } else {
            Cart::add([
                'id' => $variation->sku,
                'name' => $product->name,
                'price' => $productService->finalPrice($variationProperties),
                'quantity' => $request->input('quantity', 1),
                'attributes' => [
                    'product' => $product,
                    'attributes' => $attributes,
                    'filename' => $variation->filename
                ]
            ]);
        }

        if ($request->ajax()) {
            return Cart::get($variation->sku);
        } else {
            return redirect('cart');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        if (Cart::isEmpty()) {
            $response = trans('cart.no_items_to_delete');
        } else {
            Cart::remove($id);
            $response = true;
        }

        if ($request->ajax()) {
            return ['response' => $response];
        } else {
            return redirect('cart');
        }
    }
}