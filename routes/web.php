<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Masters\Additionals\AdditionalController;
use App\Http\Controllers\Masters\Categories\CategoryController;
use App\Http\Controllers\Masters\Ingredients\IngredientController;
use App\Http\Controllers\Masters\InventoryStocks\InventoryStockController;
use App\Http\Controllers\Masters\Stocks\StockController;
use App\Http\Controllers\Masters\Stocks\StockInController;
use App\Http\Controllers\Masters\Stocks\StockInventoryStockController;
use App\Http\Controllers\Masters\Stocks\StockOutController;
use App\Http\Controllers\Masters\Uoms\UomController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Transactions\Orders\OrderAdditionalDetailController;
use App\Http\Controllers\Transactions\Orders\OrderController;
use App\Http\Controllers\Transactions\Orders\OrderDetailController;
use App\Http\Controllers\Transactions\Orders\OrderInventoryStockController;
use App\Http\Controllers\Transactions\Orders\OrderPriceController;
use App\Http\Controllers\Transactions\Purchases\PurchaseController;
use App\Http\Controllers\Transactions\Purchases\PurchaseUomController;
use App\Http\Controllers\Transactions\Sales\SaleAdditionalDetailController;
use App\Http\Controllers\Transactions\Sales\SaleController;
use App\Http\Controllers\Transactions\Sales\SaleInventoryStockController;
use App\Http\Controllers\Transactions\Sales\SaleOrderController;
use App\Http\Controllers\Transactions\Sales\SalePriceController;
use App\Http\Controllers\Transactions\Sales\SalePrintController;
use App\Http\Controllers\Transactions\Sales\SaleStockController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('/');
Route::get('/data', [DashboardController::class, 'data'])->name('dashboards.data');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Additional
Route::prefix('/additionals')->group(function () {
    Route::get('/', [AdditionalController::class, 'index'])->name('additionals.index');
    Route::get('/data', [AdditionalController::class, 'data'])->name('additionals.data');
    Route::get('/create', [AdditionalController::class, 'create'])->name('additionals.create');
    Route::post('/', [AdditionalController::class, 'store'])->name('additionals.store');
    Route::get('/{id}/edit', [AdditionalController::class, 'edit'])->name('additionals.edit');
    Route::patch('/{id}', [AdditionalController::class, 'update'])->name('additionals.update');
    Route::delete('/{id}', [AdditionalController::class, 'destroy'])->name('additionals.destroy');
});

// Category
Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/data', [CategoryController::class, 'data'])->name('categories.data');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Ingredient
Route::prefix('/ingredients')->group(function () {
    Route::get('/', [IngredientController::class, 'index'])->name('ingredients.index');
    Route::get('/data', [IngredientController::class, 'data'])->name('ingredients.data');
    Route::get('/create', [IngredientController::class, 'create'])->name('ingredients.create');
    Route::post('/', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('/{id}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
    Route::patch('/{id}', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::delete('/{id}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');
});

// Inventory Stock
Route::prefix('/inventory-stocks')->group(function () {
    Route::get('/', [InventoryStockController::class, 'index'])->name('inventory_stocks.index');
    Route::get('/data', [InventoryStockController::class, 'data'])->name('inventory_stocks.data');
    Route::get('/create', [InventoryStockController::class, 'create'])->name('inventory_stocks.create');
    Route::post('/', [InventoryStockController::class, 'store'])->name('inventory_stocks.store');
    Route::get('/{id}/edit', [InventoryStockController::class, 'edit'])->name('inventory_stocks.edit');
    Route::patch('/{id}', [InventoryStockController::class, 'update'])->name('inventory_stocks.update');
    Route::delete('/{id}', [InventoryStockController::class, 'destroy'])->name('inventory_stocks.destroy');
});

// Order
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/data', [OrderController::class, 'data'])->name('orders.data');
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/inventory-stock', [OrderInventoryStockController::class, '__invoke'])->name('orders.inventory_stocks');
    Route::get('/price/{id}', [OrderPriceController::class, '__invoke'])->name('orders.price');

    // Order Detail
    Route::prefix('/details')->group(function () {
        Route::get('/data', [OrderDetailController::class, 'data'])->name('orders.details.data');
    });

    // Order Additional Detail
    Route::get('/additional-detail/data/{orderDetailId}', [OrderAdditionalDetailController::class, 'data'])->name('orders_additional_details.data');
});

// Purchase
Route::prefix('purchases')->group(function () {
    Route::get('/', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/data', [PurchaseController::class, 'data'])->name('purchases.data');
    Route::get('/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/{id}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::delete('/{id}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
    Route::get('/inventory-stock', [PurchaseInventoryStockController::class, '__invoke'])->name('purchases.inventory_stocks');
    Route::get('/uom/{id}', [PurchaseUomController::class, '__invoke'])->name('purchases.uom');
});

// Report
Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/daily-report', [ReportController::class, 'dailyReport'])->name('reports.daily_report');
    Route::post('/order-report', [ReportController::class, 'orderReport'])->name('reports.order_report');
    Route::post('/monthly-report', [ReportController::class, 'monthlyReport'])->name('reports.monthly_report');
});

// Sale
Route::prefix('sales')->group(function () {
    Route::get('/', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/data', [SaleController::class, 'data'])->name('sales.data');
    Route::get('/data-orders', [SaleOrderController::class, 'data'])->name('sales.data_orders');
    Route::get('/create/{orderId?}', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/{id}', [SaleController::class, 'show'])->name('sales.show');
    Route::delete('/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');
    Route::get('/inventory-stock', [SaleInventoryStockController::class, '__invoke'])->name('sales.inventory_stocks');
    Route::get('/price/{id}', [SalePriceController::class, '__invoke'])->name('sales.price');
    Route::get('/stock/{id}', [SaleStockController::class, '__invoke'])->name('sales.stock');
    Route::get('/print/{id}', [SalePrintController::class, '__invoke'])->name('sales.print');

    // Sale Additional Detail
    Route::get('/additional-detail/data/{saleDetailId}', [SaleAdditionalDetailController::class, 'data'])->name('sales_additional_details.data');
});

// Stock
Route::prefix('/stocks')->group(function () {
    Route::get('/', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/data', [StockController::class, 'data'])->name('stocks.data');
    Route::get('/{id}', [StockController::class, 'show'])->name('stocks.show');
    Route::delete('/{id}', [StockController::class, 'destroy'])->name('stocks.destroy');
    Route::get('/inventory-stock', [StockInventoryStockController::class, '__invoke'])->name('stocks.inventory_stocks');

    // Stock In
    Route::prefix('/stocks-in')->group(function () {
        Route::get('/create', [StockInController::class, 'create'])->name('stocks.stocks_in.create');
        Route::post('/', [StockInController::class, 'store'])->name('stocks.stocks_in.store');
    });

    // Stock Out
    Route::prefix('/stocks-out')->group(function () {
        Route::get('/create', [StockOutController::class, 'create'])->name('stocks.stocks_out.create');
        Route::post('/', [StockOutController::class, 'store'])->name('stocks.stocks_out.store');
    });
});

// Uom
Route::prefix('/uoms')->group(function () {
    Route::get('/', [UomController::class, 'index'])->name('uoms.index');
    Route::get('/data', [UomController::class, 'data'])->name('uoms.data');
    Route::get('/create', [UomController::class, 'create'])->name('uoms.create');
    Route::post('/', [UomController::class, 'store'])->name('uoms.store');
    Route::get('/{id}/edit', [UomController::class, 'edit'])->name('uoms.edit');
    Route::patch('/{id}', [UomController::class, 'update'])->name('uoms.update');
    Route::delete('/{id}', [UomController::class, 'destroy'])->name('uoms.destroy');
});
