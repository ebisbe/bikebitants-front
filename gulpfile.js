const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix
    //css
        .copy('vendor/bower_components/bootstrap/dist/css/bootstrap.css', 'resources/assets/css/bower/bootstrap.css')
        .copy('vendor/bower_components/jquery-ui/themes/smoothness/jquery-ui.css', 'resources/assets/css/bower/jquery-ui.css')
        .copy('vendor/bower_components/font-awesome/css/font-awesome.css', 'resources/assets/css/bower/font-awesome.css')
        .copy('vendor/bower_components/font-awesome/fonts', 'public/build/fonts')
        .copy('vendor/bower_components/dragtable/dragtable.css', 'resources/assets/css/bower/dragtable.css')
        .copy('vendor/bower_components/owl.carousel/dist/assets/owl.carousel.css', 'resources/assets/css/bower/owl.carousel.css')
        .copy('vendor/bower_components/animate.css/animate.css', 'resources/assets/css/bower/animate.css')
        .copy('vendor/bower_components/sourceSansPro/sourceSansPro.css', 'resources/assets/css/bower/sourceSansPro.css')
        .copy('vendor/bower_components/raleway/raleway.css', 'resources/assets/css/bower/raleway.css')
        .copy('vendor/bower_components/sourceSansPro/*.ttf', 'public/build/css/')
        .copy('vendor/bower_components/raleway/*.ttf', 'public/build/css/')
        .copy('vendor/bower_components/pnotify/dist/pnotify.css', 'resources/assets/css/bower/pnotify.css')
        .copy('vendor/bower_components/pnotify/dist/pnotify.brighttheme.css', 'resources/assets/css/bower/brighttheme.css')

        //files
        .copy('resources/assets/images', 'public/build/images/')
        .webpack('app.js')

        .styles([
            'bower/jquery-ui.css',
            'bower/font-awesome.css',
            'bower/dragtable.css',
            'bower/owl.carousel.css',
            'bower/animate.css',
            'bower/sourceSansPro.css',
            'bower/raleway.css',
            'bower/pnotify.css',
            'bower/brighttheme.css'
        ])

        .styles([
            'bower/bootstrap.css',
            'custom.css',
            'bikebitants.css',
            'color/green.css'
        ], 'storage/app/css/main.css')

        .version(['js/app.js', 'css/all.css']);
});
