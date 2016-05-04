<?php

namespace App\Http\Controllers;

use App\Brand;
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

    /**
     * Brand view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand($slug)
    {
        $brand = Brand::where('slug', '=', $slug)->firstOrFail();
        return view('shop.brand', compact('brand'));
    }
}
