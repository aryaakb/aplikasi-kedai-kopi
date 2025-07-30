<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Di sini Anda dapat mendaftarkan route web untuk aplikasi Anda.
| Route ini dimuat oleh RouteServiceProvider dalam grup yang berisi
| middleware "web". Silakan buat sesuatu yang hebat!
|--------------------------------------------------------------------------
*/

/**
 * Halaman utama untuk pengunjung
 */
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

/**
 * Dashboard untuk pengguna yang sudah login
 */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/**
 * Route untuk manajemen profil pengguna
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Route untuk Admin - Manajemen produk, laporan, user, dan notifikasi
 */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // User Management
    Route::resource('users', UserManagementController::class);
    Route::patch('users/{user}/toggle', [UserManagementController::class, 'toggleStatus'])->name('users.toggle');
    
    // Notification Management
    Route::resource('notifications', NotificationController::class);
    Route::patch('notifications/{notification}/toggle', [NotificationController::class, 'toggle'])->name('notifications.toggle');
    Route::post('broadcast', [NotificationController::class, 'broadcast'])->name('broadcast');
    
    // Existing admin routes
    Route::resource('products', ProductController::class, ['as' => 'admin']);
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/export', [ReportController::class, 'export'])->name('reports.export');
});

/**
 * Route untuk Kasir - Manajemen transaksi dan penjualan
 */
Route::middleware(['auth', CheckRole::class . ':kasir'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/confirm-order/{transaction}', [TransactionController::class, 'confirmOrder'])->name('transactions.confirmOrder');
    Route::post('/transactions/cancel-order/{transaction}', [TransactionController::class, 'cancelOrder'])->name('transactions.cancelOrder');
    Route::get('/transactions/load-order/{transaction}', [TransactionController::class, 'loadOrder'])->name('transactions.loadOrder');
    Route::post('/transactions/add-to-cart', [TransactionController::class, 'addToCart'])->name('transactions.addToCart');
    Route::post('/transactions/remove-from-cart', [TransactionController::class, 'removeFromCart'])->name('transactions.removeFromCart');
    Route::post('/transactions/complete', [TransactionController::class, 'complete'])->name('transactions.complete');
    Route::get('/transactions/success/{id}', [TransactionController::class, 'success'])->name('transactions.success');
    Route::get('/transactions/receipt/{id}', [TransactionController::class, 'receipt'])->name('transactions.receipt');
});

/**
 * Route untuk Member - Menu dan pemesanan
 */
Route::middleware(['auth', CheckRole::class . ':member'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu/add-to-cart', [MenuController::class, 'addToCart'])->name('menu.addToCart');
    Route::post('/menu/remove-from-cart', [MenuController::class, 'removeFromCart'])->name('menu.removeFromCart');
    Route::post('/menu/place-order', [MenuController::class, 'placeOrder'])->name('menu.placeOrder');
    Route::get('/my-orders', [MenuController::class, 'myOrders'])->name('orders.index');
    
    // Favorites routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/favorites/add/{product}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/remove/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');
});

require __DIR__.'/auth.php';
