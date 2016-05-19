var elixir = require('laravel-elixir');

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

elixir(function (mix) {
    mix
        .copy('vendor/bower_components/jquery/dist/jquery.js', 'resources/assets/js/jquery.js')
        .copy('vendor/bower_components/jquery-ui/jquery-ui.js', 'resources/assets/js/jquery-ui.js')
        .copy('vendor/bower_components/google-maps/lib/Google.js', 'resources/assets/js/google-maps.js')
        .copy('vendor/bower_components/bootstrap/dist/js/bootstrap.js', 'resources/assets/js/bootstrap.js')
        .copy('vendor/bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js', 'resources/assets/js/bootstrap-hover-dropdown.js')
        .copy('vendor/bower_components/smoothscroll-for-websites/SmoothScroll.js', 'resources/assets/js/smooth-scroll.js')
        .copy('vendor/bower_components/dragtable/jquery.dragtable.js', 'resources/assets/js/jquery.dragtable.js')
        .copy('vendor/bower_components/owl.carousel/dist/owl.carousel.js', 'resources/assets/js/owl.carousel.js')
        .copy('vendor/bower_components/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js', 'resources/assets/js/jquery.mb.YTPlayer.js')

        .scripts([
            'jquery.js',
            'jquery-ui.js',
            'google-maps.js',
            'bootstrap.js',
            'bootstrap-hover-dropdown.js',
            'smooth-scroll.js',
            'jquery.dragtable.js',
            'jquery.card.js',
            'owl.carousel.js',
            'twitterFetcher.js',
            'jquery.mb.YTPlayer.js',
            'custom.js',
            'shop.js'
        ])
        .version(['js/all.js']);
});
