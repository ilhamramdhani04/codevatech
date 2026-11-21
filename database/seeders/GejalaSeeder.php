<?php

namespace Database\Seeders;

use App\Models\Gejala;
use Illuminate\Database\Seeder;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        $gejalas = [
            ['kode_gejala' => 'G01', 'nama_gejala' => 'Laptop tidak mau menyala sama sekali (no power)'],
            ['kode_gejala' => 'G02', 'nama_gejala' => 'Lampu indikator power menyala tapi layar tetap blank/hitam'],
            ['kode_gejala' => 'G03', 'nama_gejala' => 'Laptop menyala lalu langsung mati sendiri (shutdown mendadak)'],
            ['kode_gejala' => 'G04', 'nama_gejala' => 'Muncul bunyi beep berulang saat booting'],
            ['kode_gejala' => 'G05', 'nama_gejala' => 'Layar menampilkan garis-garis vertikal/horizontal'],
            ['kode_gejala' => 'G06', 'nama_gejala' => 'Layar berkedip-kedip (flickering)'],
            ['kode_gejala' => 'G07', 'nama_gejala' => 'Tampilan layar pecah/blank spot tapi laptop tetap menyala normal'],
            ['kode_gejala' => 'G08', 'nama_gejala' => 'Layar retak fisik akibat benturan'],
            ['kode_gejala' => 'G09', 'nama_gejala' => 'Laptop sangat lambat saat membuka aplikasi'],
            ['kode_gejala' => 'G10', 'nama_gejala' => 'Muncul Blue Screen of Death (BSOD)'],
            ['kode_gejala' => 'G11', 'nama_gejala' => 'Laptop restart sendiri secara tiba-tiba'],
            ['kode_gejala' => 'G12', 'nama_gejala' => 'Suara kipas sangat kencang/berisik'],
            ['kode_gejala' => 'G13', 'nama_gejala' => 'Bodi laptop terasa sangat panas'],
            ['kode_gejala' => 'G14', 'nama_gejala' => 'Laptop mati otomatis saat digunakan untuk kerja berat (gaming/render)'],
            ['kode_gejala' => 'G15', 'nama_gejala' => 'Baterai cepat habis meski baru saja diisi penuh'],
            ['kode_gejala' => 'G16', 'nama_gejala' => 'Baterai tidak terisi walau charger terpasang'],
            ['kode_gejala' => 'G17', 'nama_gejala' => 'Indikator baterai menunjukkan 0% atau tidak terdeteksi'],
            ['kode_gejala' => 'G18', 'nama_gejala' => 'Laptop hanya bisa menyala saat charger terpasang'],
            ['kode_gejala' => 'G19', 'nama_gejala' => 'Charger tidak mengeluarkan lampu indikator sama sekali'],
            ['kode_gejala' => 'G20', 'nama_gejala' => 'Kabel charger terasa panas berlebih saat dipakai'],
            ['kode_gejala' => 'G21', 'nama_gejala' => 'Beberapa tombol keyboard tidak berfungsi'],
            ['kode_gejala' => 'G22', 'nama_gejala' => 'Semua tombol keyboard tidak berfungsi'],
            ['kode_gejala' => 'G23', 'nama_gejala' => 'Tombol keyboard menekan huruf yang salah dari yang diketik'],
            ['kode_gejala' => 'G24', 'nama_gejala' => 'Suara dari speaker tidak keluar sama sekali'],
            ['kode_gejala' => 'G25', 'nama_gejala' => 'Suara dari speaker pecah/berdesing'],
            ['kode_gejala' => 'G26', 'nama_gejala' => 'Engsel layar terasa longgar/goyang'],
            ['kode_gejala' => 'G27', 'nama_gejala' => 'Engsel layar berbunyi berderit saat dibuka-tutup'],
            ['kode_gejala' => 'G28', 'nama_gejala' => 'Port USB tidak mendeteksi perangkat apa pun'],
            ['kode_gejala' => 'G29', 'nama_gejala' => 'Port USB mendeteksi perangkat tapi koneksi putus-nyambung'],
            ['kode_gejala' => 'G30', 'nama_gejala' => 'Sistem sering freeze/hang tanpa sebab jelas'],
            ['kode_gejala' => 'G31', 'nama_gejala' => 'Muncul pesan error "Operating System Not Found"'],
            ['kode_gejala' => 'G32', 'nama_gejala' => 'Proses booting Windows sangat lama lalu gagal masuk'],
            ['kode_gejala' => 'G33', 'nama_gejala' => 'Muncul banyak iklan pop-up saat browsing atau bahkan saat offline'],
            ['kode_gejala' => 'G34', 'nama_gejala' => 'File tiba-tiba hilang, terenkripsi, atau berubah ekstensi'],
            ['kode_gejala' => 'G35', 'nama_gejala' => 'Antivirus mendeteksi ancaman berulang kali'],
            ['kode_gejala' => 'G36', 'nama_gejala' => 'Perangkat seperti WiFi/Bluetooth/printer tidak terdeteksi sistem'],
            ['kode_gejala' => 'G37', 'nama_gejala' => 'Muncul tanda seru kuning pada Device Manager'],
            ['kode_gejala' => 'G38', 'nama_gejala' => 'Notifikasi penyimpanan hampir penuh terus muncul'],
            ['kode_gejala' => 'G39', 'nama_gejala' => 'Proses install/copy file berjalan sangat lambat'],
            ['kode_gejala' => 'G40', 'nama_gejala' => 'Windows Update gagal terus-menerus dengan kode error'],
            ['kode_gejala' => 'G41', 'nama_gejala' => 'Aplikasi tertentu sering "Not Responding" atau force close'],
            ['kode_gejala' => 'G42', 'nama_gejala' => 'RAM usage di Task Manager selalu di atas 90% saat idle'],
            ['kode_gejala' => 'G43', 'nama_gejala' => 'Touchpad tidak merespons sentuhan sama sekali'],
            ['kode_gejala' => 'G44', 'nama_gejala' => 'Kursor bergerak sendiri tanpa disentuh (touchpad ghosting/drift)'],
            ['kode_gejala' => 'G45', 'nama_gejala' => 'Webcam tidak terdeteksi atau gambar tidak muncul saat video call'],
            ['kode_gejala' => 'G46', 'nama_gejala' => 'Fingerprint sensor gagal mengenali sidik jari berulang kali'],
            ['kode_gejala' => 'G47', 'nama_gejala' => 'Windows Hello (face recognition) gagal login meski wajah sudah terdaftar'],
            ['kode_gejala' => 'G48', 'nama_gejala' => 'Laptop tidak bisa masuk BIOS/UEFI sama sekali (tombol akses tidak merespons)'],
            ['kode_gejala' => 'G49', 'nama_gejala' => 'Muncul pesan "Secure Boot Violation" / "Secure Boot state corrupted" saat booting'],
            ['kode_gejala' => 'G50', 'nama_gejala' => 'Muncul pesan "TPM device not detected/not found"'],
            ['kode_gejala' => 'G51', 'nama_gejala' => 'BitLocker terus meminta recovery key setiap booting tanpa ada perubahan hardware'],
            ['kode_gejala' => 'G52', 'nama_gejala' => 'Port USB-C/Thunderbolt tidak transfer data maupun charging sama sekali'],
            ['kode_gejala' => 'G53', 'nama_gejala' => 'Laptop tidak bisa charging lewat port USB-C tertentu meski charger lain normal'],
            ['kode_gejala' => 'G54', 'nama_gejala' => 'Koneksi WiFi sering putus-nyambung meski indikator sinyal penuh'],
            ['kode_gejala' => 'G55', 'nama_gejala' => 'Bluetooth tidak bisa mendeteksi atau pairing perangkat apa pun'],
            ['kode_gejala' => 'G56', 'nama_gejala' => 'Muncul bunyi dengung bernada tinggi (coil whine) dari dalam bodi saat beban tinggi'],
            ['kode_gejala' => 'G57', 'nama_gejala' => 'Muncul bayangan gambar menetap di layar (burn-in), umumnya pada panel OLED'],
            ['kode_gejala' => 'G58', 'nama_gejala' => 'Refresh rate layar turun sendiri dari spek normal (mis. dari 120Hz/144Hz ke 60Hz)'],
            ['kode_gejala' => 'G59', 'nama_gejala' => 'Fitur AI/Copilot+ (Recall, Windows Studio Effects, dll) error "NPU not detected"'],
            ['kode_gejala' => 'G60', 'nama_gejala' => 'Sistem freeze khusus saat menjalankan aplikasi AI lokal/GPU-intensive (LLM lokal, image generation)'],
            ['kode_gejala' => 'G61', 'nama_gejala' => 'Laptop bootloop (restart terus-menerus) setelah update Windows besar (24H2/25H2/26H2)'],
            ['kode_gejala' => 'G62', 'nama_gejala' => 'Muncul BSOD dengan kode "INACCESSIBLE_BOOT_DEVICE" setelah update besar'],
            ['kode_gejala' => 'G63', 'nama_gejala' => 'Fast charging tidak berfungsi, waktu ngecas jadi jauh lebih lama dari biasanya'],
            ['kode_gejala' => 'G64', 'nama_gejala' => 'Baterai health turun drastis (di bawah 50%) dalam waktu kurang dari 1 tahun pemakaian'],
            ['kode_gejala' => 'G65', 'nama_gejala' => 'SSD NVMe terdeteksi di BIOS tapi hilang/tidak terbaca di File Explorer Windows'],
            ['kode_gejala' => 'G66', 'nama_gejala' => 'Suhu SSD NVMe sangat tinggi (>70°C) disertai penurunan kecepatan baca/tulis drastis'],
        ];

        $frequentCodes = ['G01', 'G02', 'G03', 'G09', 'G10', 'G13', 'G15', 'G16', 'G21', 'G30', 'G54', 'G61'];

        foreach ($gejalas as $gejala) {
            $gejala['is_frequent'] = in_array($gejala['kode_gejala'], $frequentCodes);
            Gejala::updateOrCreate(['kode_gejala' => $gejala['kode_gejala']], $gejala);
        }
    }
}
