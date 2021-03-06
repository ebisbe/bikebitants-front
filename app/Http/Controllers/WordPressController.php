<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WpApi;

class WordPressController extends Controller
{
    public function __construct()
    {
        if (config('app.env') == 'production') {
            abort(404, 'Not found');
        }
    }

    public function show($command, Request $request)
    {
        if ($command == '-') {
            $command = '';
        }

        $response = WpApi::$command($request->get('page', 1));
        
        $item = $request->get('item', null);
        if (!is_null($item)) {
            dd($response[$item]);
        } else {
            dd($response);
        }
    }
}
