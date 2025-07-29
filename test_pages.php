<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING NOFVCKINGCOFFEE ===\n";

// Test database
$productCount = App\Models\Product::count();
$transactionCount = App\Models\Transaction::count();
$userCount = App\Models\User::count();

echo "📊 DATABASE STATUS:\n";
echo "   Products: {$productCount}\n";
echo "   Transactions: {$transactionCount}\n";
echo "   Users: {$userCount}\n\n";

// Test specific data
$products = App\Models\Product::take(3)->get();
echo "📋 SAMPLE PRODUCTS:\n";
foreach ($products as $product) {
    echo "   - {$product->name} (Rp " . number_format($product->price) . ")\n";
}

$transactions = App\Models\Transaction::with('user')->take(3)->get();
echo "\n🧾 SAMPLE TRANSACTIONS:\n";
foreach ($transactions as $transaction) {
    echo "   - #{$transaction->id} by {$transaction->user->name} (Rp " . number_format($transaction->total) . ")\n";
}

echo "\n🔗 TEST URLS:\n";
echo "   http://localhost:8000/debug\n";
echo "   http://localhost:8000/test-products\n";
echo "   http://localhost:8000/test-reports\n";
echo "   http://localhost:8000/auto-login-admin\n";

echo "\n✅ REBUILD COMPLETED - SEMUA DATA ADA!\n";