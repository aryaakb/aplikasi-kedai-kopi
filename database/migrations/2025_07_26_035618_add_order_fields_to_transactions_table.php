<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menambahkan kolom status setelah 'paid_amount'
            $table->string('status')->after('paid_amount')->default('completed');
            
            // Menambahkan kolom nomor meja, bisa null jika transaksi dari kasir
            $table->string('table_number')->after('status')->nullable();

            // Menambahkan kolom catatan, bisa null
            $table->text('notes')->after('table_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['status', 'table_number', 'notes']);
        });
    }
};
