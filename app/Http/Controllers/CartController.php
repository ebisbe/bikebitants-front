<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cartCollect = CartFacade::getContent();
        $discount = 0;
        if($cartCollect->isEmpty()) {
            return view('cart.empty');
        }
        return view('cart.index', compact('cartCollect', 'discount'));
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

        CartFacade::add([
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
            return CartFacade::get($id);
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
        if (CartFacade::isEmpty()) {
            $response = trans('cart.no_items_to_delete');
        } else {
            CartFacade::remove($id);
            $response = true;
        }

        if ($request->ajax()) {
            return ['response' => $response];
        } else {
            return redirect('cart');
        }
    }
}