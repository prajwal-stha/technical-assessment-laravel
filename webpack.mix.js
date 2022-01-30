const mix = require('laravel-mix');

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

var plugin =  'resources/assets/plugins/';

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .combine([
        plugin + 'jquery-3.5.1.min.js',
        plugin + 'popper/popper.min.js',
        plugin + 'bootstrap/bootstrap.min.js',
        plugin + 'moment/moment.min.js',
        plugin + 'toastr/toastr.min.js',
    ],'public/js/plugin.js')
    .sass('resources/sass/app.scss', 'public/css');
