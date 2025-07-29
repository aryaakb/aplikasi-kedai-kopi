<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@coffee.com')->first();
        $kasir = User::where('email', 'kasir@coffee.com')->first();
        $products = Product::all();

        if (!$admin || !$kasir || $products->count() == 0) {
            $this->command->error('Please run DatabaseSeeder first to create users and products');
            return;
        }

        // Create 10 sample transactions
        for ($i = 0; $i < 10; $i++) {
            $user = $i % 2 == 0 ? $admin : $kasir;
            $totalAmount = 0;
            
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total' => 0, // Will be calculated
                'table_number' => 'T-' . rand(1, 25),
                'notes' => 'Test order ' . ($i + 1),
                'paid_amount' => 0, // Will be calculated
                'created_at' => now()->subDays(rand(0, 10))
            ]);
            
            // Add 1-4 random products to each transaction
            $selectedProducts = $products->random(rand(1, 4));
            
            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;
                $subtotal = $quantity * $price;
                $totalAmount += $subtotal;
                
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ]);
            }
            
            // Update transaction with calculated total
            $paidAmount = $totalAmount + rand(0, 10000); // Add some change
            $transaction->update([
                'total' => $totalAmount,
                'paid_amount' => $paidAmount
            ]);
        }
        
        $this->command->info('Created 10 sample transactions successfully!');
    }
}