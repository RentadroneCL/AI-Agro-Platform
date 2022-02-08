const mix = require('laravel-mix');
const ThreadsPlugin = require('threads-plugin');

/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel applications. By default, we are compiling the CSS
| file for the application as well as bundling up all the JS files.
|
*/
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .copy('resources/img/*', 'public/img')
    .copy('resources/svg/*', 'public/svg')
    .webpackConfig({
      resolve: {
        fallback: {
          fs: false,
          http: false,
          https: false,
          stream: false,
        },
      },
      plugins: [
        new ThreadsPlugin(),
      ],
    });

if (mix.inProduction()) {
    mix.version();
}
