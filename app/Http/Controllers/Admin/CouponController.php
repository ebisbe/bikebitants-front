<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

use App\Coupon;
use Illuminate\Http\Request;
use Session;
use BreadCrumbLinks;
use Breadcrumbs;
use Title;

class CouponController extends AdminController
{
    /**
     * Initialize middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
        Breadcrumbs::addCrumb('Coupon', '/coupon');
        BreadCrumbLinks::set(['href' => url('coupon/create'), 'value' => '<i class="icon-new position-left"></i> Coupon']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$this->isAuthorized('coupon.index');
        Title::setSemiBold('Coupon');
        return view('admin.coupon.index');
    }

    /**
     * Return all data for index DataTable filtering and sorting
     *
     * @return array
     */
    public function dataTable()
    {
        //$this->isAuthorized('coupon.data-table');
        return ['data' => Coupon::all()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$this->isAuthorized('coupon.create');
        Breadcrumbs::addCrumb('Create');
        Title::setSemiBold('New Coupon');
        Title::useLeftArrow(true);
        return view('admin.coupon.create');
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
        //$this->isAuthorized('coupon.store');
        $this->validate($request, [
            'name' => 'required|unique:coupons',
            'value' => 'required',
            'magnitude' => 'required',
            'type' => 'required',
            'expired_at' => 'required',
            'minimum_cart' => 'required',
            'maximum_cart' => 'numeric',
            'limit_usage_by_coupon' => 'numeric',
            'limit_usage_by_user' => 'numeric',
            'single_use' => 'boolean'
        ]);

        Coupon::create($request->all());

        Session::flash('flash_message', 'Coupon added!');

        return redirect('coupon');
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
        //$this->isAuthorized('coupon.show');
        $coupon = Coupon::findOrFail($id);
        Breadcrumbs::addCrumb('View', '/coupon/' . $coupon->id);
        Title::setSemiBold($coupon->name);
        Title::useLeftArrow(true);
        return view('admin.coupon.show', compact('coupon'));
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
        //$this->isAuthorized('coupon.edit');
        $coupon = Coupon::findOrFail($id);
        Breadcrumbs::addCrumb('Edit', '/coupon/' . $coupon->id);
        Title::setSemiBold($coupon->name);
        Title::useLeftArrow(true);
        return view('admin.coupon.edit', compact('coupon'));
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
        //$this->isAuthorized('coupon.update');
        $this->validate($request, [
            'name' => 'required|unique:coupons,name,'.$id.',_id',
            'value' => 'required',
            'magnitude' => 'required',
            'type' => 'required',
            'expired_at' => 'required',
            'minimum_cart' => 'required',
            'maximum_cart' => 'numeric',
            'limit_usage_by_coupon' => 'numeric',
            'limit_usage_by_user' => 'numeric',
            'single_use' => 'boolean',
            //'emails' => 'regex:' . \StaticVars::emailValidation(),

        ]);

        $coupon = Coupon::findOrFail($id);

        $coupon->update($request->all());
        Session::flash('flash_message', 'Coupon updated!');

        return redirect('coupon');
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
        //$this->isAuthorized('coupon.destroy');
        Coupon::destroy($id);

        Session::flash('flash_message', 'Coupon deleted!');

        return redirect('coupon');
    }
}
