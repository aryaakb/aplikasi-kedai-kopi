<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::all();

echo "=== USERS DALAM DATABASE ===\n";
foreach ($users as $user) {
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n"; 
    echo "Role: " . $user->role . "\n";
    echo "---\n";
}

echo "\n=== PRODUCTS DALAM DATABASE ===\n";
$products = App\Models\Product::all();
echo "Total products: " . $products->count() . "\n";

echo "\n=== TRANSACTIONS DALAM DATABASE ===\n";
$transactions = App\Models\Transaction::all();
echo "Total transactions: " . $transactions->count() . "\n";