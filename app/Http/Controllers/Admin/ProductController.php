<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Business\Services\ProductService;
use App\Http\Requests;

use App\Product;
use Illuminate\Http\Request;
use Session;
use BreadCrumbLinks;
use Breadcrumbs;
use Title;

class ProductController extends AdminController
{
    /**
     * Initialize middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
        Breadcrumbs::addCrumb('Product', '/product');
        BreadCrumbLinks::set(['href' => url('product/create'), 'value' => '<i class="icon-new position-left"></i> Product']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$this->isAuthorized('product.index');
        Title::setSemiBold('Product');

        $products = Product::paginate(15);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$this->isAuthorized('product.create');
        Breadcrumbs::addCrumb('Create');
        Title::setSemiBold('New Product');
        Title::useLeftArrow(true);
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        //$this->isAuthorized('product.store');
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'introduction' => 'required',
            'description' => 'required',
            'featured' => 'filled|boolean',
            'discounted' => 'filled|boolean',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_slug' => 'required'
        ]);
        Product::create($request->all());

        Session::flash('flash_message', 'Product added!');

        return redirect('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        //$this->isAuthorized('product.show');
        $product = Product::findOrFail($id);
        Breadcrumbs::addCrumb('View', '/product/' . $product->id);
        BreadCrumbLinks::set(['href' => route('product.edit', ['id' => $id]), 'value' => '<i class="icon-pencil6 position-left"></i> Edit']);
        Title::setSemiBold($product->name);
        Title::useLeftArrow(true);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //$this->isAuthorized('product.edit');
        $product = Product::findOrFail($id);
        Breadcrumbs::addCrumb('Edit', '/product/' . $product->id);
        Title::setSemiBold($product->name);
        Title::useLeftArrow(true);
        return view('admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        //$this->isAuthorized('product.update');
        $this->validate($request, [
            'name' => 'filled',
            'slug' => 'filled',
            'status' => 'filled',
            'introduction' => 'filled',
            'description' => 'filled',
            'featured' => 'filled|boolean',
            'discounted' => 'filled|boolean',
            'meta_title' => 'filled',
            'meta_description' => 'filled',
            'meta_slug' => 'filled'
        ]);
        $product = Product::findOrFail($id);
        $product->update($request->all());

        $message = "Product '{$product->name}' updated!";
        if ($request->ajax()) {
            return ['message' => $message];
        }

        Session::flash('flash_message', $message);
        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        //$this->isAuthorized('product.destroy');
        Product::destroy($id);

        Session::flash('flash_message', 'Product deleted!');

        return redirect('product');
    }

    /**
     * Get all Product status
     * @return array
     */
    public function status()
    {
        return [
            Product::DRAFT => ['_id' => Product::DRAFT, 'text' => trans('Product.' . Product::DRAFT), 'class' => Product::DRAFT_CLASS],
            Product::PUBLISHED => ['_id' => Product::PUBLISHED, 'text' => trans('Product.' . Product::PUBLISHED), 'class' => Product::PUBLISHED_CLASS],
            Product::HIDDEN => ['_id' => Product::HIDDEN, 'text' => trans('Product.' . Product::HIDDEN), 'class' => Product::HIDDEN_CLASS],
        ];
    }

    /**
     * Duplicates a product.
     * @param $id
     * @param ProductService $productService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function duplicate($id, ProductService $productService)
    {
        $productService::duplicate($id);

        Session::flash('flash_message', 'Product duplicated!');

        return redirect('product');
    }
}
