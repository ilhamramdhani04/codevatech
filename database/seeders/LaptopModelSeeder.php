<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\LaptopModel;
use Illuminate\Database\Seeder;

class LaptopModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            // ============ ASUS ============
            'ASUS' => [
                ['nama_model' => 'ROG Strix G15',           'seri' => 'G513',    'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'ROG Zephyrus G14',        'seri' => 'GA402',   'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'TUF Gaming F15',          'seri' => 'FX507',   'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'VivoBook 14',             'seri' => 'X1402',   'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2023],
                ['nama_model' => 'ZenBook 14',              'seri' => 'UX3402',  'kategori_laptop' => 'ultrabook',   'tahun_rilis' => 2023],
                ['nama_model' => 'VivoBook Pro 15 OLED',    'seri' => 'K6502',   'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2023],
                ['nama_model' => 'ExpertBook B9',           'seri' => 'B9403',   'kategori_laptop' => 'business',    'tahun_rilis' => 2023],
                ['nama_model' => 'ProArt StudioBook 16 OLED','seri' => 'H7604',  'kategori_laptop' => 'workstation', 'tahun_rilis' => 2023],
            ],

            // ============ Lenovo ============
            'Lenovo' => [
                ['nama_model' => 'ThinkPad X1 Carbon Gen 11','seri' => '21HM',   'kategori_laptop' => 'business',    'tahun_rilis' => 2023],
                ['nama_model' => 'IdeaPad Slim 5',          'seri' => '14IAH8',  'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2023],
                ['nama_model' => 'Legion 5 Pro',            'seri' => '16IRX8',  'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'ThinkPad T14 Gen 4',      'seri' => '21HD',    'kategori_laptop' => 'business',    'tahun_rilis' => 2023],
                ['nama_model' => 'Yoga 9i',                 'seri' => '14IAP7',  'kategori_laptop' => 'ultrabook',   'tahun_rilis' => 2022],
                ['nama_model' => 'IdeaPad Gaming 3',        'seri' => '15ARH7',  'kategori_laptop' => 'gaming',      'tahun_rilis' => 2022],
                ['nama_model' => 'LOQ 15',                  'seri' => '15IRH8',  'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
            ],

            // ============ HP ============
            'HP' => [
                ['nama_model' => 'Pavilion 14',             'seri' => '14-dv2xxx',  'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2023],
                ['nama_model' => 'OMEN 16',                 'seri' => '16-b1xxx',   'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'EliteBook 840 G10',       'seri' => null,         'kategori_laptop' => 'business',    'tahun_rilis' => 2023],
                ['nama_model' => 'Spectre x360 14',         'seri' => null,         'kategori_laptop' => 'ultrabook',   'tahun_rilis' => 2023],
                ['nama_model' => 'Victus 16',               'seri' => '16-d1xxx',   'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'ProBook 450 G10',         'seri' => null,         'kategori_laptop' => 'business',    'tahun_rilis' => 2023],
                ['nama_model' => 'HP 245 G9',               'seri' => null,         'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2022],
            ],

            // ============ Dell ============
            'Dell' => [
                ['nama_model' => 'Inspiron 14',             'seri' => '5430',    'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2023],
                ['nama_model' => 'XPS 13 Plus',             'seri' => '9320',    'kategori_laptop' => 'ultrabook',   'tahun_rilis' => 2023],
                ['nama_model' => 'Latitude 5440',           'seri' => null,      'kategori_laptop' => 'business',    'tahun_rilis' => 2023],
                ['nama_model' => 'G15 Gaming',              'seri' => '5530',    'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'Vostro 14',               'seri' => '3430',    'kategori_laptop' => 'business',    'tahun_rilis' => 2023],
                ['nama_model' => 'Alienware m16 R1',        'seri' => null,      'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
            ],

            // ============ Acer ============
            'Acer' => [
                ['nama_model' => 'Aspire 5',               'seri' => 'A515-58',    'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2023],
                ['nama_model' => 'Nitro 5',                 'seri' => 'AN515-58',   'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'Swift 3',                 'seri' => 'SF314-512',  'kategori_laptop' => 'ultrabook',   'tahun_rilis' => 2022],
                ['nama_model' => 'Predator Helios 300',     'seri' => 'PH315-55',   'kategori_laptop' => 'gaming',      'tahun_rilis' => 2022],
                ['nama_model' => 'TravelMate P2',           'seri' => 'TMP214-54',  'kategori_laptop' => 'business',    'tahun_rilis' => 2023],
                ['nama_model' => 'Aspire Vero',             'seri' => 'AV15-52',    'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2022],
            ],

            // ============ MSI ============
            'MSI' => [
                ['nama_model' => 'GF63 Thin',              'seri' => '12VE',       'kategori_laptop' => 'gaming',      'tahun_rilis' => 2022],
                ['nama_model' => 'Katana 15',              'seri' => 'B13VEK',     'kategori_laptop' => 'gaming',      'tahun_rilis' => 2023],
                ['nama_model' => 'Modern 14',              'seri' => 'C13M',       'kategori_laptop' => 'mainstream',  'tahun_rilis' => 2023],
                ['nama_model' => 'Prestige 14 Evo',        'seri' => 'A13M',       'kategori_laptop' => 'ultrabook',   'tahun_rilis' => 2023],
                ['nama_model' => 'Creator Z16P',           'seri' => 'B12UHST',    'kategori_laptop' => 'workstation', 'tahun_rilis' => 2022],
            ],
        ];

        foreach ($models as $brandName => $brandModels) {
            $brand = Brand::where('nama_brand', $brandName)->first();

            if (!$brand) {
                continue;
            }

            foreach ($brandModels as $model) {
                LaptopModel::firstOrCreate(
                    [
                        'brand_id'   => $brand->id,
                        'nama_model' => $model['nama_model'],
                        'seri'       => $model['seri'],
                    ],
                    [
                        'kategori_laptop' => $model['kategori_laptop'],
                        'tahun_rilis'     => $model['tahun_rilis'],
                    ]
                );
            }
        }
    }
}
