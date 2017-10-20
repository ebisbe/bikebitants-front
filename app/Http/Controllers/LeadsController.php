<?php

namespace App\Http\Controllers;

use App\Business\Services\NewsletterManager;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

class LeadsController extends Controller
{
    public function store(Request $request, NewsletterManager $newsletterManager)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        try {
            $status = $newsletterManager->addEmailToList($request->get('email'));
            $message = $status ? __('layout.lead.ok') : __('layout.lead.ko');
        } catch (\Mailchimp_Error $exception) {
            $message = __('layout.lead.error');
        }

        if ($request->ajax()) {
            return ['response' => $message];
        } else {
            \Session::flash('flash_message', $message);
            return redirect(URL::previous());
        }
    }
}
