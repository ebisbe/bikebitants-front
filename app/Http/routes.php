<?php

Route::post('/checkout/callback', 'CheckoutCallbackController@store')->name('shop.callback');

Route::group(['middleware' => 'token'], function () {

    Route::group(['domain' => 'admin_' . env('DOMAIN')], function () {
        Route::auth();
        Route::get('/', 'Admin\\AdminController@dashboard')->name('admin.dashboard');

        Route::get('product/data-table', 'Admin\\ProductController@dataTable')->name('product.data-table');
        Route::get('product/status', 'Admin\\ProductController@status')->name('product.status');
        Route::get('product/duplicate/{id}', 'Admin\\ProductController@duplicate')->name('product.duplicate');
        Route::resource('product', 'Admin\\ProductController');

        Route::get('brand/data-table', 'Admin\\BrandController@dataTable')->name('brand.data-table');
        Route::resource('brand', 'Admin\\BrandController');

        Route::get('coupon/types', 'Admin\\CouponController@types')->name('coupon.types');
        Route::get('coupon/data-table', 'Admin\\CouponController@dataTable')->name('coupon.data-table');
        Route::resource('coupon', 'Admin\\CouponController');

        Route::get('lead/data-table', 'Admin\\LeadController@dataTable')->name('lead.data-table');
        Route::resource('lead', 'Admin\\LeadController');

        Route::get('country/data-table', 'Admin\\CountryController@dataTable')->name('country.data-table');
        Route::resource('country', 'Admin\\CountryController');

        Route::get('category/tree', 'Admin\\CategoryController@tree')->name('category.tree');
        Route::post('category/update-order', 'Admin\\CategoryController@updateOrder')->name('category.update-order');
        Route::resource('category', 'Admin\\CategoryController');

        Route::get('faq/data-table', 'Admin\\FaqController@dataTable')->name('faq.data-table');
        Route::resource('faq', 'Admin\\FaqController');
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
    Route::get('/checkout/cancel', 'CheckoutController@cancel')->name('shop.cancellation');

    Route::resource('checkout', 'CheckoutController', ['only' => ['index', 'store', 'show']]);
    Route::resource('lead', 'LeadsController', ['only' => ['store']]);
    Route::resource('coupon', 'CouponController', ['only' => ['store']]);
    Route::resource('cart-conditions', 'CartConditionsController', ['only' => ['index', 'store']]);
    Route::resource('wp', 'WordPressController', ['only' => ['index', 'show']]);
    Route::resource('review', 'ReviewController', ['only' => ['store']]);

// Static pages

    Route::get('/quines-somos', 'StaticPagesController@whoWeAre')->name('who_we_are');
    Route::get('/condiciones-generales', 'StaticPagesController@termsAndConditions')->name('terms_conditions');
    Route::get('/compromiso-bikebitants', 'StaticPagesController@socialCommitment')->name('social_commitment');
    Route::get('/incentivos-empresas', 'StaticPagesController@incentives')->name('incentives');
    Route::get('/prensa', 'StaticPagesController@press')->name('press');

// End Static Pages

    Route::get('/img/{filter}/{filename}', 'ImagesController@getResponse')
        ->where(array('filename' => '[ \w\\.\\/\\-\\@]+', 'filter' => 'original|download|[0-9]+\/[0-9]+|[0-9]+'))
        ->name('shop.image');
    /** END shop */

});