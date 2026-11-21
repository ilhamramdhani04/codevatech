<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            KategoriSeeder::class,
            GejalaSeeder::class,
            KerusakanSeeder::class,
            PenyebabSeeder::class,
            SolusiSeeder::class,
            RuleSeeder::class,
            BrandSeeder::class,
            LaptopModelSeeder::class,
        ]);
    }
}
