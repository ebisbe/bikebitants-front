<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

use App\Brand;
use Illuminate\Http\Request;
use Session;
use BreadCrumbLinks;
use Breadcrumbs;
use Title;

class BrandController extends AdminController
{

    /**
     * Initialize middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
        Breadcrumbs::addCrumb('Brand', '/brand');
        BreadCrumbLinks::set(['href' => route('brand.create'), 'value' => '<i class="icon-new position-left"></i> Brand']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$this->isAuthorized('brand.index');
        Title::setSemiBold('Brand');
        return view('admin.brand.index');
    }

    /**
     * Return all data for index DataTable filtering and sorting
     *
     * @return array
     */
    public function dataTable()
    {
        //$this->isAuthorized('brand.data-table');
        return ['data' => Brand::all()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$this->isAuthorized('brand.create');
        Breadcrumbs::addCrumb('Create');
        Title::setSemiBold('New Brand');
        Title::useLeftArrow(true);
        return view('admin.brand.create');
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
        //$this->isAuthorized('brand.store');
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique',
            'description' => 'required',
            'filename' => 'required|image',
            'featured' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_slug' => 'required'
        ]);

        Brand::create($this->saveImage($request));

        Session::flash('flash_message', 'Brand added!');

        return redirect('brand');
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
        //$this->isAuthorized('brand.show');
        $brand = Brand::findOrFail($id);
        Breadcrumbs::addCrumb('View', '/brand/' . $brand->id);
        BreadCrumbLinks::set(['href' => route('brand.edit', ['id' => $id]), 'value' => '<i class="icon-pencil6 position-left"></i> Edit']);
        Title::setSemiBold($brand->name);
        Title::useLeftArrow(true);
        return view('admin.brand.show', compact('brand'));
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
        //$this->isAuthorized('brand.edit');
        $brand = Brand::findOrFail($id);
        Breadcrumbs::addCrumb('Edit', '/brand/' . $brand->id);
        Title::setSemiBold($brand->name);
        Title::useLeftArrow(true);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        //$this->isAuthorized('brand.update');
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique',
            'description' => 'required',
            'filename' => 'required',
            'featured' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_slug' => 'required'
        ]);

        $brand = Brand::findOrFail($id);

        $brand->update($this->saveImage($request));
        Session::flash('flash_message', 'Brand updated!');

        return redirect('brand');
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
        //$this->isAuthorized('brand.destroy');
        Brand::destroy($id);

        Session::flash('flash_message', 'Brand deleted!');

        return redirect('brand');
    }
}
