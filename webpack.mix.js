let mix = require('laravel-mix');

let CompressionPlugin = require("compression-webpack-plugin");

mix.webpackConfig({plugins: [new CompressionPlugin({exclude: /LICENSE\.txt/})]});
mix.setPublicPath('resources/assets')
    .js('resources/js/app.js', 'resources/assets/js/')
    .sass('resources/sass/app.scss', 'resources/assets/css');
