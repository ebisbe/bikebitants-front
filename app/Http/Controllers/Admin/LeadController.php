<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

use App\Lead;
use Illuminate\Http\Request;
use Session;
use BreadCrumbLinks;
use Breadcrumbs;
use Title;

class LeadController extends AdminController
{
    /**
     * Initialize middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
        Breadcrumbs::addCrumb('Lead', '/lead');
        BreadCrumbLinks::set(['href' => url('lead/create'), 'value' => '<i class="icon-new position-left"></i> Lead']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$this->isAuthorized('lead.index');
        Title::setSemiBold('Lead');
        return view('admin.lead.index');
    }

    /**
    * Return all data for index DataTable filtering and sorting
    *
    * @return array
    */
    public function dataTable() {
        //$this->isAuthorized('lead.data-table');
        return ['data' => Lead::all()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$this->isAuthorized('lead.create');
        Breadcrumbs::addCrumb('Create');
        Title::setSemiBold('New Lead');
        Title::useLeftArrow(true);
        return view('admin.lead.create');
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
        //$this->isAuthorized('lead.store');
        $this->validate($request, ['email' => 'required|unique|email', 'type' => 'required', ]);

        Lead::create($request->all());

        Session::flash('flash_message', 'Lead added!');

        return redirect('lead');
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
        //$this->isAuthorized('lead.show');
        $lead = Lead::findOrFail($id);
        Breadcrumbs::addCrumb('View', '/lead/'.$lead->id);
        Title::setSemiBold($lead->name);
        Title::useLeftArrow(true);
        return view('admin.lead.show', compact('lead'));
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
        //$this->isAuthorized('lead.edit');
        $lead = Lead::findOrFail($id);
        Breadcrumbs::addCrumb('Edit', '/lead/'.$lead->id);
        Title::setSemiBold($lead->name);
        Title::useLeftArrow(true);
        return view('admin.lead.edit', compact('lead'));
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
        //$this->isAuthorized('lead.update');
        $this->validate($request, ['email' => 'required|unique|email', 'type' => 'required', ]);

        $lead = Lead::findOrFail($id);
        $lead->update($request->all());
        Session::flash('flash_message', 'Lead updated!');

        return redirect('lead');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        //$this->isAuthorized('lead.destroy');
        Lead::destroy($id);

        Session::flash('flash_message', 'Lead deleted!');

        return redirect('lead');
    }

}
