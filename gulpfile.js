const elixir   = require('laravel-elixir');
const node_dir = 'node_modules/';

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

elixir((mix) =>
{
  mix.sass('app.scss')
     // Fonts
     .copy(node_dir + 'font-awesome/fonts', 'public/fonts')
     .copy(node_dir + 'ionicons/dist/fonts', 'public/fonts')
     .copy(node_dir + 'octicons/build/font', 'public/fonts')

     .webpack('app.js');
});
