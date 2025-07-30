<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user if doesn't exist
        if (!User::where('email', 'admin@arpul.com')->exists()) {
            User::create([
                'name' => 'Admin Arpul',
                'email' => 'admin@arpul.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin user berhasil dibuat!');
            $this->command->info('📧 Email: admin@arpul.com');
            $this->command->info('🔒 Password: admin123');
        } else {
            $this->command->info('ℹ️ Admin user sudah ada!');
        }

        // Create kasir user if doesn't exist
        if (!User::where('email', 'kasir@arpul.com')->exists()) {
            User::create([
                'name' => 'Kasir Arpul',
                'email' => 'kasir@arpul.com',
                'password' => Hash::make('kasir123'),
                'role' => 'kasir',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Kasir user berhasil dibuat!');
            $this->command->info('📧 Email: kasir@arpul.com');
            $this->command->info('🔒 Password: kasir123');
        } else {
            $this->command->info('ℹ️ Kasir user sudah ada!');
        }

        // Create member user if doesn't exist
        if (!User::where('email', 'member@arpul.com')->exists()) {
            User::create([
                'name' => 'Demo Member',
                'email' => 'member@arpul.com',
                'password' => Hash::make('member123'),
                'role' => 'member',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Member user berhasil dibuat!');
            $this->command->info('📧 Email: member@arpul.com');
            $this->command->info('🔒 Password: member123');
        } else {
            $this->command->info('ℹ️ Member user sudah ada!');
        }
    }
}