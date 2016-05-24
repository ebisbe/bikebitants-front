<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $items = Cart::with('product.brand')->whereSessionId($request->session()->getId())->get();
        $discount = 0;
        return view('cart.index', compact('items', 'discount'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $attributes = $request->input('attributes', []);

        $product = Cart::whereProductId($productId)
            ->whereSessionId($request->session()->getId())
            ->when($attributes, function($query) use ($attributes){
                foreach($attributes as $attribute => $value) {
                    $query->where($attribute, '=', $value);
                }
                return $query;
            })->first();

        if(empty($product)){
            $product = new Cart();
            $product->product_id = $productId;
            $product->session_id = $request->session()->getId();
            $product->quantity = (int)$request->input('quantity', 1);
            foreach($attributes as $attribute => $value) {
                $product->$attribute = $value;
            }
        } else {
            $product->increment('quantity', (int)$request->input('quantity', 1));
        }
        $product->price = Product::getPrice($productId, $attributes);
        $product->subtotal = $product->price * $product->quantity;

        $product->save();

        if ($request->ajax()) {
            return Cart::whereSessionId($request->session()->getId())->get();
        } else {
            return redirect('cart');
        }
    }

    // update

    /**
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        if ($request->session()->has('items')) {
            $items = $request->session()->get('items');
            unset($items[$id]);
            $request->session()->put('items', $items);
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