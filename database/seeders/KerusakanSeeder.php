<?php

namespace Database\Seeders;

use App\Models\Kerusakan;
use Illuminate\Database\Seeder;

class KerusakanSeeder extends Seeder
{
    public function run(): void
    {
        $kerusakans = [
            ['kode_kerusakan' => 'K01', 'nama_kerusakan' => 'Kerusakan RAM', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K02', 'nama_kerusakan' => 'Kerusakan Hardisk/SSD (bad sector / storage fail)', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K03', 'nama_kerusakan' => 'Kerusakan VGA/GPU', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K04', 'nama_kerusakan' => 'Kerusakan Motherboard (short circuit)', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K05', 'nama_kerusakan' => 'Kerusakan Baterai (drop/aus)', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K06', 'nama_kerusakan' => 'Kerusakan Charger/Adaptor', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K07', 'nama_kerusakan' => 'Kerusakan Keyboard', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K08', 'nama_kerusakan' => 'Kerusakan LCD/Layar', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K09', 'nama_kerusakan' => 'Kerusakan Sistem Pendingin (Fan/Heatsink)', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K10', 'nama_kerusakan' => 'Kerusakan Speaker', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K11', 'nama_kerusakan' => 'Kerusakan Engsel (Hinge)', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K12', 'nama_kerusakan' => 'Kerusakan Port USB/Konektor', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K13', 'nama_kerusakan' => 'Sistem Operasi Corrupt/Rusak', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K14', 'nama_kerusakan' => 'Infeksi Virus/Malware/Ransomware', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K15', 'nama_kerusakan' => 'Driver Bermasalah/Tidak Kompatibel', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K16', 'nama_kerusakan' => 'RAM Overload akibat Software (bukan hardware)', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K17', 'nama_kerusakan' => 'Penyimpanan Penuh (Storage Overload)', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K18', 'nama_kerusakan' => 'Windows Update Gagal/Corrupt', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K19', 'nama_kerusakan' => 'Konflik Aplikasi/Software Crash', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K20', 'nama_kerusakan' => 'Registry Windows Corrupt', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K21', 'nama_kerusakan' => 'Kerusakan Touchpad', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K22', 'nama_kerusakan' => 'Kerusakan Webcam', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K23', 'nama_kerusakan' => 'Kerusakan Fingerprint/Biometric Sensor', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K24', 'nama_kerusakan' => 'BIOS/UEFI Firmware Corrupt', 'kategori_id' => 3],
            ['kode_kerusakan' => 'K25', 'nama_kerusakan' => 'TPM/Secure Boot Corrupt', 'kategori_id' => 3],
            ['kode_kerusakan' => 'K26', 'nama_kerusakan' => 'Kerusakan Port Thunderbolt/USB-C', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K27', 'nama_kerusakan' => 'Kerusakan Modul WiFi/Bluetooth', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K28', 'nama_kerusakan' => 'Kerusakan Komponen Elektronik (Coil Whine)', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K29', 'nama_kerusakan' => 'Burn-in Panel OLED', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K30', 'nama_kerusakan' => 'NPU/AI Chip Driver-Firmware Error', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K31', 'nama_kerusakan' => 'Update Windows Corrupt (Bootloop Pasca-Update)', 'kategori_id' => 2],
            ['kode_kerusakan' => 'K32', 'nama_kerusakan' => 'Baterai Rapid Degradation (Kegagalan Sel Dini)', 'kategori_id' => 1],
            ['kode_kerusakan' => 'K33', 'nama_kerusakan' => 'Kerusakan Controller SSD NVMe (Thermal Throttling)', 'kategori_id' => 1],
        ];

        foreach ($kerusakans as $kerusakan) {
            Kerusakan::updateOrCreate(['kode_kerusakan' => $kerusakan['kode_kerusakan']], $kerusakan);
        }
    }
}
