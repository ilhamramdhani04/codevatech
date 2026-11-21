<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['id' => 1, 'nama_kategori' => 'Hardware'],
            ['id' => 2, 'nama_kategori' => 'Software'],
            ['id' => 3, 'nama_kategori' => 'Firmware'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::updateOrCreate(['id' => $kategori['id']], $kategori);
        }
    }
}
