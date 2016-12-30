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
        .copy('resources/assets/css/bower/font-awesome/fonts', 'public/build/fonts')
        .copy('resources/assets/css/bower/sourceSansPro/*.ttf', 'public/build/css/')
        .copy('resources/assets/css/bower/raleway/*.ttf', 'public/build/css/')

        //files
        .copy('resources/assets/images', 'public/build/images/')

        .webpack('app.js')

        .styles([
            'bower/bootstrap/dist/css/bootstrap.css',
            'custom.css',
            'bikebitants.css',
            'color/bikebitants_green.css',
            'bower/jquery-ui/themes/smoothness/jquery-ui.css',
            'bower/font-awesome/css/font-awesome.css',
            //'bower/dragtable/dragtable.css',
            'bower/owl.carousel/dist/assets/owl.carousel.css',
            'bower/animate.css/animate.css',
            'bower/sourceSansPro/sourceSansPro.css',
            'bower/raleway/raleway.css',
            //'bower/pnotify/dist/pnotify.css',
            //'bower/pnotify/dist/pnotify.brighttheme.css'
        ])

        .version(['js/app.js', 'css/all.css']);
});
