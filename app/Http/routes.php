<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Collection;

Route::group(['domain' => 'admin.' . env('DOMAIN')], function () {
    Route::auth();
    Route::group(['namespace' => 'Admin'], function () {

        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
    });
});

Route::get('/tienda/{slug}', 'ShopController@brand')->name('shop.brand');
Route::get('/product/{slug}', 'ShopController@product')->name('shop.product');

Route::resource('cart', 'CartController');
Route::resource('checkout', 'CheckoutController', ['only' => [
    'index', 'store'
]]);

Route::get('/img/{filter}/{filename}', 'ImagesController@getResponse')
    ->where(array('filename' => '[ \w\\.\\/\\-\\@]+', 'filter' => 'original|download|[0-9]+\/[0-9]+|[0-9]+'));

Route::get('/', function () {
    return view('welcome');
});

Form::macro('img', function ($path, $sizes, $alt) {
    /** @var Collection $sizes */
    $srcset = $sizes->map(function ($size, $viewPort) use ($path) {
        return "/img/$size/$path $viewPort";
    })->implode(',');
    return '<img class="img-responsive lazyOwl"
                                 alt="' . $alt . '"
                                 sizes="100w"
                                 srcset="' . $srcset . '">';
});