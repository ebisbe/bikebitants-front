<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
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

    /**
     * Checks if the request has a file and isValid(). Saves the file to the storage.
     * @param Request $request
     * @param string $fileNameOnRequest
     * @return string $filename
     */
    protected function saveImage(Request $request, $fileNameOnRequest = 'filename')
    {
        $data = $request->all();
        if (!$request->hasFile($fileNameOnRequest)) {
            unset($data[$fileNameOnRequest]);
            return $data;
        }

        if (!$request->file($fileNameOnRequest)->isValid()) {
            redirect()->back()->withErrors(['msg', 'Error uploading the image.']);
        }

        $filename = $request->input('slug') . '.' . $request->file($fileNameOnRequest)->getClientOriginalExtension();
        $request->file('filename')->move(storage_path('app'), $filename);

        return array_merge($data, [$fileNameOnRequest => $filename]);
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
