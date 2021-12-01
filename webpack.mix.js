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

mix
    // JS
    .js("resources/js/app.js", "public/js")
    .js(
        "resources/js/contents/masters/categories/category.js",
        "public/js/contents/masters/categories/category.js"
    )
    .js(
        "resources/js/contents/masters/uoms/uom.js",
        "public/js/contents/masters/uoms/uom.js"
    )

    // CSS
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
    ]);

if (mix.inProduction()) {
    mix.version();
}
