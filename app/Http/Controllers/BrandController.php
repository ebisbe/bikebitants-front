<?php

namespace App\Http\Controllers;

use App\Business\Models\Shop\Brand;
use App\Business\Repositories\BrandRepository;
use App\Business\Repositories\ProductRepository;
use MetaTag;
use Breadcrumbs;

class BrandController extends Controller
{
    /**
     * @var BrandRepository
     */
    private $brandRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * BrandController constructor.
     * @param BrandRepository $brandRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(BrandRepository $brandRepository, ProductRepository $productRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;

        Breadcrumbs::setCssClasses('breadcrumb');
        Breadcrumbs::setListElement('ol');
        Breadcrumbs::setDivider('');
        Breadcrumbs::addCrumb(trans('layout.home'), route('shop.home'));
    }

    public function brands()
    {
        $brands = $this->brandRepository->findAll();
        $title = trans('layout.shop');
        $subtitle = trans('layout.brands');

        Breadcrumbs::addCrumb(trans('layout.shop'), route('shop.catalogue'));
        Breadcrumbs::addCrumb($subtitle);

        return view('shop.brands', compact('brands', 'title', 'subtitle'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
        MetaTag::set('image', route('shop.image', ['filter' => '600', 'filename' => $brand->filename]));

        return view('shop.brand', compact('brand', 'products'));
    }
}
