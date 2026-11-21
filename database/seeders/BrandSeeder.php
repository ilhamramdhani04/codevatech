<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'nama_brand' => 'ASUS',
                'logo_url'   => 'https://upload.wikimedia.org/wikipedia/commons/2/2e/ASUS_Logo.svg',
            ],
            [
                'nama_brand' => 'Lenovo',
                'logo_url'   => 'https://upload.wikimedia.org/wikipedia/commons/b/b8/Lenovo_logo_2015.svg',
            ],
            [
                'nama_brand' => 'HP',
                'logo_url'   => 'https://upload.wikimedia.org/wikipedia/commons/a/ad/HP_logo_2012.svg',
            ],
            [
                'nama_brand' => 'Dell',
                'logo_url'   => 'https://upload.wikimedia.org/wikipedia/commons/8/82/Dell_logo_2016.svg',
            ],
            [
                'nama_brand' => 'Acer',
                'logo_url'   => 'https://upload.wikimedia.org/wikipedia/commons/0/00/Acer_2011.svg',
            ],
            [
                'nama_brand' => 'MSI',
                'logo_url'   => 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Micro-Star_International_logo.svg',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['nama_brand' => $brand['nama_brand']],
                $brand
            );
        }
    }
}
