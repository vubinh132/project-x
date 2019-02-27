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

mix.js(['resources/assets/js/vendor.js'], 'public/js')
    .sass('resources/assets/sass/admin.scss', 'public/css').options({
    processCssUrls: false
})
    .sass('resources/assets/sass/user.scss', 'public/css')
    .scripts(['resources/assets/js/admin.js'], 'public/js/admin.js')
    .scripts(['resources/assets/js/user.js'], 'public/js/user.js')
    .scripts(['resources/assets/js/load_orders.js'], 'public/js/load_orders.js')
    .scripts(['resources/assets/js/load_logs.js'], 'public/js/load_logs.js');
