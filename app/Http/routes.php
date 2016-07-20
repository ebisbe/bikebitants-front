<?php

/** Admin */
Route::group(['domain' => 'admin.' . env('DOMAIN')], function () {
    Route::auth();
    Route::group(['namespace' => 'Admin'], function () {

        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
    });
});
/** END Admin */

/** Shop */
Route::get('/', 'ShopController@home')->name('shop.home');
Route::get('/brand/{slug}', 'ShopController@brand')->name('shop.brand');
Route::get('/tienda/', 'ShopController@shop')->name('shop.catalogue');
Route::get('/tienda/{slugCategory}/', 'ShopController@category')->name('shop.category');
Route::get('/tienda/{slugCategory}/{slugSubCategory}', 'ShopController@subcategory')->name('shop.subcategory');
Route::get('/product/{slug}', 'ShopController@product')->name('shop.product');
Route::resource('cart', 'CartController');
Route::resource('checkout', 'CheckoutController', ['only' => ['index', 'store']]);
Route::get('/checkout/confirmation', 'CheckoutController@confirmation')->name('shop.confirmation');
Route::get('/checkout/cancel', 'CheckoutController@cancel')->name('shop.cancellation');
Route::resource('lead', 'LeadsController', ['only' => ['store']]);

Route::get('/img/{filter}/{filename}', 'ImagesController@getResponse')
    ->where(array('filename' => '[ \w\\.\\/\\-\\@]+', 'filter' => 'original|download|[0-9]+\/[0-9]+|[0-9]+'))
    ->name('shop.image');
/** END shop */