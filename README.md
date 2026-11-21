# CODEVA TECH — DiagnoLap

Aplikasi web layanan servis dan sistem pakar diagnosis kerusakan laptop menggunakan metode **Forward Chaining**. Project skripsi ini menyediakan halaman diagnosis untuk pengunjung serta portal admin dan teknisi untuk mengelola basis pengetahuan dan melihat hasil diagnosis.

## Fitur

- Landing page layanan servis laptop CODEVA TECH.
- Diagnosis berdasarkan gejala, dengan pilihan merek/model laptop atau informasi manual.
- Pencocokan aturan dengan kondisi gejala positif dan negasi, disertai hasil kerusakan, penyebab, dan solusi.
- Pengelolaan kategori, gejala, kerusakan, penyebab, solusi, dan aturan diagnosis oleh admin.
- Katalog merek dan model laptop.
- Portal teknisi untuk melihat basis pengetahuan dan riwayat diagnosis.
- Riwayat diagnosis dan unduh laporan PDF khusus teknisi.
- Dashboard, analisis kerusakan, pengelolaan pengguna, dan pencatatan aktivitas.
- Pembatasan akses berdasarkan peran admin/teknisi dan rate limiting untuk login serta diagnosis.

## Teknologi

| Bagian | Teknologi |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12 |
| Tampilan | Blade, CSS, JavaScript, SweetAlert2 |
| Tooling frontend | Vite 7, Tailwind CSS 4 |
| Database | SQLite untuk setup awal; konfigurasi MySQL tersedia |
| Laporan PDF | barryvdh/laravel-dompdf |
| Pengujian | PHPUnit 11 |

## Kebutuhan

- PHP 8.2 atau lebih baru beserta ekstensi yang diminta Composer, termasuk PDO SQLite untuk setup awal.
- Composer 2.
- Node.js 22.12+ dan npm untuk tooling frontend.
- Git.

Jika memakai XAMPP, pastikan PHP CLI mengarah ke versi yang sesuai dan ekstensi SQLite aktif. MySQL dari XAMPP bersifat opsional jika menggunakan konfigurasi SQLite bawaan.

## Instalasi lokal

### 1. Clone dan pasang dependency

```bash
git clone https://github.com/ilhamramdhani04/codevatech.git
cd codevatech
composer install
```

### 2. Siapkan environment

Salin file contoh jika `.env` belum dibuat oleh Composer.

PowerShell:

```powershell
Copy-Item .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

Lalu buat application key:

```bash
php artisan key:generate
```

### 3. Siapkan database dan data awal

Secara default, `.env.example` memakai SQLite. Buat file database kosong jika belum ada:

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
```

Seeder mengisi basis pengetahuan, katalog laptop, dan akun demo. Jalankan pada database lokal baru; seeder akun memakai `updateOrCreate` sehingga dapat mengatur ulang akun demo yang sudah ada.

Untuk memakai MySQL, buat database kosong terlebih dahulu, lalu sesuaikan bagian berikut di `.env` sebelum menjalankan migrasi:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=codevatech
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Build aset dan jalankan aplikasi

```bash
npm ci
npm run build
php artisan serve
```

Buka **http://127.0.0.1:8000**. Untuk mengerjakan aset frontend, jalankan `npm run dev` di terminal terpisah.

Jika menggunakan Apache/XAMPP, arahkan document root atau VirtualHost ke folder **`public/`**, aktifkan rewrite, dan sesuaikan `APP_URL`. Folder `storage/` dan `bootstrap/cache/` harus dapat ditulis oleh proses PHP.

## Akun demo lokal

Login melalui **`/admin/login`** untuk kedua peran.

| Peran | Email | Password | Portal |
| --- | --- | --- | --- |
| Admin | `admin@diagnolap.com` | `password123` | `/admin` |
| Teknisi | `teknisi@diagnolap.com` | `password123` | `/teknisi` |

Akun ini dibuat oleh seeder untuk pengembangan. Ganti password sebelum aplikasi digunakan di server publik dan hindari menjalankan seeder akun demo pada database production.

## Alur diagnosis

1. Pengunjung membuka `/diagnosis` dan memilih gejala yang dialami.
2. Sistem membandingkan pilihan tersebut dengan kondisi setiap aturan dalam basis pengetahuan.
3. Aturan cocok jika seluruh gejala positif dipilih dan seluruh gejala negasi tidak dipilih.
4. Sistem menampilkan kerusakan yang cocok beserta penyebab dan solusi, lalu menyimpan riwayat diagnosis.

Mesin inferensi berada di [`app/Services/ForwardChainingService.php`](app/Services/ForwardChainingService.php).

## Pengujian

```bash
php artisan test
```

Konfigurasi di `phpunit.xml` menggunakan SQLite `:memory:`. Pengujian mencakup login, otorisasi, pengelolaan pengguna/kategori, alur diagnosis, dan akses laporan PDF. Endpoint cetak serta ekspor CSV saat ini dinonaktifkan (HTTP 403).

Status verifikasi saat persiapan repository: build frontend berhasil; 17 test lolos dan 5 test gagal. Test yang gagal masih mengharapkan akses teknisi melalui `/admin`, fitur cetak/CSV yang dinonaktifkan, serta teks `DiagnoLap` pada halaman login yang kini memakai nama CODEVA TECH. Suite test perlu disesuaikan dengan perilaku tersebut.

## Struktur project

```text
app/
  Http/Controllers/    Controller halaman publik dan panel
  Http/Middleware/    Autentikasi, peran, dan header keamanan
  Models/             Model data
  Services/           Mesin inferensi Forward Chaining
database/
  migrations/         Struktur database
  seeders/            Basis pengetahuan, katalog, dan akun demo
public/               Entry point, gambar, dan aset statis
resources/            Blade, CSS, dan JavaScript
routes/web.php        Route publik, admin, dan teknisi
tests/                Pengujian unit dan fitur
```

Dokumentasi tambahan:

- [PRD](prd.md)
- [Basis pengetahuan](knowledge-base.md)
- [ERD](ERD.md)
- [Struktur database](struktur_db.md)
- [Analisis struktur database](hasil_analisis_struktur_db.md)
- [Skenario pengujian diagnosis](test-case-diagnosa.md)
- [Kebutuhan production](prod-requirement.md)

Dokumen kebutuhan dan rancangan dapat memuat rencana pengembangan. Perilaku aplikasi saat ini mengacu pada source code.

## Deployment

Siapkan `.env` khusus server dengan `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, application key, dan koneksi database yang sesuai. Web server harus mengarah ke `public/`.

Script [`deploy.sh`](deploy.sh) disediakan untuk pembaruan deployment Linux yang sudah disiapkan. Script menarik branch `main`, memasang dependency PHP, membangun cache, menjalankan migrasi, dan membangun aset jika npm tersedia. Backup database terlebih dahulu. Jika script berhenti saat maintenance, selesaikan error lalu jalankan `php artisan up`.

## File yang tidak diunggah

`.gitignore` mengecualikan environment rahasia (`.env` dan variannya), dependency (`vendor/`, `node_modules/`), database lokal/dump SQL, file unggahan, log, session, cache, hasil build, dan konfigurasi editor lokal.

`.env.example`, `composer.lock`, `package-lock.json`, migrasi, seeder, source code, gambar/aset statis, dan placeholder direktori Laravel tetap disertakan agar project dapat dipasang ulang setelah clone. Data lokal dan riwayat diagnosis tidak ikut diunggah.
