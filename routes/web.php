<?php

use App\Http\Controllers\Masters\Categories\CategoryController;
use App\Http\Controllers\Masters\Ingredients\IngredientController;
use App\Http\Controllers\Masters\Uoms\UomController;
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

Route::get('/', function () {
    return view('layouts.index');
})->name('/');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

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
