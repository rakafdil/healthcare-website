const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.css('resources/css/rumah-sakit/detail.css', 'public/css/rumah-sakit/detail.css')
    .js('resources/js/rumah-sakit/detail.js', 'public/js/rumah-sakit/detail.js');

if (mix.inProduction()) {
    mix.version();
}