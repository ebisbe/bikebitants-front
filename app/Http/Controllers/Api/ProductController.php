<?php

namespace App\Http\Controllers\Api;

use App\Business\Repositories\ProductRepository;
use App\Business\Search\ProductSearch;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;


class ProductController extends ApiController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(ProductSearch $productSearch, Request $request)
    {
        $productSearch->applyFilters($request->all());
        return $productSearch->apply()->products();
    }

    public function show($product)
    {
        return $this->productRepository->findBy('_id', $product);
    }
}
