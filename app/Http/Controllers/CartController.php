<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $items = $request->session()->get('items', []);
        return view('cart.index', compact('items'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function store(Request $request)
    {
        $item = $request->all();
        $quantity = $item['quantity'];
        unset($item['_token']);
        unset($item['quantity']);
        ksort($item);
        $product_id = implode('-', array_values($item));

        $items = $request->session()->get('items', []);
        if(isset($items[$product_id])) {
            $items[$product_id]['quantity'] += $quantity;
        } else {
            $product = Product::where('_id', $item['product_id'])->firstOrFail();
            $items[$product_id] = array_merge($item, ['quantity' => $quantity, '_id' => $product_id, 'product' => $product]);
        }
        $request->session()->put('items', $items);

        if ($request->ajax()) {
            return $request->session()->get('items', []);
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