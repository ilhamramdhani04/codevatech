<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed default Super Admin & Teknisi accounts.
     */
    public function run(): void
    {
        // 1. Super Admin Account
        User::updateOrCreate(
            ['email' => 'admin@diagnolap.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        // 2. Teknisi Account
        User::updateOrCreate(
            ['email' => 'teknisi@diagnolap.com'],
            [
                'name'     => 'Budi Teknisi',
                'password' => Hash::make('password123'),
                'role'     => 'teknisi',
            ]
        );
    }
}
