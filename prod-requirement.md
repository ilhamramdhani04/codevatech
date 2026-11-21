# Laravel Production Requirements

## Functional

### Authentication & Authorization
- Login/logout, secure password hashing (bcrypt/argon2 bawaan Laravel).
- Session regeneration setelah login (`regenerate()`) untuk cegah session fixation.
- **Password policy**: minimum length + kompleksitas, lockout/throttle setelah N kali gagal login.
- Role/permission + middleware/policy untuk semua protected action.
- **Mass assignment protection**: eksplisit `$fillable`/`$guarded` di setiap model — jangan andalkan validasi input saja.
- **IDOR prevention**: setiap route model binding tetap wajib dicek ownership/authorization (`Gate`/`Policy`), bukan cuma percaya ID dari URL.
- Pertimbangkan **2FA** untuk akun admin/role sensitif.

### Validation
- Semua input wajib divalidasi server-side (Form Request untuk validasi kompleks).

### CRUD
- Authorization check pada setiap operasi (create/read/update/delete).
- Confirmation sebelum delete.
- **Soft delete** untuk data penting, supaya recoverable dari kesalahan klik.
- **Idempotency** untuk operasi kritis (cegah double submit dari retry/double-click).

### File Upload
- Validasi MIME type, extension, dan size di server-side (jangan percaya ekstensi dari client).
- Simpan via Laravel Storage, **di luar public webroot** atau pakai signed/temporary URL.
- Randomize nama file saat disimpan, disable script execution di folder upload.
- Upload size limit selaras antara `php.ini`/webserver dan validasi Laravel.

### Rate Limiting
- Login, API, upload, dan endpoint publik berisiko lainnya.

### Error Handling
- Tampilkan pesan aman ke user, detail error hanya di log.
- **Custom error page** untuk 404/500/503 — jangan tampilkan default Laravel/stack trace.

### Database
- Migration, foreign key, index, transaction untuk operasi penting.
- Hindari N+1 query (eager loading).

### Cache
- Cache hanya data yang sering dibaca dan jarang berubah.

### Backup
- Database production wajib backup berkala.
- **Backup restoration test** dilakukan berkala — backup yang belum pernah dicoba restore belum terbukti valid.

### Queue
- Gunakan queue untuk proses berat.
- **Failed job handling**: tabel `failed_jobs` + mekanisme retry/alerting, jangan biarkan job gagal secara diam-diam.

---

## Non-Functional

### Security
- HTTPS wajib di production.
- CSRF protection.
- XSS protection.
- SQL Injection protection melalui Eloquent/Query Builder.
- Secure session + cookie HTTP-only/Secure.
- **Session driver production**: gunakan `database` atau `redis`, bukan `file`, terutama jika multi-server.
- Security headers spesifik: **CSP, HSTS, X-Frame-Options, X-Content-Type-Options**.
- **CORS config eksplisit** (`config/cors.php`) — penting untuk setup Laravel API + React frontend, jangan biarkan default terbuka.
- **Sanctum/Passport**: token scope dan expiration diatur eksplisit.
- Jangan expose `.env`, credential, token, atau stack trace.
- **Secrets management**: `.env` tidak pernah di-commit ke repo, `.gitignore` benar, `APP_KEY` dijaga (kehilangan/rotasi sembarangan bisa merusak data terenkripsi tersimpan).
- **Nonaktifkan/proteksi debug tools** di production (Telescope, Horizon dashboard, Debugbar) — auth-gate atau disable total.
- `APP_DEBUG=false` di production.
- **Dependency vulnerability scan**: `composer audit` dan `npm audit` sebelum deploy.
- **UU PDP (Pelindungan Data Pribadi)**: karena aplikasi menyimpan data user (teknisi, data laptop pelanggan), minimal ada privacy notice + mekanisme user request hapus data.
- **Log hygiene**: jangan log data sensitif (password, token, session ID) di log aktivitas/error.

### Performance
- Optimalkan query, gunakan eager loading.
- Gunakan database index.
- Pagination untuk data besar.
- Optimalkan image dan frontend assets.
- Gunakan Laravel production cache/optimization (`config:cache`, `route:cache`, `view:cache`).
- **Opcache aktif** di PHP production.
- **HTTP cache headers** (Cache-Control/ETag) untuk asset statis.
- Gunakan queue untuk proses berat jika diperlukan.

### Maintainability
- Business logic kompleks berada di Service, bukan Controller.
- Gunakan Form Request untuk validasi kompleks.
- Gunakan Policy/Middleware untuk authorization.
- Hindari duplicate code dan hardcoded credential.
- **Static analysis**: Laravel Pint (code style) + PHPStan/Larastan (type safety).
- **Automated test** minimal mencakup: auth flow, CRUD critical path, authorization check — bukan sekadar "ada test".

### Reliability
- Logging untuk error dan aktivitas penting.
- **Audit trail** untuk aksi sensitif (siapa hapus/ubah data apa, kapan).
- Backup database + restoration test berkala.
- Transaction untuk operasi database penting.
- Migration harus reproducible; **commit `composer.lock` dan `package-lock.json`** untuk build yang konsisten.
- **Health check endpoint** `/up` (built-in Laravel 11+) untuk uptime monitoring dasar.
- **Queue worker process manager** (Supervisor/systemd) agar worker auto-restart jika crash.
- **Maintenance mode** (`php artisan down`/`up`) saat migration besar berjalan, untuk cegah request masuk ke state tanggung.
- Timezone & locale config disesuaikan (Asia/Jakarta, id).
- Production deployment harus build asset dan refresh cache yang diperlukan.

---

## Deployment Checklist (urutan eksplisit)

1. `composer install --no-dev --optimize-autoloader`
2. `php artisan down` (jika migration berdampak besar)
3. `php artisan migrate --force`
4. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
5. `npm run build`
6. `php artisan queue:restart` (worker pakai kode baru)
7. `php artisan up`

---

## Priority

**P0 — Wajib**
Security, authentication, authorization, validation, rate limiting, secure session, file upload security, HTTPS, backup + restoration test, logging, database optimization, `APP_DEBUG=false`, mass assignment protection, deployment checklist urutan cache/migrate/build, secrets management (`.env` tidak ter-commit).

**P1 — Penting**
Caching, image optimization, pagination, queue, security headers, automated test, health check `/up`, static analysis (Pint/Larastan), CORS config, dependency vulnerability scan.

**P2 — Optional**
Redis, CDN, advanced monitoring (Sentry/APM), load balancing, 2FA, file scanning antivirus.

> Gunakan solusi Laravel native terlebih dahulu. Jangan menambahkan teknologi/infrastruktur yang tidak diperlukan.