const {mix} = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/assets/js/app.js', 'public/js')

    //.copy('public/css/bower/font-awesome/fonts', 'public/fonts')
    //.copy('public/css/bower/sourceSansPro/', 'public/css')
    //.copy('public/css/bower/raleway/', 'public/css')

    /*.copy('resources/assets/images', 'public/css/images')

    .copy('resources/assets/css/custom.css', 'public/css')
    .copy('resources/assets/css/bikebitants.css', 'public/css')
    .copy('resources/assets/css/color/bikebitants_green.css', 'public/css')

    .combine([
        'public/css/bower/bootstrap/dist/css/bootstrap.css',
        'custom.css',
        'bikebitants.css',
        'bikebitants_green.css',
        'public/css/bower/jquery-ui/themes/smoothness/jquery-ui.css',
        'public/css/bower/font-awesome/css/font-awesome.css',
        'node_modules/owl.carousel/dist/owl.carousel.css',
        'public/css/bower/animate.css/animate.css',
    ], 'public/css/all.css')*/

    .sass('resources/assets/css/app.scss', 'public/css/app.css')
    .sass('resources/assets/css/vendor.scss', 'public/css/vendor.css')

    .version();
