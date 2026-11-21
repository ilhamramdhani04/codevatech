<?php

namespace Database\Seeders;

use App\Models\Kerusakan;
use App\Models\Penyebab;
use Illuminate\Database\Seeder;

class PenyebabSeeder extends Seeder
{
    public function run(): void
    {
        $penyebabs = [
            'K01' => [
                'Modul RAM kotor/kendor di slot',
                'RAM rusak fisik',
                'Ketidakcocokan RAM dual-channel',
                'RAM usia pakai lama',
            ],
            'K02' => [
                'Bad sector pada hardisk/SSD',
                'Usia pakai penyimpanan sudah habis',
                'Kerusakan fisik akibat guncangan (HDD)',
                'Kegagalan controller SSD',
            ],
            'K03' => [
                'Overheat berkepanjangan pada GPU',
                'Thermal paste pada VGA kering',
                'Chip GPU retak solder (kasus umum laptop gaming)',
            ],
            'K04' => [
                'Korsleting akibat cairan masuk ke komponen internal',
                'Komponen VRM / capacitor rusak',
                'Kerusakan akibat lonjakan listrik saat charging',
            ],
            'K05' => [
                'Siklus charge sudah tinggi (battery health menurun)',
                'Sel baterai kembung/aus',
                'Kalibrasi baterai salah',
            ],
            'K06' => [
                'Kabel charger putus di dalam',
                'Adaptor rusak akibat korsleting listrik',
                'Konektor DC jack aus/longgar',
            ],
            'K07' => [
                'Debu/kotoran menyumbat mekanisme tombol keyboard',
                'Cairan tumpah ke keyboard',
                'Konektor keyboard ke motherboard longgar',
            ],
            'K08' => [
                'Benturan fisik pada layar',
                'Panel LCD pecah',
                'Kabel fleksibel LCD kendor atau putus',
            ],
            'K09' => [
                'Kipas pendingin kotor berdebu',
                'Bearing kipas aus',
                'Thermal paste kering',
                'Ventilasi pembuangan panas tersumbat',
            ],
            'K10' => [
                'Membran speaker rusak/robek',
                'Konektor audio longgar',
                'Kerusakan chip audio di motherboard',
            ],
            'K11' => [
                'Pemakaian jangka panjang',
                'Sering membuka-tutup layar dengan kasar',
                'Baut engsel kendor atau patah dari dudukan casing',
            ],
            'K12' => [
                'Pin port USB bengkok atau patah',
                'Solderan port lepas dari motherboard',
                'Port aus akibat sering cabut-pasang kabel USB',
            ],
            'K13' => [
                'File sistem rusak akibat mati mendadak saat update',
                'Bad sector di partisi sistem Windows',
                'Crash saat instalasi aplikasi atau update',
            ],
            'K14' => [
                'Download file dari sumber tidak terpercaya',
                'Flashdisk terinfeksi virus terhubung ke laptop',
                'Celah keamanan browser atau sistem belum di-patch',
            ],
            'K15' => [
                'Driver belum terinstall atau hilang',
                'Driver corrupt setelah update Windows',
                'Driver tidak kompatibel dengan versi OS saat ini',
            ],
            'K16' => [
                'Terlalu banyak aplikasi berjalan di background',
                'Startup program berlebihan',
                'Memory leak dari aplikasi tertentu',
            ],
            'K17' => [
                'File temporary Windows menumpuk',
                'Cache aplikasi terlalu besar',
                'Tidak pernah dilakukan disk cleanup berkala',
            ],
            'K18' => [
                'File update yang terunduh corrupt',
                'Komponen Windows Update service bermasalah',
                'Ruang penyimpanan disk C tidak mencukupi',
            ],
            'K19' => [
                'Aplikasi tidak kompatibel dengan versi OS',
                'Dua aplikasi berebut sumber daya sistem',
                'File instalasi aplikasi corrupt',
            ],
            'K20' => [
                'Instalasi/uninstall software yang tidak bersih',
                'Crash sistem saat Windows sedang menulis registry',
                'Malware mengubah susunan registry sistem',
            ],
            'K21' => [
                'Driver touchpad corrupt/belum update atau ter-disable via Fn key',
                'Kabel fleksibel (flex) touchpad kendor atau kotor',
                'Chip controller touchpad / panel fisik rusak',
            ],
            'K22' => [
                'Driver webcam belum terinstall atau corrupt',
                'Izin privasi kamera di-nonaktifkan di Windows Settings',
                'Kabel fleksibel webcam ke motherboard longgar / modul kamera rusak',
            ],
            'K23' => [
                'Sensor kotor oleh debu atau minyak tangan',
                'Driver biometric atau data enrollment Windows Hello corrupt',
                'Modul sensor fingerprint / IR camera rusak fisik',
            ],
            'K24' => [
                'Update BIOS/UEFI terputus di tengah proses (mati listrik/baterai habis saat flashing)',
                'Firmware corrupt akibat serangan malware level-firmware',
                'Chip EEPROM BIOS rusak fisik',
            ],
            'K25' => [
                'Pengaturan Secure Boot/TPM berubah atau reset akibat baterai CMOS habis',
                'Proses update Windows besar (24H2/25H2/26H2) menyentuh konfigurasi sertifikat Secure Boot',
                'Firmware TPM / sertifikat keamanan corrupt',
            ],
            'K26' => [
                'Kabel/konektor USB-C aus akibat pemakaian beban daya (PD) tinggi',
                'Controller Thunderbolt/USB-C di motherboard rusak',
                'Pin port fisik bengkok atau longgar dari board',
            ],
            'K27' => [
                'Driver wireless corrupt atau tidak kompatibel',
                'Modul WiFi card kendor di slot M.2 atau kabel antena terlepas',
                'Kerusakan fisik modul kombo WiFi/Bluetooth',
            ],
            'K28' => [
                'Induktor/capacitor pada jalur VRM bergetar akibat frekuensi switching tinggi saat beban CPU/GPU naik',
                'Kualitas komponen power delivery VRM terdegradasi',
            ],
            'K29' => [
                'Menampilkan gambar statis (taskbar, logo) dalam durasi sangat lama dengan brightness tinggi',
                'Degradasi sub-pixel alami pada panel OLED seiring usia pemakaian',
            ],
            'K30' => [
                'Driver NPU / firmware chip AI belum terinstall atau corrupt',
                'Aplikasi Copilot+ / AI lokal tidak memenuhi syarat spek minimum (NPU <40 TOPS)',
                'Konflik alokasi resource antara NPU dan GPU',
            ],
            'K31' => [
                'Update fitur Windows besar (24H2/25H2/26H2) terputus di tengah instalasi',
                'Driver storage tidak kompatibel dengan build Windows baru',
                'File boot configuration (BCD) korup saat proses update',
            ],
            'K32' => [
                'Cacat produksi pada sel baterai atau suhu laptop sering terlalu tinggi',
                'Kebiasaan charging 0%-100% penuh terus-menerus tanpa fitur charge limit',
                'Firmware Battery Management System (BMS) bermasalah',
            ],
            'K33' => [
                'SSD NVMe tanpa heatsink/thermal pad di slot M.2 berdekatan CPU/GPU',
                'Ventilasi sirkulasi udara buruk atau debu menyumbat',
                'Beban baca/tulis berat berkepanjangan memicu thermal throttling controller SSD',
            ],
        ];

        foreach ($penyebabs as $kodeKerusakan => $listPenyebab) {
            $kerusakan = Kerusakan::where('kode_kerusakan', $kodeKerusakan)->first();
            if ($kerusakan) {
                foreach ($listPenyebab as $deskripsi) {
                    Penyebab::updateOrCreate([
                        'kerusakan_id' => $kerusakan->id,
                        'deskripsi'    => $deskripsi,
                    ]);
                }
            }
        }
    }
}
