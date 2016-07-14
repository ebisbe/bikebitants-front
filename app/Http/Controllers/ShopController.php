<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Business\Search\ProductSearch;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Http\Requests;
use Illuminate\Routing\Route;

class ShopController extends Controller
{

    /**
     * ShopController constructor.
     */
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
        $product = $product::with('category.father')->whereSlug($slug)->firstOrFail();

        \BreadCrumbLinks::set(['value' => 'Shop', 'href' => route('shop.catalogue')]);
        \BreadCrumbLinks::set(['href' => route('shop.category', ['category' => $product->category->father->slug]), 'value' => $product->category->father->name]);
        \BreadCrumbLinks::set(['href' => route('shop.subcategory', ['category' => $product->category->father->slug, 'subcategory' => $product->category->slug]), 'value' => $product->category->name]);
        \BreadCrumbLinks::set(['value' => $product->name]);

        MetaTag::set('title', $product->meta_title);
        MetaTag::set('description', $product->meta_description);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $product->images()->first()->path]));

        $title = $product->category->name;
        $subtitle = $product->name;

        $relatedProducts = Product::with('brand')
            ->whereBrandId($product->brand_id)
            ->where('_id', '!=', $product->_id)
            ->get()
            ->take(4);
        return view('shop.product', compact('product', 'relatedProducts', 'title', 'subtitle'));
    }

    /**
     * @param Brand $brand
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand(Brand $brand, $slug)
    {
        $brand = $brand::whereSlug($slug)->firstOrFail();

        MetaTag::set('title', $brand->meta_title);
        MetaTag::set('description', $brand->meta_description);
        MetaTag::set('keywords', $brand->meta_keywords);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $brand->filename]));

        return view('shop.brand', compact('brand'));
    }

    /**
     * @param Request $request
     * @param ProductSearch $productSearch
     * @param Route $route
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shop(Request $request, ProductSearch $productSearch, Route $route, Category $category)
    {
        \BreadCrumbLinks::set(['value' => 'Shop']);

        $title = 'Home';
        $subtitle = 'Shop';
        $selectedCat = '';

        $products = $productSearch::apply($request, $route);
        $filters = $productSearch::getFilters($request, $route);
        $categories = $category->with('children')->whereNull('father_id')->get();

        MetaTag::set('title', 'Bikebitants shop');
        MetaTag::set('description', 'This is the metra description');
        MetaTag::set('keywords', 'some meta tags here');

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }

    /**
     * @param Request $request
     * @param ProductSearch $productSearch
     * @param Route $route
     * @param Category $category
     * @param string $slugCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request, ProductSearch $productSearch, Route $route, Category $category, $slugCategory)
    {
        /** @var Category $cat */
        $cat = Category::whereSlug($slugCategory)->first();
        \BreadCrumbLinks::set(['value' => 'Shop', 'href' => route('shop.catalogue')]);
        \BreadCrumbLinks::set(['href' => route('shop.category', ['category' => $cat->slug]), 'value' => $cat->name]);

        MetaTag::set('title', $cat->meta_title);
        MetaTag::set('description', $cat->meta_description);
        MetaTag::set('keywords', $cat->meta_keywords);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $cat->path]));

        $title = 'Shop';
        $subtitle = $cat->name;
        $selectedCat = $cat->_id;

        $products = $productSearch::apply($request, $route);
        $filters = $productSearch::getFilters($request, $route);
        $categories = $category->with('children')->whereNull('father_id')->get();

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }

    /**
     * @param Request $request
     * @param ProductSearch $productSearch
     * @param Route $route
     * @param Category $category
     * @param string $slugCategory
     * @param string $slugSubCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subcategory(Request $request, ProductSearch $productSearch, Route $route, Category $category, $slugCategory, $slugSubCategory)
    {
        /** @var Category $cat */
        $cat = Category::whereSlug($slugCategory)->first();
        $subCat = Category::whereSlug($slugSubCategory)->first();

        \BreadCrumbLinks::set(['value' => 'Shop', 'href' => route('shop.catalogue')]);
        \BreadCrumbLinks::set(['href' => route('shop.category', ['category' => $cat->slug]), 'value' => $cat->name]);
        \BreadCrumbLinks::set(['value' => $subCat->name]);

        MetaTag::set('title', $subCat->meta_title);
        MetaTag::set('description', $subCat->meta_description);
        MetaTag::set('keywords', $subCat->meta_keywords);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $subCat->path]));

        $title = $cat->name;
        $subtitle = $subCat->name;
        $selectedCat = $cat->_id;

        $products = $productSearch::apply($request, $route);
        $filters = $productSearch::getFilters($request, $route);
        $categories = $category->with('children')->whereNull('father_id')->get();

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }
}
