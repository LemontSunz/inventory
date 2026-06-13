<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Warehouse\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\BarangKeluarController;

Route::view('/', 'pages.dashboard.index')->name('dashboard');

Route::resource('barang', BarangController::class);
Route::resource('barang-masuk', BarangMasukController::class);
Route::resource('cabang', CabangController::class);
Route::resource('barang-keluar', BarangKeluarController::class);

Route::prefix('warehouse/items')->group(function () {
    Route::view('/', 'pages.warehouse.items.index')->name('warehouse.items.index');
});

Route::prefix('warehouse/inbound')->group(function () {
    Route::view('/', 'pages.warehouse.inbound.index')->name('warehouse.inbound.index');
});

Route::prefix('warehouse/outbound')->group(function () {
    Route::get('/', [BarangKeluarController::class, 'index'])->name('warehouse.outbound.index');
});


Route::prefix('warehouse/stock')->group(function () {
    Route::view('/', 'pages.warehouse.stock.index')->name('warehouse.stock.index');
});

Route::prefix('warehouse/stock-management')->group(function () {
    Route::get('/', [\App\Http\Controllers\Warehouse\StokBarangController::class, 'index'])
        ->name('warehouse.stock-management.index');
});

Route::prefix('warehouse/reports/stock')->group(function () {
    Route::get('/', [\App\Http\Controllers\Warehouse\LaporanStokController::class, 'index'])
        ->name('warehouse.reports.stock.index');
});





