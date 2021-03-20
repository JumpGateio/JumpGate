const mix      = require('laravel-mix');
const path     = require('path')
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
// .copy(node_dir + '@fortawesome/fontawesome-free/webfonts', 'public/fonts')

// JS
  .js('resources/js/app.js', 'public/js').vue()

  // CSS
  .sass('resources/sass/app.scss', 'public/css')

  // Inertia
  .webpackConfig({
    output:      {chunkFilename: 'js/[name].js?id=[chunkhash]'},
    resolve:     {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '@':  path.resolve('resources/js'),
      },
    },
    experiments: {
      topLevelAwait: true,
    }
  })


  // Dynamic importing
  .babelConfig({
    plugins: [
      '@babel/plugin-syntax-dynamic-import',
      '@babel/plugin-syntax-top-level-await'
    ],
  })

  .version()
  .sourceMaps()

