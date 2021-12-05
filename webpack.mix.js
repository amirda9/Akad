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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css');

mix.copy('node_modules/persian-datepicker/dist/js/persian-datepicker.min.js','public/js')
    .copy('node_modules/persian-datepicker/dist/css/persian-datepicker.min.css','public/css')
    .copy('resources/js/nouislider.min.js','public/js')
    .copy('node_modules/swiper/swiper-bundle.min.css','public/css')
    .copy('node_modules/swiper/swiper-bundle.min.js','public/js')
    .copy('node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js','public/js')
    .copy('node_modules/persian-date/dist/persian-date.min.js','public/js');
