<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

use App\Category;
use Illuminate\Http\Request;
use Session;
use BreadCrumbLinks;
use Breadcrumbs;
use Title;

class CategoryController extends AdminController
{
    /**
     * Initialize middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
        Breadcrumbs::addCrumb('Category', '/category');
        BreadCrumbLinks::set(['href' => url('category/create'), 'value' => '<i class="icon-new position-left"></i> Category']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$this->isAuthorized('category.index');
        Title::setSemiBold('Category');
        return view('admin.category.index');
    }

    /**
     * @return array
     */
    public function tree()
    {
        //$this->isAuthorized('category.data-table');
        $categories = Category::where('father_id', 'exists', false)->orderBy('order')->get();
        return $categories->map(function ($category) {
            /** @var Category $category */
            return [
                "_id" => $category->_id,
                "title" => $category->name,
                "products" => $category->products,
                'actionButtons' => Category::actionButtons($category->_id),
                "expanded" => false,
                'folder' => true,
                'children' => $category->getOrderedChildren()
            ];
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$this->isAuthorized('category.create');
        Breadcrumbs::addCrumb('Create');
        Title::setSemiBold('New Category');
        Title::useLeftArrow(true);
        return view('admin.category.create');
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
        //$this->isAuthorized('category.store');
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'filename' => 'required|image',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_slug' => 'required'
        ]);

        Category::create($this->saveImage($request));

        Session::flash('flash_message', 'Category added!');

        return redirect('category');
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
        //$this->isAuthorized('category.show');
        $category = Category::findOrFail($id);
        Breadcrumbs::addCrumb('View', '/category/' . $category->id);
        BreadCrumbLinks::set(['href' => route('category.edit', ['id' => $id]), 'value' => '<i class="icon-pencil6 position-left"></i> Edit']);
        Title::setSemiBold($category->name);
        Title::useLeftArrow(true);
        return view('admin.category.show', compact('category'));
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
        //$this->isAuthorized('category.edit');
        $category = Category::findOrFail($id);
        Breadcrumbs::addCrumb('Edit', '/category/' . $category->id);
        Title::setSemiBold($category->name);
        Title::useLeftArrow(true);
        return view('admin.category.edit', compact('category'));
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
        //$this->isAuthorized('category.update');
        $this->validate($request, [
            'name' => 'required',
            'slug' => "required|unique:categories,filename,{$id},_id",
            'filename' => 'image',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_slug' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $category->update($this->saveImage($request));
        Session::flash('flash_message', 'Category updated!');

        return redirect('category');
    }

    /**
     * @param Request $request
     */
    public function updateOrder(Request $request)
    {
        $hitMode = $request->input('hitMode');
        $dragged = Category::find($request->input('dragged'));
        $target = Category::find($request->input('target'));

        $order = $hitMode == 'after' ? 0 : -1;
        $dragged->order = $target->order + $order;
        if (!empty($target->father_id)) {
            $dragged->father_id = $target->father_id;
        } else {
            $dragged->unset('father_id');
        }
        $dragged->save();

        $restartOrder = 1;
        Category::when(!empty($target->father_id), function ($query) use ($target) {
                return $query->where('father_id', $target->father_id);
        })
            ->where('father_id', 'exists', !empty($target->father_id))
            ->orderBy('order')
            ->get()
            ->each(function ($category) use (&$restartOrder) {
                $category->order = $restartOrder++;
                $category->save();
            });
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
        //$this->isAuthorized('category.destroy');
        Category::destroy($id);

        Session::flash('flash_message', 'Category deleted!');

        return redirect('category');
    }
}
