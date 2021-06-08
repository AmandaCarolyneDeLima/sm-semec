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

mix.js(  'resources/js/app.js',               'public/assets/js')
   .js(  'resources/js/admin/app.js',         'public/assets/js/admin')
   .js(  'resources/js/servants/app.js',         'public/assets/js/servants')
   .sass('resources/sass/app.scss',           'public/assets/css')
   .sass('resources/sass/login/session.scss', 'public/assets/css/login')
   .sass('resources/sass/admin/app.scss',     'public/assets/css/admin')
   .sass('resources/sass/servants/app.scss',     'public/assets/css/servants')

mix.copyDirectory('resources/vendor/assets', 'public/assets/vendor');
mix.copyDirectory('resources/images',        'public/assets/images');


mix.version([
   'public/assets/vendor/tabler/css/tabler.min.css',
   'public/assets/vendor/tabler/css/tabler-dashboard.css',
   'public/assets/vendor/tempusdominus/css/tempusdominus-bootstrap-4.min.css',
   'public/assets/vendor/tempusdominus/js/tempusdominus-bootstrap-4.min.js',
   'public/assets/vendor/selectize/js/selectize.min.js',
   'public/assets/vendor/mask/js/mask.min.js'

   

]).options({ processCssUrls: false });

if (mix.inProduction()) {
   mix.version();
}
