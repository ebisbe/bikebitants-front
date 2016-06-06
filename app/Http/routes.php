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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tienda/{slug}', 'ShopController@brand')->name('shop.brand');

Route::resource('cart', 'CartController');

Route::get('/product/{slug}', 'ShopController@product')->name('shop.product');

Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');