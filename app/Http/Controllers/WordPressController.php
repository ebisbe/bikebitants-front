<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class WordPressController extends Controller
{
    public function show($command, Request $request)
    {
        dd(\Woocommerce::get($command, ['page' => $request->get('page', 1), 'search' => $request->get('search', '')]));
    }
}