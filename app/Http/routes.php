<?php

/** Admin */
Route::group(['domain' => 'admin_' . env('DOMAIN')], function () {
    Route::auth();
    Route::get('/', 'Admin\\AdminController@dashboard')->name('admin.dashboard');

    Route::get('brand/data-table', 'Admin\\BrandController@dataTable')->name('brand.data-table');
    Route::resource('brand', 'Admin\\BrandController');

    Route::get('coupon/types', 'Admin\\CouponController@types')->name('coupon.types');
    Route::get('coupon/data-table', 'Admin\\CouponController@dataTable')->name('coupon.data-table');
    Route::resource('coupon', 'Admin\\CouponController');

    Route::get('lead/data-table', 'Admin\\LeadController@dataTable')->name('lead.data-table');
    Route::resource('lead', 'Admin\\LeadController');
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
Route::resource('checkout', 'CheckoutController', ['only' => ['index', 'store', 'show']]);
Route::get('/checkout/cancel', 'CheckoutController@cancel')->name('shop.cancellation');
Route::resource('lead', 'LeadsController', ['only' => ['store']]);
Route::resource('coupon', 'CouponController', ['only' => ['store']]);
Route::resource('cart-conditions', 'CartConditionsController', ['only' => ['index', 'store']]);

Route::get('/img/{filter}/{filename}', 'ImagesController@getResponse')
    ->where(array('filename' => '[ \w\\.\\/\\-\\@]+', 'filter' => 'original|download|[0-9]+\/[0-9]+|[0-9]+'))
    ->name('shop.image');
/** END shop */
