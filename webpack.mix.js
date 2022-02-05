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
        "resources/js/contents/masters/ingredients/ingredient.js",
        "public/js/contents/masters/ingredients/ingredient.js"
    )
    .js(
        "resources/js/contents/masters/inventoryStocks/inventoryStock.js",
        "public/js/contents/masters/inventoryStocks/inventoryStock.js"
    )
    .js(
        "resources/js/contents/transactions/purchases/purchase.js",
        "public/js/contents/transactions/purchases/purchase.js"
    )
    .js(
        "resources/js/contents/transactions/purchases/purchase-create-vue.js",
        "public/js/contents/transactions/purchases/purchase-create-vue.js"
    )
    .js(
        "resources/js/contents/transactions/sales/sale.js",
        "public/js/contents/transactions/sales/sale.js"
    )
    .js(
        "resources/js/contents/transactions/sales/sale-create-vue.js",
        "public/js/contents/transactions/sales/sale-create-vue.js"
    )
    .js(
        "resources/js/contents/masters/stocks/stock.js",
        "public/js/contents/masters/stocks/stock.js"
    )
    .js(
        "resources/js/contents/masters/stocks/stock-in/stock-in-create-vue.js",
        "public/js/contents/masters/stocks/stock-in/stock-in-create-vue.js"
    )
    .js(
        "resources/js/contents/masters/stocks/stock-out/stock-out-create-vue.js",
        "public/js/contents/masters/stocks/stock-out/stock-out-create-vue.js"
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
