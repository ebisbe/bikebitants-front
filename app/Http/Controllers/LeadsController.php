<?php

namespace App\Http\Controllers;

use App\Jobs\MailChimp;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

class LeadsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $this->dispatch(new MailChimp($request->get('email')));

        if ($request->ajax()) {
            return ['response' => 'Your discount is on the way!'];
        } else {
            \Session::flash('flash_message', 'Your discount is on the way!');
            return redirect(URL::previous());
        }
    }
}
