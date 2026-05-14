<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Warehouse\BarangController;

// Dashboard
Route::view('/', 'pages.dashboard.index')->name('dashboard');

// Warehouse - Items Management (Barang CRUD)
Route::resource('barang', BarangController::class);

// Warehouse - Items Management (View)
Route::prefix('warehouse/items')->group(function () {
    Route::view('/', 'pages.warehouse.items.index')->name('warehouse.items.index');
});

// Warehouse - Inbound (Barang Masuk)
Route::prefix('warehouse/inbound')->group(function () {
    Route::view('/', 'pages.warehouse.inbound.index')->name('warehouse.inbound.index');
});

// Warehouse - Outbound (Barang Keluar)
Route::prefix('warehouse/outbound')->group(function () {
    Route::view('/', 'pages.warehouse.outbound.index')->name('warehouse.outbound.index');
});

// Warehouse - Stock Management
Route::prefix('warehouse/stock')->group(function () {
    Route::view('/', 'pages.warehouse.stock.index')->name('warehouse.stock.index');
});

// Warehouse - Stock Management Advanced
Route::prefix('warehouse/stock-management')->group(function () {
    Route::view('/', 'pages.warehouse.stock-management.index')->name('warehouse.stock-management.index');
});
