<?php

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

Route::prefix('/uoms')->group(function () {
    Route::get('/', [UomController::class, 'index'])->name('uoms.index');
    Route::get('/data', [UomController::class, 'data'])->name('uoms.data');
    Route::get('/create', [UomController::class, 'create'])->name('uoms.create');
    Route::post('/', [UomController::class, 'store'])->name('uoms.store');
    Route::get('/{id}/edit', [UomController::class, 'edit'])->name('uoms.edit');
    Route::patch('/{id}', [UomController::class, 'update'])->name('uoms.update');
    Route::delete('/{id}', [UomController::class, 'destroy'])->name('uoms.destroy');
});
