<?php
use Illuminate\Support\Collection;

/** Admin */
Route::group(['domain' => 'admin.' . env('DOMAIN')], function () {
    Route::auth();
    Route::group(['namespace' => 'Admin'], function () {

        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
    });
});
/** END Admin */

/** Shop */
Route::get('/tienda/{slug}', 'ShopController@brand')->name('shop.brand');
Route::get('/tienda/', 'ShopController@shopping')->name('shop.catalogue');
Route::get('/product/{slug}', 'ShopController@product')->name('shop.product');
Route::resource('cart', 'CartController');
Route::resource('checkout', 'CheckoutController', ['only' => ['index', 'store']]);
Route::resource('lead', 'LeadsController', ['only' => ['store']]);

Route::get('/img/{filter}/{filename}', 'ImagesController@getResponse')
    ->where(array('filename' => '[ \w\\.\\/\\-\\@]+', 'filter' => 'original|download|[0-9]+\/[0-9]+|[0-9]+'));

Route::get('/', function () {
    return view('welcome');
});

/** END shop */

Form::macro('img', function ($path, $sizes, $alt) {
    /** @var Collection $sizes */
    $srcset = $sizes->map(function ($size, $viewPort) use ($path) {
        return "/img/$size/$path $viewPort";
    })->implode(',');
    return '<img class="img-responsive" alt="' . $alt . '" sizes="100w" srcset="' . $srcset . '">';
});