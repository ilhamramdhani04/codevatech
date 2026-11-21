# Deployment Hostinger melalui GitHub Actions

Workflow `.github/workflows/hostinger.yml` menjalankan semua test Laravel dan build Vite di runner GitHub. Setelah lolos, source yang tercatat di Git, dependency PHP production, dan hasil build dikemas menjadi release. SSH mengirim paket tersebut ke Hostinger dan mengaktifkannya melalui symlink `current`.

Node.js dan Git tidak diperlukan di server untuk alur ini. PHP CLI 8.2+, ekstensi PHP yang sesuai, Bash, tar, realpath, flock, serta symlink diperlukan. Versi PHP web dan CLI harus kompatibel dengan dependency pada `composer.lock`.

## Pengaturan GitHub

Deployment hanya berjalan untuk branch `main` ketika repository variable `HOSTINGER_DEPLOY_ENABLED` bernilai `true`. Pull request hanya menjalankan test dan build. Menambahkan secret saja tidak mengaktifkan deployment.

Buat environment `production`, lalu isi secret berikut pada environment tersebut:

| Secret | Isi |
| --- | --- |
| `HOSTINGER_SSH_HOST` | IP atau hostname SSH dari hPanel |
| `HOSTINGER_SSH_USER` | Username SSH hosting |
| `HOSTINGER_SSH_PORT` | Port dari hPanel, biasanya `65002` |
| `HOSTINGER_SSH_PRIVATE_KEY` | Private key khusus deployment; public key pasang di Hostinger |
| `HOSTINGER_SSH_KNOWN_HOSTS` | Entri known_hosts dengan host key yang sudah diverifikasi |

Repository variables:

| Variable | Isi |
| --- | --- |
| `HOSTINGER_DEPLOY_ENABLED` | `false` saat persiapan; `true` setelah server dan domain siap |
| `HOSTINGER_DEPLOY_ROOT` | Path absolut direktori deployment khusus aplikasi di dalam home akun hosting |
| `HOSTINGER_PHP_BIN` | Opsional, executable PHP CLI; default `php` |
| `HOSTINGER_APP_URL` | URL HTTPS domain/subdomain production, misalnya `https://codevatech.example.com` |

Untuk port selain 22, entri known_hosts memakai format `[host]:port`. Cocokkan fingerprint dengan hPanel atau koneksi yang sudah dipercaya. Workflow menggunakan `StrictHostKeyChecking=yes`.

## Struktur direktori server

Contoh berikut memakai `/home/u123456789/apps/codevatech` sebagai direktori aplikasi, terpisah dari website lain:

```text
/home/u123456789/apps/codevatech/
  .codevatech-deploy-root
  shared/
    .env
    storage/
  releases/
    <commit>-<run>-<attempt>/
  current -> releases/<release-yang-aktif>
```

Inisialisasi direktori khusus aplikasi setelah path sebenarnya diperiksa. Salin `.env` production yang sudah benar ke `shared/.env` dan siapkan direktori storage Laravel sebelum mengaktifkan workflow. Jangan menjalankan perintah contoh ini terhadap folder website aktif tanpa memeriksa susunannya terlebih dahulu.

```bash
deploy_root=/home/u123456789/apps/codevatech
mkdir -p "$deploy_root/releases"
mkdir -p "$deploy_root/shared/storage/app/private" "$deploy_root/shared/storage/app/public"
mkdir -p "$deploy_root/shared/storage/framework/cache/data"
mkdir -p "$deploy_root/shared/storage/framework/sessions"
mkdir -p "$deploy_root/shared/storage/framework/views" "$deploy_root/shared/storage/logs"
touch "$deploy_root/.codevatech-deploy-root"
chmod o+x "$(dirname "$deploy_root")" "$deploy_root" "$deploy_root/releases"
```

Jika ada aplikasi sebelumnya, pertahankan APP_KEY dan data storage yang masih digunakan. Script tidak mengganti APP_KEY atau mengunggah `.env` dari CI. Setelah `.env` dipasang, batasi izin bacanya ke akun hosting.

Domain/subdomain harus melayani **`current/public/`**. Sesuaikan document root atau symlink folder publik sesuai struktur hosting yang telah diperiksa. Source, `.env`, dan `shared/` harus berada di luar folder publik. Siapkan SSL dan gunakan URL HTTPS yang sama pada `APP_URL`.

## Database yang sudah diimpor

Isi `DB_CONNECTION=mysql`, host, nama database, username, dan password yang diberikan Hostinger pada `shared/.env`. Gunakan `APP_ENV=production`, `APP_DEBUG=false`, dan APP_KEY yang stabil. Untuk kebutuhan aplikasi saat ini, `QUEUE_CONNECTION=sync`, `SESSION_DRIVER=file`, dan `CACHE_STORE=file` dapat digunakan tanpa worker atau tabel infrastruktur tambahan. File session dan cache berada di storage bersama.

Script `scripts/hostinger-preflight.php` membaca koneksi dan struktur database untuk memastikan tabel aplikasi serta kolom `gejalas.is_frequent` tersedia. Jika session/cache menggunakan database, tabel terkait juga diperiksa. Error koneksi tidak dicetak lengkap ke log CI.

Deployment **tidak menjalankan migrasi, seeder, import database, atau reset data**. Pada database hasil impor, periksa `php artisan migrate:status` dan struktur aktual sebelum memutuskan migrasi apa yang diperlukan. Mengubah skema sebaiknya dilakukan setelah backup dan peninjauan terpisah. Jangan menjalankan `migrate:fresh` atau seeder akun demo pada database production.

## Aktivasi dan pemulihan

1. Pastikan public key terpasang, koneksi SSH berhasil, `.env` dan storage siap, database sesuai, serta document root benar.
2. Isi `HOSTINGER_DEPLOY_ROOT` dan aktifkan `HOSTINGER_DEPLOY_ENABLED=true`.
3. Jalankan workflow secara manual dari tab Actions atau push ke `main`.
4. Workflow mengirim release, memeriksa environment/database, membangun cache Laravel, lalu mengganti symlink `current` secara atomik. Deployment yang gagal sebelum aktivasi mempertahankan release lama.
5. Workflow memeriksa respons HTTP `/up`, halaman utama, halaman login, dan halaman diagnosis. Uji juga login, pengiriman diagnosis, riwayat, dan unduhan PDF pada domain sebenarnya. Pemeriksaan database awal dan status HTTP tidak menggantikan uji alur tersebut.

Release lama dipertahankan untuk pemulihan. Untuk kembali ke versi sebelumnya, arahkan ulang symlink `current` ke release yang sudah diperiksa. Pemulihan ini hanya mengganti kode; data database dan storage tetap dipakai bersama. Bersihkan release lama secara terpisah setelah menentukan jumlah versi yang perlu disimpan dan batas kapasitas hosting.

Gunakan satu pengendali deployment. Jika GitHub Actions dipakai untuk deployment ini, matikan auto-deploy hPanel pada target yang sama agar dua proses tidak memperbarui website bersamaan.

## Validasi script

```bash
php artisan test --compact
bash tests/Deployment/hostinger.sh
```

Test deployment dijalankan pada Linux runner GitHub dan menggunakan PHP stub serta direktori sementara. Test memeriksa pergantian release, kegagalan preflight yang tidak mengganti release aktif, pelestarian environment/storage, dan penolakan target yang belum diinisialisasi. Test tidak menghubungi database production.
