<?php

namespace App\Http\Controllers;

use App\Business\Models\Shop\Category;
use App\Business\Models\Shop\Product;
use App\Business\Repositories\CategoryRepository;
use App\Business\Repositories\TagRepository;
use App\Business\Search\ProductSearch;
use App\Business\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use MetaTag;
use Breadcrumbs;
use \FeedReader;

class ShopController extends Controller
{

    protected $productSearch;
    protected $categoryRepository;
    protected $productRepository;

    /**
     * ShopController constructor.
     * @param ProductSearch $productSearch
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductSearch $productSearch,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ) {
        $this->productSearch = $productSearch;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;

        Breadcrumbs::setCssClasses('breadcrumb');
        Breadcrumbs::setListElement('ol');
        Breadcrumbs::setDivider('');
        Breadcrumbs::addCrumb(trans('layout.home'), route('shop.home'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $brands = collect();
        $featuredProducts = $this->productRepository
            ->with(['category', 'brand'])
            ->where('is_featured', true)
            ->orderBy('menu_order')
            ->limit(10)
            ->findAll();

        $productsLeft = $featuredProducts->splice(0, 2);
        $productsRight = $featuredProducts;
        $categories = $this->categoryRepository
            // its not really necesary but avoids showing more categories due to
            //the way data is downloaded from the api
            ->where('filename', '!=', null)
            ->where('father_id', 'exists', false)
            ->orderBy('name', 'asc')->findAll();

        MetaTag::set('title', trans('home.title'));
        MetaTag::set('description', trans('home.meta_description'));

        $feed = FeedReader::read(config('app.blog_url') . '/feed/')->get_items(0, 4);

        return view(
            'shop.home',
            compact('brands', 'productsLeft', 'productsRight', 'categories', 'feed')
        );
    }

    /**
     * @param string $slug
     * @param Request $request
     * @param Route $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function slug($slug, Request $request, Route $route)
    {
        /** @var Product $product */
        $product = Product::withoutGlobalScopes()
            ->with(['category.father', 'brand', 'up_sell_shop.category.father', 'up_sell_shop.brand', 'tag'])
            ->where('slug', '=', $slug)
            ->whereIn('status', [2, 3])
            ->first();

        if (!empty($product)) {
            return $this->product($product);
        }

        /** @var Category $cat */
        $cat = $this->categoryRepository->findBy('slug', $slug);
        if (!empty($cat)) {
            return $this->category($cat, $request, $route);
        }

        abort(404, trans('exceptions.page_not_found'));
    }

    /**
     * @param $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product(Product $product)
    {
        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        $category = $product->category->first();
        if (!empty($category->father)) {
            Breadcrumbs::addCrumb($category->father->name, route('shop.slug', [
                'category' => $category->father->slug
            ]));
            $routeName = 'shop.subslug';
            $routeParams = [
                'slug' => $category->father->slug,
                'subslug' => $category->slug
            ];
        } else {
            $routeName = 'shop.slug';
            $routeParams = [
                'slug' => $category->slug
            ];
        }
        Breadcrumbs::addCrumb($category->name, route($routeName, $routeParams));
        Breadcrumbs::addCrumb($product->name);

        MetaTag::set('title', $product->title);
        MetaTag::set('description', $product->meta_desc);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $product->front_image->filename]));

        $title = $category->name;
        $subtitle = $product->name;

        $relatedProducts = $product
            ->up_sell_shop;
        return view('shop.product', compact('product', 'relatedProducts', 'title', 'subtitle'));
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function catalogue(Request $request, Route $route)
    {
        Breadcrumbs::addCrumb(trans('layout.shop'));

        $title = trans('layout.home');
        $subtitle = trans('layout.shop');
        $selectedCat = '';

        MetaTag::set('title', trans('layout.shop_title'));
        MetaTag::set('description', trans('layout.shop_meta_description'));
        //MetaTag::set('slug', 'some meta tags here');

        $this->productSearch->applyFilters($request->all() + $route->parameters());
        $productsResult = $this->productSearch->apply();
        $categories = $this->categoryRepository
            ->with(['children'])
            ->where('father_id', null)
            ->orderBy('name', 'asc')
            ->findAll();

        return view('shop.catalogue', compact(
            'productsResult',
            'categories',
            'title',
            'subtitle',
            'selectedCat'
        ));
    }

    /**
     * @param Category $cat
     * @param Request $request
     * @param Route $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Category $slugCategory
     */
    public function category(Category $cat, Request $request, Route $route)
    {

        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        Breadcrumbs::addCrumb($cat->name, route('shop.slug', ['category' => $cat->slug]));

        MetaTag::set('title', $cat->title);
        MetaTag::set('description', $cat->meta_description);
        //MetaTag::set('slug', $cat->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $cat->filename]));

        $title = trans('layout.shop');
        $subtitle = $cat->name;
        $selectedCat = $cat->_id;
        $selectedSubCat = null;
        $category = $cat;

        $this->productSearch->applyFilters($request->all() + $route->parameters());
        $productsResult = $this->productSearch->apply();

        $categories = $this->categoryRepository
            ->with(['children'])
            ->where('father_id', null)
            ->orderBy('name', 'asc')
            ->findAll();

        return view(
            'shop.catalogue',
            compact('category', 'productsResult', 'categories', 'title', 'subtitle', 'selectedCat', 'selectedSubCat')
        );
    }

    /**
     * @param string $slugCategory
     * @param string $slugSubCategory
     * @param Request $request
     * @param Route $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subslug($slugCategory, $slugSubCategory, Request $request, Route $route)
    {
        /** @var Category $cat */
        $cat = $this->categoryRepository->findBy('slug', $slugCategory);
        /** @var Category $subCat */
        $subCat = $this->categoryRepository->findBy('slug', $slugSubCategory);

        $this->abortIfEmpty($cat);
        $this->abortIfEmpty($subCat);

        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        Breadcrumbs::addCrumb($cat->name, route('shop.slug', ['slug' => $cat->slug]));
        Breadcrumbs::addCrumb($subCat->name);

        MetaTag::set('title', $subCat->title);
        MetaTag::set('description', $subCat->meta_description);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $subCat->filename]));

        $title = $cat->name;
        $subtitle = $subCat->name;
        $selectedCat = $cat->_id;
        $selectedSubCat = $subCat->_id;
        $category = $subCat;

        $this->productSearch->applyFilters($request->all() + $route->parameters());
        $productsResult = $this->productSearch->apply();
        $categories = $this->categoryRepository
            ->with(['children'])
            ->where('father_id', null)
            ->orderBy('name', 'asc')
            ->findAll();

        return view(
            'shop.catalogue',
            compact('category', 'productsResult', 'categories', 'title', 'subtitle', 'selectedCat', 'selectedSubCat')
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bargain()
    {
        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        Breadcrumbs::addCrumb(trans('bargain.title'));

        $title = trans('layout.shop');
        $subtitle = trans('bargain.title');

        MetaTag::set('title', trans('bargain.meta_title'));
        MetaTag::set('description', trans('bargain.description'));

        $products = $this->productRepository
            ->with(['brand', 'category'])
            ->where('is_discounted', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('prices', 'asc')
            ->findAll();

        return view('shop.bargain', compact('products', 'title', 'subtitle'));
    }

    /**
     * @param $slug
     * @param TagRepository $tagRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($slug, TagRepository $tagRepository)
    {
        Breadcrumbs::addCrumb(trans('tag.name'));

        $tagQuery = $tagRepository->with(['products_shop.brand', 'products_shop.category']);
        $tag = $tagQuery->findBy('slug', $slug);

        if (is_null($tag)) {
            $tag = $tagQuery->findBy('name', $slug);
            if (!is_null($tag)) {
                return redirect(\route('shop.tag', ['slug' => $tag->slug]), 301);
            }
        }

        $this->abortIfEmpty($tag);

        $title = trans('layout.shop');
        $subtitle = $tag->name;

        MetaTag::set('title', $tag->name);
        MetaTag::set('description', $tag->description);

        return view('shop.tag', compact('tag', 'title', 'subtitle'));
    }
}
