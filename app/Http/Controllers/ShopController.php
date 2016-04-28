<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ShopController extends Controller
{
    //

    public function home()
    {
        return view('shop.home');
    }

    public function product()
    {
        return view('shop.product');
    }
}
