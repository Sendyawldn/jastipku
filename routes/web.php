<?php
// p/routes/web.php

use Illuminate\Support\Facades\Route;

// General Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;

// Customer Controllers
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\HistoryController as CustomerHistoryController;

// Traveler Controllers
use App\Http\Controllers\Traveler\DashboardController as TravelerDashboardController;
use App\Http\Controllers\Traveler\ActiveOrderController as TravelerActiveOrderController;
use App\Http\Controllers\Traveler\HistoryController as TravelerHistoryController;
use App\Http\Controllers\Traveler\EarningsController as TravelerEarningsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute Landing Page (Bisa diakses siapa saja)
Route::get('/', [WelcomeController::class, 'index'])->name('landing');
Route::get('/load-more-orders', [WelcomeController::class, 'loadMoreOrders'])->name('orders.load-more');

// ==> PASTIKAN BARIS INI SUDAH DIPERBAIKI (Route::get bukan Route.::get)
Route::get('/get-kota-by-pulau', [WelcomeController::class, 'getKotaByPulauAjax'])->name('get.kota.by.pulau');

// ==> PASTIKAN RUTE INI SUDAH ADA
Route::get('/pesanan/{order}/detail', [WelcomeController::class, 'showOrder'])->name('orders.show_public');


// Fallback dashboard setelah login, akan mengarahkan user sesuai perannya
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Grup Rute yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- GRUP RUTE UNTUK CUSTOMER (PENITIP) ---
    Route::prefix('customer')->name('customer.')->middleware('role:penitip')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

        // Order routes
        Route::get('/pesanan-saya', [CustomerOrderController::class, 'index'])->name('orders.index');
        Route::get('/buat-pesanan', [CustomerOrderController::class, 'create'])->name('orders.create');
        Route::post('/buat-pesanan', [CustomerOrderController::class, 'store'])->name('orders.store');
        Route::get('/pesanan/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
        Route::get('/pesanan/{order}/edit', [CustomerOrderController::class, 'edit'])->name('orders.edit');
        Route::patch('/pesanan/{order}', [CustomerOrderController::class, 'update'])->name('orders.update');
        Route::delete('/pesanan/{order}', [CustomerOrderController::class, 'destroy'])->name('orders.destroy');
        Route::patch('/pesanan/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('orders.cancel');

        // Additional order actions
        Route::patch('/pesanan/{order}/rate', [CustomerOrderController::class, 'rate'])->name('orders.rate');
        Route::get('/pesanan/{order}/reorder', [CustomerOrderController::class, 'reorder'])->name('orders.reorder');
        Route::get('/pesanan/{order}/invoice', [CustomerOrderController::class, 'invoice'])->name('orders.invoice');

        // History route
        Route::get('/riwayat-transaksi', [CustomerHistoryController::class, 'index'])->name('history.index');
    });

    // Traveler routes
    Route::middleware(['auth', 'role:traveler'])->prefix('traveler')->name('traveler.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Traveler\DashboardController::class, 'index'])->name('dashboard');

        // Active Orders
        Route::get('/pesanan-aktif', [App\Http\Controllers\Traveler\ActiveOrderController::class, 'index'])->name('active_orders.index');
        Route::get('/active-orders/{order}', [App\Http\Controllers\Traveler\ActiveOrderController::class, 'show'])->name('active_orders.show');

        // Order Actions
        Route::post('/orders/{order}/accept', [App\Http\Controllers\Traveler\ActiveOrderController::class, 'accept'])->name('orders.accept');
        Route::patch('/orders/{order}/start', [App\Http\Controllers\Traveler\ActiveOrderController::class, 'start'])->name('orders.start');
        Route::patch('/orders/{order}/complete', [App\Http\Controllers\Traveler\ActiveOrderController::class, 'complete'])->name('orders.complete');
        Route::patch('/orders/{order}/cancel', [App\Http\Controllers\Traveler\ActiveOrderController::class, 'cancel'])->name('orders.cancel');

        // Earnings
        Route::get('/penghasilan', [App\Http\Controllers\Traveler\EarningsController::class, 'index'])->name('earnings.index');
        Route::post('/earnings/withdraw', [App\Http\Controllers\Traveler\EarningsController::class, 'withdraw'])->name('earnings.withdraw');
        Route::get('/penghasilan/history', [App\Http\Controllers\Traveler\EarningsController::class, 'history'])->name('earnings.history');

        // History
        Route::get('/history', [App\Http\Controllers\Traveler\HistoryController::class, 'index'])->name('history.index');
        Route::get('/history/{order}/invoice', [App\Http\Controllers\Traveler\HistoryController::class, 'invoice'])->name('history.invoice'); // Rute baru ditambahkan di sini
    });
});

// Memuat rute untuk autentikasi (login, register, dll.) dari Laravel Breeze
require __DIR__ . '/auth.php';