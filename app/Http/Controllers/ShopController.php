<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Business\Search\ProductSearch;
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
     * @param Product $product
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product(Product $product, $slug)
    {
        $product = $product::whereSlug($slug)->firstOrFail();

        $relatedProducts = Product::with('brand')
            ->whereBrandId($product->brand_id)
            ->where('_id', '!=', $product->_id)
            ->get()
            ->take(4);
        return view('shop.product', compact('product', 'relatedProducts'));
    }

    /**
     * @param Brand $brand
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand(Brand $brand, $slug)
    {
        $brand = $brand::whereSlug($slug)->firstOrFail();
        return view('shop.brand', compact('brand'));
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shopping(Request $request)
    {
        $products = ProductSearch::apply($request);
        $filters = ProductSearch::getFilters($request);

        return view('shop.shopping', compact('products', 'filters'));
    }
}
