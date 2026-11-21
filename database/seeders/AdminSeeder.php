<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@diagnolap.com',
        ], [
            'name'     => 'Administrator DiagnoLap',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);
    }
}
