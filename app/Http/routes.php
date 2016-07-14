<?php
use App\Product;
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
Route::get('/', 'ShopController@home')->name('shop.home');
Route::get('/brand/{slug}', 'ShopController@brand')->name('shop.brand');
Route::get('/tienda/', 'ShopController@shop')->name('shop.catalogue');
Route::get('/tienda/{slugCategory}/', 'ShopController@category')->name('shop.category');
Route::get('/tienda/{slugCategory}/{slugSubCategory}', 'ShopController@subcategory')->name('shop.subcategory');
Route::get('/product/{slug}', 'ShopController@product')->name('shop.product');
Route::resource('cart', 'CartController');
Route::resource('checkout', 'CheckoutController', ['only' => ['index', 'store']]);
Route::resource('lead', 'LeadsController', ['only' => ['store']]);

Route::get('/img/{filter}/{filename}', 'ImagesController@getResponse')
    ->where(array('filename' => '[ \w\\.\\/\\-\\@]+', 'filter' => 'original|download|[0-9]+\/[0-9]+|[0-9]+'))
    ->name('shop.image');
/** END shop */

Form::macro('img', function ($path, $sizes, $alt, $wrapper = '{img}', $class = 'img-responsive') {
    /** @var Collection $sizes */
    $srcset = $sizes->map(function ($size, $viewPort) use ($path) {
        return "/img/$size/$path $viewPort";
    })->implode(',');
    return str_ireplace('{img}', '<img class="' . $class . '" alt="' . $alt . '" sizes="100w" srcset="' . $srcset . '">', $wrapper);
});

Form::macro('product', function (Product $product) {

    $images = [];
    foreach ($product->images as $image) {
        $images[] = Form::img($image->filename, StaticVars::productRelated(), $image->alt, StaticVars::imgWrapper());
        break; // TODO Make Owl.js to work when changin it's images src
    }

    $arr_product = [
        'name' => $product->name,
        'description' => $product->description,
        'brand' => $product->brand->name,
        'tags' => $product->tags_list,
        'images' => $images
    ];

    return json_encode($arr_product);
});