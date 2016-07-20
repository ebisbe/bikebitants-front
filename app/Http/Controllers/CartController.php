<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Cart::with('product.brand')->get();
        $discount = 0;
        if($products->isEmpty()) {
            return view('cart.empty');
        }
        return view('cart.index', compact('products', 'discount'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $attributes = $request->input('attributes', []);

        $cart = Cart::whereProductId($productId)
            ->withAttributes($attributes)
            ->first();

        if(empty($cart)){
            // New product
            $cart = new Cart();
            $cart->product_id = $productId;
            $cart->session_id = $request->session()->getId();
            $cart->quantity = (int)$request->input('quantity', 1);
            collect($attributes)->map(function($value, $attribute) use ($cart) {
                return $cart->$attribute = $value;
            });
        } else {
            // update quantity
            $cart->increment('quantity', (int)$request->input('quantity', 1));
        }
        $cart->price = $cart->product->finalPrice($attributes);
        $cart->subtotal = $cart->price * $cart->quantity;

        $cart->save();

        if ($request->ajax()) {
            return Cart::get();
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
        $cart = Cart::where('_id', $id)->first();
        if (!empty($cart)) {
            $cart->delete();
            $response = true;
        } else {
            $response = trans('cart.no_items_to_delete');
        }

        if ($request->ajax()) {
            return ['response' => $response];
        } else {
            return redirect('cart');
        }
    }
}