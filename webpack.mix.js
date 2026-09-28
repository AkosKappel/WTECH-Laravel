const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Bundles resources/js/app.js. The CSS is built separately with the
 | Tailwind CLI (npm run build:css), see resources/css/app.css.
 |
 */

mix.js('resources/js/app.js', 'public/js');
