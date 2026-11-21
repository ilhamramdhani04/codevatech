<?php

namespace Database\Seeders;

use App\Models\Kerusakan;
use App\Models\Solusi;
use Illuminate\Database\Seeder;

class SolusiSeeder extends Seeder
{
    public function run(): void
    {
        $solusis = [
            'K01' => [
                'Bersihkan pin RAM dengan penghapus karet secara perlahan.',
                'Cek kesehatan RAM menggunakan aplikasi MemTest86.',
                'Coba pindahkan modul RAM ke slot lain pada motherboard.',
                'Ganti modul RAM baru jika ditemukan kerusakan permanen.',
            ],
            'K02' => [
                'Lakukan backup data penting segera ke media eksternal.',
                'Cek kesehatan hardisk/SSD menggunakan CrystalDiskInfo atau HDDScan.',
                'Jalankan perintah CHKDSK via Command Prompt untuk memperbaiki file system.',
                'Ganti ke SSD baru jika ditemukan bad sector parah.',
            ],
            'K03' => [
                'Bawa laptop ke teknisi untuk reflow/reball chip GPU.',
                'Ganti thermal paste GPU dengan komponen berkuaitas tinggi.',
                'Pastikan ventilasi pembuangan panas laptop tidak tertutup.',
                'Update driver GPU ke versi stabil terbaru.',
            ],
            'K04' => [
                'Bawa ke teknisi profesional untuk pengecekan jalur PCB motherboard.',
                'Ganti komponen komponen elektronik (capacitors/VRM) yang kShort.',
                'Jika kerusakan parah pada papan sirkuit utama, lakukan penggantian motherboard.',
            ],
            'K05' => [
                'Cek battery health via Command Prompt (`powercfg /batteryreport`).',
                'Lakukan kalibrasi ulang baterai laptop.',
                'Ganti baterai laptop jika health sudah di bawah 50% atau kembung.',
            ],
            'K06' => [
                'Cek output tegangan charger menggunakan multimeter.',
                'Ganti kabel adaptor atau unit charger dengan yang original/kompatibel.',
                'Servis konektor DC jack di laptop bila ternyata longgar.',
            ],
            'K07' => [
                'Bersihkan sela-sela tombol keyboard dengan compressed air.',
                'Lepas dan pasang kembali kabel fleksibel keyboard ke motherboard.',
                'Ganti unit keyboard jika membrane mengalami kerusakan fisik.',
                'Gunakan keyboard USB/Bluetooth eksternal sebagai solusi sementara.',
            ],
            'K08' => [
                'Cek dan pasang ulang kabel fleksibel LCD.',
                'Ganti panel LCD jika layar retak atau pecah.',
                'Hindari memberi tekanan berlebih pada layar saat menutup laptop.',
            ],
            'K09' => [
                'Bongkar bodi laptop dan bersihkan kipas serta heatsink dari debu.',
                'Ganti thermal paste lama pada processor dan GPU.',
                'Ganti unit kipas baru jika putaran kasar atau berbunyi keras.',
            ],
            'K10' => [
                'Cek pengaturan audio dan pastikan driver audio terpasang benar.',
                'Pasang ulang konektor kabel speaker ke motherboard.',
                'Ganti unit speaker eksternal/internal jika membran speaker robek.',
            ],
            'K11' => [
                'Kencangkan atau ganti baut engsel yang kendor/patah.',
                'Ganti unit engsel (hinge) dan perbaiki dudukan baut pada casing laptop.',
            ],
            'K12' => [
                'Cek fisik port USB dari kotoran atau pin yang bengkok.',
                'Solder ulang kaki port USB jika lepas dari papan motherboard.',
                'Ganti port USB dengan komponen baru oleh teknisi.',
            ],
            'K13' => [
                'Jalankan Startup Repair menggunakan media instalasi Windows.',
                'Jalankan perintah `sfc /scannow` via Command Prompt Administrator.',
                'Lakukan Repair Install atau instalasi ulang sistem operasi Windows.',
            ],
            'K14' => [
                'Lakukan full scan sistem menggunakan Windows Defender atau Malwarebytes.',
                'Putuskan koneksi internet saat proses pembersihan virus.',
                'Restore data dari backup jika terinfeksi ransomware (jangan bayar tebusan).',
            ],
            'K15' => [
                'Cek status perangkat pada Device Manager.',
                'Uninstall driver bermasalah lalu install ulang dari situs resmi manufaktur.',
                'Gunakan fasilitas Windows Update untuk mencari driver secara otomatis.',
            ],
            'K16' => [
                'Matikan aplikasi startup yang tidak perlu melalui Task Manager.',
                'Tutup aplikasi background yang memakan memori tinggi.',
                'Pertimbangkan upgrade kapasitas RAM jika kebutuhan memang meningkat.',
            ],
            'K17' => [
                'Jalankan fitur Disk Cleanup pada drive C:.',
                'Hapus file temporary pada direktori %temp%.',
                'Uninstall aplikasi besar yang tidak pernah digunakan.',
                'Pindahkan file media besar ke cloud storage atau media penyimpanan eksternal.',
            ],
            'K18' => [
                'Jalankan fitur Windows Update Troubleshooter bawaan Windows.',
                'Reset komponen Windows Update service melalui Command Prompt.',
                'Pastikan sisa ruang penyimpanan di disk C: minimal 20GB.',
            ],
            'K19' => [
                'Update aplikasi yang crash ke versi paling stabil.',
                'Lakukan install ulang (reinstall) pada aplikasi yang bermasalah.',
                'Periksa detail error melalui Windows Event Viewer.',
            ],
            'K20' => [
                'Gunakan fitur System Restore ke restore point sebelum terjadi error.',
                'Lakukan scan dan perbaikan registry secara hati-hati.',
                'Jalankan Repair Install Windows jika kerusakan registry merusak sistem.',
            ],
            'K21' => [
                'Cek toggle Fn+touchpad dan Settings > Bluetooth & devices > Touchpad.',
                'Update/reinstall driver precision touchpad lewat Device Manager.',
                'Buka casing dan cek konektor fleksibel touchpad.',
                'Ganti unit touchpad jika fisik rusak, sementara gunakan mouse eksternal.',
            ],
            'K22' => [
                'Cek Settings > Privacy & Security > Camera pastikan aplikasi diizinkan akses.',
                'Update/reinstall driver kamera via Device Manager.',
                'Buka casing untuk cek konektor kabel fleksibel kamera.',
                'Ganti modul kamera jika rusak fisik.',
            ],
            'K23' => [
                'Bersihkan permukaan sensor fingerprint dari debu / minyak.',
                'Hapus dan daftar ulang sidik jari/wajah lewat Settings > Accounts > Sign-in options.',
                'Update driver biometric via Windows Update.',
                'Reset TPM (tpm.msc) jika Windows Hello tetap gagal.',
            ],
            'K24' => [
                'Coba BIOS recovery mode (kombinasi tombol khusus vendor, mis. Fn+Esc / Fn+B).',
                'Flash ulang BIOS menggunakan USB recovery dari situs resmi vendor.',
                'Reflash chip BIOS via programmer eksternal oleh teknisi lab jika recovery mode gagal.',
            ],
            'K25' => [
                'Masuk BIOS/UEFI dan aktifkan kembali TPM 2.0 & Secure Boot.',
                'Pastikan menerima update sertifikat Secure Boot terbaru lewat Windows Update.',
                'Simpan BitLocker recovery key dari akun Microsoft sebelum update besar.',
                'Ganti baterai CMOS jika pengaturan BIOS terus-menerus reset sendiri.',
            ],
            'K26' => [
                'Cek dengan kabel & charger lain untuk mengisolasi masalah.',
                'Bersihkan port USB-C/Thunderbolt dari debu pakai udara bertekanan.',
                'Update driver/firmware Thunderbolt lewat tool resmi Intel/vendor.',
                'Servis solder ulang port oleh teknisi jika kontak fisik lepas dari motherboard.',
            ],
            'K27' => [
                'Update driver wireless dari situs resmi vendor chipset (Intel/Qualcomm/MediaTek).',
                'Buka casing dan pastikan modul WiFi terpasang rapat di slot M.2 serta kabel antena tersambung.',
                'Ganti modul WiFi/Bluetooth jika rusak permanen.',
            ],
            'K28' => [
                'Batasi frame rate/power limit lewat software (cap FPS) untuk mengurangi beban VRM.',
                'Update BIOS untuk power management yang lebih stabil.',
                'Bawa ke teknisi lab untuk inspeksi komponen VRM jika disertai overheat / shutdown.',
            ],
            'K29' => [
                'Aktifkan fitur pixel refresh / anti burn-in bawaan vendor.',
                'Gunakan wallpaper dinamis dan auto-hide taskbar.',
                'Turunkan brightness ke level wajar.',
                'Ganti panel OLED jika burn-in sudah parah dan mengganggu.',
            ],
            'K30' => [
                'Update driver NPU lewat Windows Update atau situs resmi vendor chipset.',
                'Pastikan Windows 11 sudah di versi 24H2/25H2 ke atas (syarat Copilot+ PC).',
                'Reinstall aplikasi AI yang bermasalah.',
            ],
            'K31' => [
                'Masuk Windows Recovery Environment (WinRE) lewat restart paksa 3x.',
                'Gunakan opsi "Uninstall Updates" untuk rollback ke build sebelumnya.',
                'Jalankan Startup Repair atau `bootrec /rebuildbcd` via Command Prompt.',
                'Reset PC dengan opsi "Keep my files" jika pemulihan lain gagal.',
            ],
            'K32' => [
                'Cek battery report (`powercfg /batteryreport`) untuk melihat kapasitas desain vs aktual.',
                'Aktifkan fitur battery care / charge limit (membatasi charging di 80%).',
                'Ajukan klaim garansi atau ganti unit baterai baru.',
            ],
            'K33' => [
                'Pasang heatsink / thermal pad tambahan pada SSD NVMe.',
                'Cek suhu SSD lewat CrystalDiskInfo (pastikan <70°C).',
                'Bersihkan kipas & ventilasi sirkulasi udara laptop.',
                'Ganti unit SSD NVMe jika controller sudah aus permanently.',
            ],
        ];

        foreach ($solusis as $kodeKerusakan => $listSolusi) {
            $kerusakan = Kerusakan::where('kode_kerusakan', $kodeKerusakan)->first();
            if ($kerusakan) {
                foreach ($listSolusi as $index => $deskripsi) {
                    Solusi::updateOrCreate([
                        'kerusakan_id' => $kerusakan->id,
                        'urutan'       => $index + 1,
                    ], [
                        'deskripsi'    => $deskripsi,
                    ]);
                }
            }
        }
    }
}
