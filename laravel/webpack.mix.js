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

const vendors = 'node_modules/';
const dest = 'public/assets/';
const destCss = dest + 'css/';
const destJs = dest + 'js/';
const destImg = dest + 'img/';
const destVendors = dest + 'vendors/';

const paths = {
   'fullcalendar': vendors + '@fullcalendar/',
   'moment': vendors + 'moment/',
   'lightpick': vendors + 'lightpick/',
   'colorpicker': vendors + 'bootstrap-colorpicker/'
}

// fullcalendar
mix.copyDirectory(paths.fullcalendar, destVendors + 'fullcalendar/');

// moment
mix.copy(paths.moment + 'min/moment.min.js', destVendors + 'moment/');
mix.copy(paths.moment + 'min/moment-with-locales.min.js', destVendors + 'moment/');
mix.copy(paths.moment + 'min/locales.min.js', destVendors + 'moment/');

// lightpick
mix.copy(paths.lightpick + 'lightpick.js', destVendors + 'lightpick/js/');
mix.copy(paths.lightpick + 'css/lightpick.css', destVendors + 'lightpick/css/');

// bootstrap colorpicker
mix.copy(paths.colorpicker + 'dist/js/bootstrap-colorpicker.min.js', destVendors + 'bootstrap-colorpicker/');
mix.copy(paths.colorpicker + 'dist/css/bootstrap-colorpicker.min.css', destVendors + 'bootstrap-colorpicker/');
// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');
