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

    protected $productSearch;
    protected $categoryRepository;
    protected $brandRepository;
    protected $productRepository;

    /**
     * ShopController constructor.
     * @param ProductSearch $productSearch
     * @param CategoryRepository $categoryRepository
     * @param BrandRepository $brandRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductSearch $productSearch, CategoryRepository $categoryRepository, BrandRepository $brandRepository, ProductRepository $productRepository)
    {
        $this->productSearch = $productSearch;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
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
        $layoutHeader = 'navbar-transparent navbar-fixed-top';
        $layoutTopHeader = 'hidden';

        $brands = collect();/*$this->brandRepository->findAll()*/
        $featuredProducts = $this->productRepository->where('is_featured', true)->limit(10)->findAll();
        $productsLeft = $featuredProducts->splice(0, 2);
        $productsRight = $featuredProducts;
        $categories = $this->categoryRepository
            ->where('filename', 'exists', true)
            ->where('father_id', 'exists', false)
            ->orderBy('name', 'asc')->findAll();

        $feed = FeedReader::read('https://bikebitants.com/feed/')->get_items(0, 4);

        return view('shop.home', compact('layoutHeader', 'layoutTopHeader', 'brands', 'productsLeft', 'productsRight', 'categories', 'feed'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function slug($slug)
    {
        /** @var Product $product */
        $product = $this->productRepository->with(['category.father', 'brand'])->findBy('slug', $slug);
        if (!empty($product)) {
            return $this->product($product);
        }

        /** @var Category $cat */
        $cat = $this->categoryRepository->findBy('slug', $slug);
        if (!empty($cat)) {
            return $this->category($cat);
        }

        abort(404, 'Not found');
    }

    /**
     * @param $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product(Product $product)
    {

        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        if (!empty($product->category->father)) {
            Breadcrumbs::addCrumb($product->category->father->name, route('shop.slug', [
                'category' => $product->category->father->slug
            ]));
            $routeName = 'shop.subslug';
            $routeParams = [
                'slug' => $product->category->father->slug,
                'subslug' => $product->category->slug
            ];
        } else {
            $routeName = 'shop.slug';
            $routeParams = [
                'slug' => $product->category->slug
            ];
        }
        Breadcrumbs::addCrumb($product->category->name, route($routeName, $routeParams));
        Breadcrumbs::addCrumb($product->name);

        MetaTag::set('title', $product->meta_title);
        MetaTag::set('description', $product->meta_description);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $product->front_image->filename]));

        $title = $product->category->name;
        $subtitle = $product->name;

        $relatedProducts = $this->productRepository
            ->where('brand_id', $product->brand_id)
            ->where('_id', '!=', $product->_id)
            ->limit(4)
            ->findAll();
        return view('shop.product', compact('product', 'relatedProducts', 'title', 'subtitle'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand($slug)
    {
        /** @var Brand $brand */
        $brand = $this->brandRepository->findBy('slug', $slug);
        $products = $this->productRepository->where('brand_id', $brand->_id)->findAll();

        MetaTag::set('title', $brand->meta_title);
        MetaTag::set('description', $brand->meta_description);
        MetaTag::set('slug', $brand->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $brand->filename]));

        return view('shop.brand', compact('brand', 'products'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shop()
    {
        Breadcrumbs::addCrumb(trans('layout.shop'));

        $title = trans('layout.home');
        $subtitle = trans('layout.shop');
        $selectedCat = '';

        $products = $this->productSearch->apply();
        $filters = $this->productSearch->getFilters();
        $categories = $this->categoryRepository->with(['children'])->where('father_id', null)->orderBy('name', 'asc')->findAll();


        MetaTag::set('title', 'Bikebitants shop');
        MetaTag::set('description', 'This is the meta description');
        MetaTag::set('slug', 'some meta tags here');

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }

    /**
     * @param Category $slugCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Category $cat)
    {

        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        Breadcrumbs::addCrumb($cat->name, route('shop.slug', ['category' => $cat->slug]));

        MetaTag::set('title', $cat->meta_title);
        MetaTag::set('description', $cat->meta_description);
        MetaTag::set('slug', $cat->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $cat->filename]));

        $title = trans('layout.shop');
        $subtitle = $cat->name;
        $selectedCat = $cat->_id;

        $products = $this->productSearch->apply();
        $filters = $this->productSearch->getFilters();
        $categories = $this->categoryRepository->with(['children'])->where('father_id', null)->orderBy('name', 'asc')->findAll();

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }

    /**
     * @param string $slugCategory
     * @param string $slugSubCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subslug($slugCategory, $slugSubCategory)
    {
        /** @var Category $cat */
        $cat = $this->categoryRepository->findBy('slug', $slugCategory);
        /** @var Category $subCat */
        $subCat = $this->categoryRepository->findBy('slug', $slugSubCategory);

        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        Breadcrumbs::addCrumb($cat->name, route('shop.slug', ['slug' => $cat->slug]));
        Breadcrumbs::addCrumb($subCat->name);

        MetaTag::set('title', $subCat->meta_title);
        MetaTag::set('description', $subCat->meta_description);
        MetaTag::set('slug', $subCat->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $subCat->filename]));

        $title = $cat->name;
        $subtitle = $subCat->name;
        $selectedCat = $cat->_id;

        $products = $this->productSearch->apply();
        $filters = $this->productSearch->getFilters();
        $categories = $this->categoryRepository->with(['children'])->where('father_id', null)->orderBy('name', 'asc')->findAll();

        return view('shop.catalogue', compact('products', 'filters', 'categories', 'title', 'subtitle', 'selectedCat'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bargain()
    {
        Breadcrumbs::addCrumb(trans('bargain.title'));

        $title = trans('layout.shop');
        $subtitle = trans('bargain.title');

        MetaTag::set('title', 'Ofertas accesorios bicicleta y ciclistas urbanos | Bikebitants');
        MetaTag::set('description', trans('bargain.description'));

        $products = $this->productRepository->findWhere(['is_discounted', '=', true]);

        return view('shop.bargain', compact('products', 'title', 'subtitle'));
    }
}
