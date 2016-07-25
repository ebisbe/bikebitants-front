<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use MetaTag;
use Cart;
use BreadCrumbLinks;

class CartController extends Controller
{

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
        MetaTag::set('keywords', 'cart');

        $condition1 = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'VAT 12.5%',
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => '12.5%',
        ));
        Cart::condition($condition1);

        $title = 'Shop';
        $subtitle = 'Cart';

        $cartCollect = Cart::getContent();
        $discount = 0;
        if($cartCollect->isEmpty()) {
            return view('cart.empty', compact('title', 'subtitle'));
        }
        return view('cart.index', compact('cartCollect', 'discount', 'title', 'subtitle'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $attributes = $request->input('attributes', []);

        /** @var Product $product */
        $product = Product::find($productId);
        if(!empty($attributes)) {
            $variation = $product->productVariation($attributes);
            $id = implode('_', $variation->_id);
        } else {
            $id = $product->_id;
        }

        Cart::add([
            'id' => $id,
            'name' => $product->name,
            'price' => $product->finalPrice($attributes),
            'quantity' => $request->input('quantity', 1),
            'attributes' => [
                'product' => $product,
                'attributes' => $attributes
            ]
        ]);


        if ($request->ajax()) {
            return Cart::get($id);
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