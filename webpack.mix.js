const mix = require("laravel-mix");

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

const pluginOptions = [require("tailwindcss")];

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", pluginOptions)
    .postCss("resources/css/nova.css", "public/css")
    .vue({ version: 3 })
    .webpackConfig({
        output: {
            chunkFilename: "js/[name].js?id=[chunkhash]",
        },
    });

if (mix.inProduction() === false) {
    mix.sourceMaps();
}
