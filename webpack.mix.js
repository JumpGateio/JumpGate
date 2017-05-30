const { mix } = require('laravel-mix');
const node_dir = 'node_modules/';

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

mix.js('resources/assets/js/app.js', 'public/js')
   // Fonts
   .copy(node_dir + 'font-awesome/fonts', 'public/fonts')
   .copy(node_dir + 'ionicons/dist/fonts', 'public/fonts')
   // .copy(node_dir + 'octicons/build/font', 'public/fonts')

   .sass('resources/assets/sass/app.scss', 'public/css');
