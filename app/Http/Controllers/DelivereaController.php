<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Deliverea;

class DelivereaController extends Controller
{
    public function clientCarriers()
    {
        //$response = Deliverea::getClientServices(null, null, null, null, 1);
        $response = Deliverea::getAddresses();

        dd($response);
    }
}
