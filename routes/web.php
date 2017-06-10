<?php

/*Route::group(['domain' => 'admin_' . env('DOMAIN')], function () {
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
});*/
/** END Admin */

/** Shop */
Route::get('/', 'ShopController@home')->name('shop.home');
Route::get('/tienda', 'ShopController@catalogue')->name('shop.catalogue');
Route::get('/ofertas', 'ShopController@bargain')->name('shop.bargain');
Route::get('/etiqueta-producto/{slug}', 'ShopController@tag')->name('shop.tag');
Route::resource('cart', 'CartController', ['only' => ['index', 'destroy']]);

Route::get('/tienda/marcas', 'BrandController@brands')->name('shop.brands');
Route::get('/tienda/{slug}', 'BrandController@brand')->name('shop.brand');

Route::get('/checkout/cancel', 'CheckoutController@cancel')->name('shop.cancellation');
Route::resource('checkout', 'CheckoutController', ['only' => ['index', 'store']]);

Route::resource('lead', 'LeadsController', ['only' => ['store']]);
Route::resource('coupon', 'CouponController', ['only' => ['store']]);
Route::resource('woo', 'WooCommerceController', ['only' => ['index', 'show']]);
Route::resource('wp', 'WordPressController', ['only' => ['index', 'show']]);


// Static pages
Route::get('/quien-somos', 'StaticPagesController@whoWeAre')->name('who_we_are');
Route::get('/condiciones-generales', 'StaticPagesController@termsAndConditions')->name('terms_conditions');
Route::get('/compromiso-bikebitants', 'StaticPagesController@socialCommitment')->name('social_commitment');
Route::get('/incentivos-empresas', 'StaticPagesController@incentives')->name('incentives');
Route::get('/prensa', 'StaticPagesController@press')->name('press');
Route::get('/preguntas-frecuentes', 'StaticPagesController@faq')->name('faq');
// End Static Pages

Route::get('/img/{filter}/{filename}', 'ImagesController@getResponse')
    ->where(['filename' => '[ \w\\.\\/\\-\\@]+', 'filter' => 'original|download|[0-9]+\/[0-9]+|[0-9]+'])
    ->name('shop.image');
/** END shop */

Route::get('/deliverea/client-carriers', 'DelivereaController@clientCarriers')->name('deliverea.client_carriers');
Route::get('/deliverea/client-services', 'DelivereaController@clientServices')->name('deliverea.client_services');
Route::get('/deliverea/service-info', 'DelivereaController@serviceInfo')->name('deliverea.service_info');
Route::get('/deliverea/cut-off-hour', 'DelivereaController@cutOffHour')->name('deliverea.cut_off_hour');
Route::get('/deliverea/addresses', 'DelivereaController@addresses')->name('deliverea.addresses');

/** API */
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::resource('cart', 'CartController', [
        'only' => ['index', 'store', 'destroy'],
        'names' => [
            'index' => 'api.cart.index',
            'store' => 'api.cart.store',
            'destroy' => 'api.cart.destroy'
        ]
    ]);
    Route::resource('review', 'ReviewController', ['only' => ['store']]);
    Route::resource('cart-conditions', 'CartConditionsController', ['only' => ['index', 'store']]);
});
/** END API */

Route::get('/{slug}/{subSlug}', 'ShopController@subslug')->name('shop.subslug');
Route::get('/{slug}', 'ShopController@slug')->name('shop.slug');
