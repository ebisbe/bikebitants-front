<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class WordPressController extends Controller
{
    public function index()
    {
        dd(\Woocommerce::get('', ['page' => 1]));
    }
}