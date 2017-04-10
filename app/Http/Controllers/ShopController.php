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
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use MetaTag;
use Breadcrumbs;
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
    public function __construct(
        ProductSearch $productSearch,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        ProductRepository $productRepository
    ) {
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
     * @return Response
     */
    public function home()
    {
        $brands = collect();/*$this->brandRepository->findAll()*/
        $featuredProducts = $this->productRepository
            ->with(['category', 'brand'])
            ->where('is_featured', true)
            ->limit(10)->findAll();
        $productsLeft = $featuredProducts->splice(0, 2);
        $productsRight = $featuredProducts;
        $categories = $this->categoryRepository
            ->where('filename', 'exists', true)
            ->where('father_id', 'exists', false)
            ->orderBy('name', 'asc')->findAll();

        MetaTag::set('title', trans('home.title'));
        MetaTag::set('description', trans('home.meta_description'));

        $feed = FeedReader::read(config('app.blog_url') . '/feed/')->get_items(0, 4);

        return response()
            ->view(
                'shop.home',
                compact('brands', 'productsLeft', 'productsRight', 'categories', 'feed')
            )
            ->withHeaders(['Cache-Control' => 'public'])
            ->setTtl(60 * 60 * 4);
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
        $product = $this->productRepository
            ->with(['category.father', 'brand', 'up_sell_shop.category.father', 'up_sell_shop.brand'])
            ->findBy('slug', $slug);
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
     * @param $slug
     * @return Response
     */
    public function brand($slug)
    {
        /** @var Brand $brand */
        $brand = $this->brandRepository->findBy('slug', $slug);
        $this->abortIfEmpty($brand);

        $products = $this->productRepository
            ->with('brand', 'category')
            ->where('brand_id', $brand->_id)
            ->orderBy('is_featured', 'desc')
            ->orderBy('prices', 'asc')
            ->findAll();

        MetaTag::set('title', $brand->title);
        MetaTag::set('description', $brand->meta_description);
        //MetaTag::set('slug', $brand->meta_slug);
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $brand->filename]));

        return response()
            ->view('shop.brand', compact('brand', 'products'))
            ->withHeaders(['Cache-Control' => 'public'])
            ->setTtl(60 * 60 * 4);
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Response
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

        return response()
            ->view('shop.catalogue', compact(
                'productsResult',
                'categories',
                'title',
                'subtitle',
                'selectedCat'
            ))
            ->withHeaders(['Cache-Control' => 'public'])
            ->setTtl(60 * 60 * 4);
    }

    /**
     * @param Category $cat
     * @param Request $request
     * @param Route $route
     * @return Response
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

        return response()
            ->view(
                'shop.catalogue',
                compact(
                    'category',
                    'productsResult',
                    'categories',
                    'title',
                    'subtitle',
                    'selectedCat',
                    'selectedSubCat'
                )
            )
            ->withHeaders(['Cache-Control' => 'public'])
            ->setTtl(60 * 60 * 4);
    }

    /**
     * @param string $slugCategory
     * @param string $slugSubCategory
     * @param Request $request
     * @param Route $route
     * @return Response
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

        return response()
            ->view(
                'shop.catalogue',
                compact(
                    'category',
                    'productsResult',
                    'categories',
                    'title',
                    'subtitle',
                    'selectedCat',
                    'selectedSubCat'
                )
            )
            ->withHeaders(['Cache-Control' => 'public'])
            ->setTtl(60 * 60 * 4);
    }

    /**
     * @return Response
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

        return response()
            ->view('shop.bargain', compact('products', 'title', 'subtitle'))
            ->withHeaders(['Cache-Control' => 'public'])
            ->setTtl(60 * 60 * 4);
    }

    /**
     * @param $slug
     * @return Response
     */
    public function tag($slug)
    {
        Breadcrumbs::addCrumb(trans('tag.name'));

        $title = trans('layout.shop');
        $subtitle = $slug;

        MetaTag::set('title', trans('tag.title', ['name' => $slug]));
        MetaTag::set('description', trans('tag.description', ['name' => $slug]));

        $products = $this->productRepository->whereIn('tags', [$slug])->findAll();

        $this->abortIfEmpty($products->isNotEmpty());

        return response()
            ->view('shop.bargain', compact('products', 'title', 'subtitle'))
            ->withHeaders(['Cache-Control' => 'public'])
            ->setTtl(60 * 60 * 4);
    }


    /**
     * Abort if entity received is empty
     * @param $entity
     */
    public function abortIfEmpty($entity)
    {
        if (empty($entity)) {
            MetaTag::set('title', trans('exceptions.page_not_found'));
            MetaTag::set('description', trans('exceptions.description'));
            abort(404, trans('exceptions.page_not_found'));
        }
    }
}
