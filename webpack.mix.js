let mix = require('laravel-mix');

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

mix.js('resources/js/app.js','public/js')
    .js('resources/js/login.js','public/js/login')
    .js('resources/js/notarios.js','public/js/notario')
    .js('resources/js/secretaria_gerencia.js','public/js/gerencia')
    .js('resources/js/gerentes.js','public/js/gerentes')
    .js('resources/js/jefe_agencia.js','public/js/jefeagencia')
    .js('resources/js/contabilidad.js','public/js/contabilidad')
;
mix.sass('resources/sass/app.scss','public/css');
mix.browserSync('http://www.expeco.local');
