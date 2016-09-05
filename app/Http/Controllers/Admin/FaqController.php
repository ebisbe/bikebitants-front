<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

use App\Faq;
use Illuminate\Http\Request;
use Session;
use BreadCrumbLinks;
use Breadcrumbs;
use Title;

class FaqController extends AdminController
{
    /**
     * Initialize middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
        Breadcrumbs::addCrumb('Faq', '/faq');
        BreadCrumbLinks::set(['href' => url('faq/create'), 'value' => '<i class="icon-new position-left"></i> Faq']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$this->isAuthorized('faq.index');
        Title::setSemiBold('Faq');
        return view('admin.faq.index');
    }

    /**
    * Return all data for index DataTable filtering and sorting
    *
    * @return array
    */
    public function dataTable() {
        //$this->isAuthorized('faq.data-table');
        return ['data' => Faq::all()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$this->isAuthorized('faq.create');
        Breadcrumbs::addCrumb('Create');
        BreadCrumbLinks::set(['href' => route('faq.edit', ['id' => $id]), 'value' => '<i class="icon-pencil6 position-left"></i> Edit']);
        Title::setSemiBold('New Faq');
        Title::useLeftArrow(true);
        return view('admin.faq.create');
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
        //$this->isAuthorized('faq.store');
        $this->validate($request, ['name' => 'required', 'answer' => 'required', ]);

        Faq::create($request->all());

        Session::flash('flash_message', 'Faq added!');

        return redirect('faq');
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
        //$this->isAuthorized('faq.show');
        $faq = Faq::findOrFail($id);
        Breadcrumbs::addCrumb('View', '/faq/'.$faq->id);
        Title::setSemiBold($faq->name);
        Title::useLeftArrow(true);
        return view('admin.faq.show', compact('faq'));
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
        //$this->isAuthorized('faq.edit');
        $faq = Faq::findOrFail($id);
        Breadcrumbs::addCrumb('Edit', '/faq/'.$faq->id);
        Title::setSemiBold($faq->name);
        Title::useLeftArrow(true);
        return view('admin.faq.edit', compact('faq'));
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
        //$this->isAuthorized('faq.update');
        $this->validate($request, ['name' => 'required', 'answer' => 'required', ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());
        Session::flash('flash_message', 'Faq updated!');

        return redirect('faq');
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
        //$this->isAuthorized('faq.destroy');
        Faq::destroy($id);

        Session::flash('flash_message', 'Faq deleted!');

        return redirect('faq');
    }

}
