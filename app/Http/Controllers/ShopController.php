<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Business\Search\ProductSearch;
use App\Category;
use App\Shop\PublishedProduct;
use Illuminate\Http\Request;
use MetaTag;
use Breadcrumbs;
use App\Http\Requests;
use Illuminate\Routing\Route;
use Awjudd\FeedReader\Facades\FeedReader;

class ShopController extends Controller
{

    /**
     * ShopController constructor.
     */
    public function __construct()
    {
        Breadcrumbs::setCssClasses('breadcrumb');
        Breadcrumbs::setListElement('ol');
        Breadcrumbs::setDivider('');
        Breadcrumbs::addCrumb('Home', route('shop.home'));
    }

    /**
     * @param Brand $brand
     * @param PublishedProduct $product
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Brand $brand, PublishedProduct $product, Category $category)
    {
        $layoutHeader = 'navbar-transparent navbar-fixed-top';
        $layoutTopHeader = 'hidden';

        $brands = $brand->featured()->get();
        $productsLeft = $product->featured()->take(2)->get();
        $productsRight = $product->featured()->take(8)->get();
        $categories = $category->take(3)->get();

        $feed = FeedReader::read('https://bikebitants.com/feed/')->get_items(0, 4);

        return view('shop.home', compact('layoutHeader', 'layoutTopHeader', 'brands', 'productsLeft', 'productsRight', 'categories', 'feed'));
    }

    /**
     * @param PublishedProduct $product
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product(PublishedProduct $product, $slug)
    {
        /** @var Product $product */
        $product = $product::with(['category.father', 'images', 'faqs'])->whereSlug($slug)->firstOrFail();

        Breadcrumbs::addCrumb('Shop', route('shop.catalogue'));
        Breadcrumbs::addCrumb($product->category->father->name, route('shop.category', ['category' => $product->category->father->slug]));
        Breadcrumbs::addCrumb($product->category->name, route('shop.subcategory', ['category' => $product->category->father->slug, 'subcategory' => $product->category->slug]));
        Breadcrumbs::addCrumb($product->name);

        MetaTag::set('title', $product->meta_title);
        MetaTag::set('description', $product->meta_description);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $product->front_image->filename]));

        $title = $product->category->name;
        $subtitle = $product->name;

        $relatedProducts = PublishedProduct::with('brand')
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
        MetaTag::set('slug', $brand->meta_slug);
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
        Breadcrumbs::addCrumb('Shop');

        $title = 'Home';
        $subtitle = 'Shop';
        $selectedCat = '';

        $products = $productSearch::apply($request, $route);
        $filters = $productSearch::getFilters($request, $route);
        $categories = $category->with('children')->whereNull('father_id')->orderBy('name', 'asc')->get();

        MetaTag::set('title', 'Bikebitants shop');
        MetaTag::set('description', 'This is the metra description');
        MetaTag::set('slug', 'some meta tags here');

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
        Breadcrumbs::addCrumb('Shop', route('shop.catalogue'));
        Breadcrumbs::addCrumb($cat->name, route('shop.category', ['category' => $cat->slug]));

        MetaTag::set('title', $cat->meta_title);
        MetaTag::set('description', $cat->meta_description);
        MetaTag::set('slug', $cat->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $cat->filename]));

        $title = 'Shop';
        $subtitle = $cat->name;
        $selectedCat = $cat->_id;

        $products = $productSearch::apply($request, $route);
        $filters = $productSearch::getFilters($request, $route);
        $categories = $category->with('children')->whereNull('father_id')->orderBy('name', 'asc')->get();

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

        Breadcrumbs::addCrumb('Shop', route('shop.catalogue'));
        Breadcrumbs::addCrumb($cat->name, route('shop.category', ['category' => $cat->slug]));
        Breadcrumbs::addCrumb($subCat->name);

        MetaTag::set('title', $subCat->meta_title);
        MetaTag::set('description', $subCat->meta_description);
        MetaTag::set('slug', $subCat->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $subCat->filename]));

        $title = $cat->name;
        $subtitle = $subCat->name;
        $selectedCat = $cat->_id;

        $products = $productSearch::apply($request, $route);
        $filters = $productSearch::getFilters($request, $route);
        $categories = $category->with('children')->whereNull('father_id')->orderBy('name', 'asc')->get();

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }
}
