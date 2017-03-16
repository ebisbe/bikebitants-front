<?php

namespace App\Http\Controllers;

use App\Business\Services\WordpressService;
use Illuminate\Http\Request;

use App\Http\Requests;

class WordPressController extends Controller
{
    public function __construct()
    {
        if (config('app.env') == 'production') {
            abort(404, 'Not found');
        }
    }

    public function index(WordpressService $wordpressService)
    {
        //$wordpressService->import('products/categories', 'syncCategory');
    }

    public function show($command, Request $request)
    {
        if ($command == '-') {
            $command = '';
        }

        $response = \Woocommerce::get(
            str_replace('_', '/', $command),
            ['page' => $request->get('page', 1), 'search' => $request->get('search', '')]
        );
        
        $item = $request->get('item', null);
        if (!is_null($item)) {
            dd($response[$item]);
        } else {
            dd($response);
        }
    }
}
