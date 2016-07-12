<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Business\Search\ProductSearch;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;

class ShopController extends Controller
{

    public function __construct()
    {
        \BreadCrumbLinks::set(['href' => route('shop.home'), 'value' => 'Home']);

    }

    /**
     * @param Brand $brand
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Brand $brand, Product $product, Category $category)
    {
        $layoutHeader = 'navbar-transparent navbar-fixed-top';
        $layoutTopHeader = 'hidden';

        $brands = $brand->featured()->get();
        $productsLeft = $product->take(2)->get();
        $productsRight = $product->take(8)->get();
        $categories = $category->take(3)->get();

        return view('shop.home', compact('layoutHeader', 'layoutTopHeader', 'brands', 'productsLeft', 'productsRight', 'categories'));
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
     * @param Request $request
     * @param ProductSearch $productSearch
     * @param Category $category
     * @param string $slugCategory
     * @param string $slugSubCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function catalogue(Request $request, ProductSearch $productSearch, Category $category, $slugCategory = '', $slugSubCategory = '')
    {
        /** @var Category $cat */
        $cat = Category::whereSlug($slugCategory)->first();
        $subCat = $cat->whereSlugSubCategory($slugSubCategory)->first();
        \BreadCrumbLinks::set(['href' => route('shop.catalogue', ['category' => $cat->slug]), 'value' => $cat->name]);
        if(!empty($slugSubCategory)) {
            \BreadCrumbLinks::set(['value' => $subCat->name, 'li_class' => '']);
        }

        $products = $productSearch::apply($request, $cat, $slugSubCategory);
        $filters = $productSearch::getFilters($request);

        $categories = $category->with('children')->get();

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'cat', 'subCat'));
    }
}
