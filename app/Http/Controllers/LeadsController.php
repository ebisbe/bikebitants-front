<?php

namespace App\Http\Controllers;

use App\Facades\StaticVars;
use App\Lead;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\URL;

class LeadsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:leads,email',
        ]);

        $lead = Lead::create($request->all());

        \Mail::send('emails.new_lead', [], function ($m) use ($lead) {
            $m->from(StaticVars::email(), StaticVars::company());

            $m->to($lead->email)->subject('Your discount!');
        });

        if ($request->ajax()) {
            return ['response' => 'Your discount is on the way!'];
        } else {
            \Session::flash('flash_message', 'Your discount is on the way!');
            return redirect(URL::previous());
        }
    }
}
