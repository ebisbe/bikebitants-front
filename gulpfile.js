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
    //js
        /*.copy('vendor/bower_components/jquery/dist/jquery.js', 'resources/assets/js/bower/jquery.js')
        .copy('vendor/bower_components/jquery-ui/jquery-ui.js', 'resources/assets/js/bower/jquery-ui.js')
        .copy('vendor/bower_components/google-maps/lib/Google.js', 'resources/assets/js/bower/google-maps.js')
        .copy('vendor/bower_components/bootstrap/dist/js/bootstrap.js', 'resources/assets/js/bower/bootstrap.js')
        .copy('vendor/bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js', 'resources/assets/js/bower/bootstrap-hover-dropdown.js')
        .copy('vendor/bower_components/smoothscroll-for-websites/SmoothScroll.js', 'resources/assets/js/bower/smooth-scroll.js')
        .copy('vendor/bower_components/dragtable/jquery.dragtable.js', 'resources/assets/js/bower/jquery.dragtable.js')
        .copy('vendor/bower_components/owl.carousel/dist/owl.carousel.js', 'resources/assets/js/bower/owl.carousel.js')
        .copy('vendor/bower_components/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js', 'resources/assets/js/bower/jquery.mb.YTPlayer.js')
        .copy('vendor/bower_components/underscore/underscore.js', 'resources/assets/js/bower/underscore.js')
        .copy('vendor/bower_components/pnotify/dist/pnotify.js', 'resources/assets/js/bower/pnotify.js')*/

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

        /*.scripts([
            'bower/jquery.js',
            'bower/jquery-ui.js',
            'bower/google-maps.js',
            'bower/bootstrap.js',
            'bower/bootstrap-hover-dropdown.js',
            'bower/smooth-scroll.js',
            'bower/jquery.dragtable.js',
            'jquery.card.js',
            'bower/owl.carousel.js',
            'bower/jquery.mb.YTPlayer.js',
            'bower/underscore.js',
            'bower/pnotify.js',
            'custom.js',
            'shop.js',
            'bower/vue_main.js'
        ])*/

        .styles([
            'bower/bootstrap.css',
            'bower/jquery-ui.css',
            'bower/font-awesome.css',
            'bower/dragtable.css',
            'bower/owl.carousel.css',
            'bower/animate.css',
            'custom.css',
            'bikebitants.css',
            'color/green.css',
            'bower/sourceSansPro.css',
            'bower/raleway.css',
            'bower/pnotify.css',
            'bower/brighttheme.css'
        ])

        .version(['js/app.js', 'css/all.css']);
});
