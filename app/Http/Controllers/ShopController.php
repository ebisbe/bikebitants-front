<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;

class ShopController extends Controller
{
    /**
     * Home View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view('shop.home');
    }

    /**
     * Product view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product()
    {
        $product = Product::all()->first();

        return view('shop.product', compact('product'));
    }
}
