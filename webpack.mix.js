const mix = require('laravel-mix');

mix.js('node_modules/formiojs/dist/formio.full.js', 'public/js')
    .styles('node_modules/formiojs/dist/formio.full.min.css', 'public/css/formio.css'); // Formio.css;
