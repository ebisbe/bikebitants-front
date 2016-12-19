<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Business\Models\Shop\Category;
use App\Business\Models\Shop\Product;
use App\Business\Repositories\BrandRepository;
use App\Business\Repositories\CategoryRepository;
use App\Business\Search\ProductSearch;
use App\Business\Repositories\ProductRepository;
use Illuminate\Http\Request;
use MetaTag;
use Breadcrumbs;
use App\Http\Requests;
use Illuminate\Routing\Route;
use \FeedReader;

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
        Breadcrumbs::addCrumb(trans('layout.home'), route('shop.home'));
    }

    /**
     * @param BrandRepository $brandRepository
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(BrandRepository $brandRepository, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $layoutHeader = 'navbar-transparent navbar-fixed-top';
        $layoutTopHeader = 'hidden';

        $brands = collect()/*$brandRepository->findAll()*/;
        $featuredProducts = $productRepository->where('is_featured', true)->limit(10)->findAll();
        $productsLeft = $featuredProducts->splice(0, 2);
        $productsRight = $featuredProducts;
        $categories = $categoryRepository->with(['children'])->where('filename', 'exists', true)->orderBy('is_featured', 'asc')->limit(3)->findAll();

        $feed = FeedReader::read('https://bikebitants.com/feed/')->get_items(0, 4);

        return view('shop.home', compact('layoutHeader', 'layoutTopHeader', 'brands', 'productsLeft', 'productsRight', 'categories', 'feed'));
    }

    /**
     * @param ProductRepository $productRepository
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product(ProductRepository $productRepository, $slug)
    {
        /** @var Product $product */
        $product = $productRepository->with(['category.father', 'brand'])->findBy('slug', $slug);

        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        if (!empty($product->category->father)) {
            Breadcrumbs::addCrumb($product->category->father->name, route('shop.category', [
                'category' => $product->category->father->slug
            ]));
            $routeName = 'shop.subcategory';
            $routeParams = [
                'category' => $product->category->father->slug,
                'subcategory' => $product->category->slug
            ];
        } else {
            $routeName = 'shop.category';
            $routeParams = [
                'category' => $product->category->slug
            ];
        }
        Breadcrumbs::addCrumb($product->category->name, route($routeName, $routeParams));
        Breadcrumbs::addCrumb($product->name);

        MetaTag::set('title', $product->meta_title);
        MetaTag::set('description', $product->meta_description);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $product->front_image->filename]));

        $title = $product->category->name;
        $subtitle = $product->name;

        $relatedProducts = $productRepository
            ->where('brand_id', $product->brand_id)
            ->where('_id', '!=', $product->_id)
            ->limit(4)
            ->findAll();
        return view('shop.product', compact('product', 'relatedProducts', 'title', 'subtitle'));
    }

    /**
     * @param BrandRepository $brandRepository
     * @param ProductRepository $productRepository
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand(BrandRepository $brandRepository, ProductRepository $productRepository, $slug)
    {
        /** @var Brand $brand */
        $brand = $brandRepository->findBy('slug', $slug);
        $products = $productRepository->where('brand_id', $brand->_id)->findAll();

        MetaTag::set('title', $brand->meta_title);
        MetaTag::set('description', $brand->meta_description);
        MetaTag::set('slug', $brand->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $brand->filename]));

        return view('shop.brand', compact('brand', 'products'));
    }

    /**
     * @param Request $request
     * @param ProductSearch $productSearch
     * @param Route $route
     * @param Category $categoryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shop(Request $request, ProductSearch $productSearch, Route $route, CategoryRepository $categoryRepository)
    {
        Breadcrumbs::addCrumb(trans('layout.shop'));

        $title = trans('layout.home');
        $subtitle = trans('layout.shop');
        $selectedCat = '';

        $productSearch->setFilters($request);
        $productSearch->setRoute($route);
        $products = $productSearch->apply();
        $filters = $productSearch->getFilters();
        $categories = $categoryRepository->with(['children'])->where('father_id', null)->orderBy('name', 'asc')->findAll();


        MetaTag::set('title', 'Bikebitants shop');
        MetaTag::set('description', 'This is the meta description');
        MetaTag::set('slug', 'some meta tags here');

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }

    /**
     * @param Request $request
     * @param ProductSearch $productSearch
     * @param Route $route
     * @param Category $categoryRepository
     * @param string $slugCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request, ProductSearch $productSearch, Route $route, CategoryRepository $categoryRepository, $slugCategory)
    {
        /** @var Category $cat */
        $cat = $categoryRepository->findBy('slug', $slugCategory);
        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        Breadcrumbs::addCrumb($cat->name, route('shop.category', ['category' => $cat->slug]));

        MetaTag::set('title', $cat->meta_title);
        MetaTag::set('description', $cat->meta_description);
        MetaTag::set('slug', $cat->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $cat->filename]));

        $title = trans('layout.shop');
        $subtitle = $cat->name;
        $selectedCat = $cat->_id;

        $productSearch->setFilters($request);
        $productSearch->setRoute($route);
        $products = $productSearch->apply();
        $filters = $productSearch->getFilters();
        $categories = $categoryRepository->with(['children'])->where('father_id', null)->orderBy('name', 'asc')->findAll();

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }

    /**
     * @param Request $request
     * @param ProductSearch $productSearch
     * @param Route $route
     * @param Category $categoryRepository
     * @param string $slugCategory
     * @param string $slugSubCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subcategory(Request $request, ProductSearch $productSearch, Route $route, CategoryRepository $categoryRepository, $slugCategory, $slugSubCategory)
    {
        /** @var Category $cat */
        $cat = $categoryRepository->findBy('slug', $slugCategory);
        $subCat = $categoryRepository->findBy('slug', $slugSubCategory);

        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        Breadcrumbs::addCrumb($cat->name, route('shop.category', ['category' => $cat->slug]));
        Breadcrumbs::addCrumb($subCat->name);

        MetaTag::set('title', $subCat->meta_title);
        MetaTag::set('description', $subCat->meta_description);
        MetaTag::set('slug', $subCat->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $subCat->filename]));

        $title = $cat->name;
        $subtitle = $subCat->name;
        $selectedCat = $cat->_id;

        $productSearch->setFilters($request);
        $productSearch->setRoute($route);
        $products = $productSearch->apply();
        $filters = $productSearch->getFilters();
        $categories = $categoryRepository->with(['children'])->where('father_id', null)->orderBy('name', 'asc')->findAll();

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }
}
