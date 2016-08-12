var elixir = require('laravel-elixir');

var bower_dir = 'vendor/bower_components/';
var node_dir  = 'node_modules/';

require('laravel-elixir-vue');

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

elixir(function (mix)
{
  mix.sass('app.scss')
     // Fonts
     .copy(node_dir + 'font-awesome/fonts', 'public/fonts')
     .copy(node_dir + 'ionicons/dist/fonts', 'public/fonts')
     .copy(node_dir + 'octicons/build/font', 'public/fonts')

     .webpack('app.js');
});
