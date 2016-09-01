<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

use App\Country;
use Illuminate\Http\Request;
use Session;
use BreadCrumbLinks;
use Breadcrumbs;
use Title;

class CountryController extends AdminController
{
    /**
     * Initialize middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
        Breadcrumbs::addCrumb('Country', '/country');
        //BreadCrumbLinks::set(['href' => url('country/create'), 'value' => '<i class="icon-new position-left"></i> Country']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$this->isAuthorized('country.index');
        Title::setSemiBold('Country');
        return view('admin.country.index');
    }

    /**
    * Return all data for index DataTable filtering and sorting
    *
    * @return array
    */
    public function dataTable() {
        //$this->isAuthorized('country.data-table');
        return ['data' => Country::withoutGlobalScope('active')->get()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$this->isAuthorized('country.create');
        Breadcrumbs::addCrumb('Create');
        Title::setSemiBold('New Country');
        Title::useLeftArrow(true);
        return view('admin.country.create');
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
        //$this->isAuthorized('country.store');
        $this->validate($request, ['name' => 'required', 'active' => 'required', ]);

        Country::create($request->all());

        Session::flash('flash_message', 'Country added!');

        return redirect('country');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        //$this->isAuthorized('country.show');
        $country = Country::withoutGlobalScope('active')->findOrFail($id);
        Breadcrumbs::addCrumb('View', '/country/'.$country->id);
        Title::setSemiBold($country->name);
        Title::useLeftArrow(true);
        return view('admin.country.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //$this->isAuthorized('country.edit');
        $country = Country::withoutGlobalScope('active')->findOrFail($id);
        Breadcrumbs::addCrumb('Edit', '/country/'.$country->id);
        Title::setSemiBold($country->name);
        Title::useLeftArrow(true);
        return view('admin.country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int  $id
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        //$this->isAuthorized('country.update');
        $this->validate($request, ['name' => 'required', 'active' => 'required', ]);

        $country = Country::withoutGlobalScope('active')->findOrFail($id);
        $country->update($request->all());
        Session::flash('flash_message', 'Country updated!');

        return redirect('country');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    public function destroy($id)
    {
        //$this->isAuthorized('country.destroy');
        Country::destroy($id);

        Session::flash('flash_message', 'Country deleted!');

        return redirect('country');
    }*/

}
