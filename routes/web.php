<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Warehouse\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LokasiRakController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('barang', BarangController::class)->only(['index']);
    Route::resource('barang-masuk', BarangMasukController::class)->only(['index']);
    Route::get('barang-masuk/pdf/export', [BarangMasukController::class, 'exportPdf'])->name('barang-masuk.pdf');
    Route::resource('cabang', CabangController::class)->only(['index']);
    Route::resource('barang-keluar', BarangKeluarController::class)->only(['index']);
    Route::resource('armada/drivers', DriverController::class)->names('armada.drivers')->only(['index', 'show', 'create', 'store']);
    Route::resource('kendaraan', KendaraanController::class)->only(['index', 'show', 'create', 'store']);
    Route::get('lokasi-rak', [LokasiRakController::class, 'index'])
        ->name('lokasi-rak.index');

    Route::middleware(['role:admin_gudang'])->group(function () {
        Route::resource('barang', BarangController::class)->except(['index', 'show']);
        Route::resource('barang-masuk', BarangMasukController::class)->except(['index', 'show']);
        Route::resource('cabang', CabangController::class)->except(['index', 'show']);
        Route::resource('barang-keluar', BarangKeluarController::class)->except(['index', 'show']);
        Route::resource('armada/drivers', DriverController::class)->names('armada.drivers')->only(['edit', 'update', 'destroy']);
        Route::resource('kendaraan', KendaraanController::class)->only(['edit', 'update', 'destroy']);
        Route::get('lokasi-rak/create', [LokasiRakController::class, 'create'])
            ->name('lokasi-rak.create');
        Route::post('lokasi-rak', [LokasiRakController::class, 'store'])
            ->name('lokasi-rak.store');
        Route::get('lokasi-rak/{rakLocation}/edit', [LokasiRakController::class, 'edit'])
            ->name('lokasi-rak.edit');
        Route::put('lokasi-rak/{rakLocation}', [LokasiRakController::class, 'update'])
            ->name('lokasi-rak.update');
        Route::delete('lokasi-rak/{rakLocation}', [LokasiRakController::class, 'destroy'])
            ->name('lokasi-rak.destroy');

        Route::post('barang-keluar/{id}/complete-delivery', [BarangKeluarController::class, 'completeDelivery'])->name('barang-keluar.complete-delivery');
        Route::get('barang-keluar/{id}/cetak', [BarangKeluarController::class, 'cetak'])->name('barang-keluar.cetak');
    });

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('warehouse/stock')->group(function () {
        Route::get('/', [\App\Http\Controllers\Warehouse\LaporanStokController::class, 'index'])->name('warehouse.stock.index');
        Route::get('/pdf', [\App\Http\Controllers\Warehouse\LaporanStokController::class, 'exportPdf'])->name('warehouse.stock.pdf');
    });

    Route::prefix('warehouse/stock-management')->group(function () {
        Route::get('/', [\App\Http\Controllers\Warehouse\StokBarangController::class, 'index'])
            ->name('warehouse.stock-management.index');
    });

    Route::prefix('warehouse/reports/stock')->group(function () {
        Route::get('/', [\App\Http\Controllers\Warehouse\LaporanStokController::class, 'index'])
            ->name('warehouse.reports.stock.index');
    });

    Route::prefix('warehouse/outbound')->group(function () {
        Route::get('/', [BarangKeluarController::class, 'index'])->name('warehouse.outbound.index');
        Route::get('/pdf', [BarangKeluarController::class, 'exportPdf'])->name('warehouse.outbound.pdf');
    });

    Route::middleware(['role:manager'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});





