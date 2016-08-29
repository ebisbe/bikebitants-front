<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Breadcrumbs;

class AdminController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
        Breadcrumbs::addCrumb('<i class="icon-home2 position-left"></i> Dashboard', '/');
        Breadcrumbs::setCssClasses('breadcrumb');
        Breadcrumbs::setDivider('');
    }

    /*public function isAuthorized($routeName) {
        if(!\Auth::user()->canDo($routeName)) {
            abort(403, 'Unauthorized action.');
        }
    }*/

    public function dashboard()
    {
        return view('dashboard');
    }
}
