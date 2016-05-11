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
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product($slug)
    {
        $product = Product::whereSlug($slug)->firstOrFail();
        $relatedProducts = Product::with('brand')->whereBrandId($product->brand_id)->get()->take(4);
        return view('shop.product', compact('product', 'relatedProducts'));
    }

    /**
     * Brand view
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand($slug)
    {
        $brand = Brand::whereSlug($slug)->firstOrFail();
        return view('shop.brand', compact('brand'));
    }

}
