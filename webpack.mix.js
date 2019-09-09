const mix = require('laravel-mix');
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

mix
  // Fonts
  .copy(node_dir + '@fortawesome/fontawesome-free/webfonts', 'public/fonts')

  // JS
  .js('resources/js/app.js', 'public/js')

  // CSS
  .sass('resources/sass/app.scss', 'public/css')

  .version()
