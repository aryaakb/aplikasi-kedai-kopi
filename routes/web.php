<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;

// Import middleware Anda di sini
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Welcome untuk tamu (pengguna yang belum login)
Route::get('/', function () {
    // Cek jika user sudah login, arahkan ke dashboard, jika belum, tampilkan welcome
    // Diubah menggunakan Auth Facade agar lebih eksplisit
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// Dashboard untuk pengguna yang sudah login
// Path diubah menjadi /dashboard agar tidak bentrok dengan halaman welcome
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route untuk profil, bisa diakses semua role
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route test untuk debugging - FRESH REBUILD
Route::get('/fresh-products', function() {
    $products = App\Models\Product::all();
    echo "<h1>FRESH PRODUCTS TEST - Count: " . $products->count() . "</h1>";
    if ($products->count() > 0) {
        echo "<ul>";
        foreach($products as $product) {
            echo "<li>{$product->name} - Rp " . number_format($product->price) . " (Stock: {$product->stock})</li>";
        }
        echo "</ul>";
        echo "<br><a href='/products' style='background:blue;color:white;padding:10px;text-decoration:none;'>GO TO PRODUCTS PAGE</a>";
    } else {
        echo "<p style='color:red;'>NO PRODUCTS FOUND!</p>";
    }
})->name('fresh.products');

Route::get('/fresh-reports', function() {
    $transactions = App\Models\Transaction::with(['user', 'details.product'])->get();
    $total = $transactions->sum('total');
    echo "<h1>FRESH REPORTS TEST - Count: " . $transactions->count() . "</h1>";
    echo "<p>Total Revenue: Rp " . number_format($total) . "</p>";
    if ($transactions->count() > 0) {
        echo "<ul>";
        foreach($transactions->take(5) as $t) {
            echo "<li>#{$t->id} - {$t->user->name} - Rp " . number_format($t->total) . " ({$t->created_at})</li>";
        }
        echo "</ul>";
        echo "<br><a href='/reports' style='background:green;color:white;padding:10px;text-decoration:none;'>GO TO REPORTS PAGE</a>";
    } else {
        echo "<p style='color:red;'>NO TRANSACTIONS FOUND!</p>";
    }
})->name('fresh.reports');

// Route test untuk debugging
Route::get('/test-products', function() {
    $products = App\Models\Product::all();
    return view('products.index', compact('products'));
})->name('test.products');

Route::get('/test-reports', function() {
    $transactions = App\Models\Transaction::with(['user', 'details.product'])->get();
    $total = $transactions->sum('total');
    $startDate = now()->subDays(30)->format('Y-m-d');
    $endDate = now()->format('Y-m-d');
    return view('reports.index', compact('transactions', 'total', 'startDate', 'endDate'));
})->name('test.reports');

// Debug page
Route::get('/debug', function() {
    $products = App\Models\Product::all();
    $transactions = App\Models\Transaction::with(['user', 'details'])->get();
    $users = App\Models\User::all();
    return view('debug', compact('products', 'transactions', 'users'));
})->name('debug');

// Auto login as admin for testing
Route::get('/auto-login-admin', function() {
    $admin = App\Models\User::where('email', 'admin@coffee.com')->first();
    if ($admin) {
        Auth::login($admin);
        return redirect()->route('dashboard')->with('success', 'Logged in as admin for testing');
    }
    return 'Admin user not found';
})->name('auto.login.admin');

// Route untuk Admin
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// Route untuk Kasir
Route::middleware(['auth', CheckRole::class . ':cashier'])->group(function () {
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

// Route untuk Member
Route::middleware(['auth', CheckRole::class . ':member'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu/add-to-cart', [MenuController::class, 'addToCart'])->name('menu.addToCart');
    Route::post('/menu/remove-from-cart', [MenuController::class, 'removeFromCart'])->name('menu.removeFromCart');
    Route::post('/menu/place-order', [MenuController::class, 'placeOrder'])->name('menu.placeOrder');
    Route::get('/my-orders', [MenuController::class, 'myOrders'])->name('orders.index');
});

require __DIR__.'/auth.php';
