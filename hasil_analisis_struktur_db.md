# Analisis Basis Data, ERD, LRS, dan Class Diagram Diagnolap

Tanggal analisis: 22 Oktober 2026. Sumber utama: kode aktual proyek Laravel.

Analisis dilakukan secara statis: tidak menjalankan aplikasi, migration, seeder, atau query database. Struktur di bawah adalah hasil penggabungan seluruh migration `up()`, bukan konfirmasi skema database yang sedang terpasang. Hanya dokumen hasil ini yang dibuat; source code dan file instruksi tidak diubah.

## 1. Daftar Tabel

| No. | Tabel | Fungsi |
|---|---|---|
| 1 | `users` | Akun admin dan teknisi |
| 2 | `kategoris` | Kategori kerusakan |
| 3 | `brands` | Merek laptop |
| 4 | `laptop_models` | Katalog model laptop |
| 5 | `gejalas` | Master gejala |
| 6 | `kerusakans` | Master kerusakan |
| 7 | `penyebabs` | Penyebab kerusakan |
| 8 | `solusis` | Langkah solusi |
| 9 | `rules` | Aturan inferensi |
| 10 | `rule_gejala` | Kondisi aturan dan negasi |
| 11 | `diagnosis_histories` | Transaksi/riwayat konsultasi |
| 12 | `diagnosis_gejala` | Gejala yang dipilih saat diagnosis |
| 13 | `diagnosis_results` | Kerusakan hasil diagnosis |
| 14 | `activity_logs` | Audit aktivitas admin |

Terdapat **14 tabel domain/pendukung domain**, **14 model**, dan **15 foreign key database**. Semua tabel tersebut direferensikan oleh model dan alur controller/service/trait. `activity_logs` digunakan langsung oleh `LogsActivity`, sehingga tetap dimasukkan.

Tabel penghubung: `rule_gejala` (Rule-Gejala, membawa `is_negated`), `diagnosis_gejala` (DiagnosisHistory-Gejala), dan `diagnosis_results` (DiagnosisHistory-Kerusakan; juga entitas hasil diagnosis). Ketiganya menggunakan PK `id`, bukan PK gabungan.

Tabel bawaan `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`, dan `password_reset_tokens` tidak dimasukkan ke rancangan domain. Konfigurasi lokal yang dibaca terbatas pada driver: `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync`. Session dipakai alur diagnosis/login, tetapi itu tidak membuktikan penggunaan tabel `sessions`; default konfigurasi database dapat berbeda saat deployment. Tidak ditemukan alur reset password dalam route yang diperiksa.

Pemetaan istilah: Category = `Kategori`, Symptom = `Gejala`, Diagnosis/Kerusakan = `Kerusakan`, Solution = `Solusi`, Consultation = `DiagnosisHistory`. Tidak ditemukan tabel `consultations`, `categories`, `symptoms`, `diagnoses`, atau `solutions` pada migration.

## 2. Struktur Setiap Tabel

Notasi: semua `id` adalah PK auto increment, sehingga juga unik. `-` berarti tidak ada constraint PK/FK/unique pada kolom tersebut. Nilai default "Tidak dideklarasikan" tidak berarti string kosong atau angka nol. `created_at`/`updated_at` dari `timestamps()` nullable; diisi otomatis Eloquent, bukan default `CURRENT_TIMESTAMP`. Tipe merupakan pemetaan deklarasi migration (terutama untuk MySQL); tipe fisik dapat berbeda menurut driver.

### `users`

Sumber awal: [0001_01_01_000000_create_users_table.php](database/migrations/0001_01_01_000000_create_users_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| name | VARCHAR(100) | Tidak | - | Tidak dideklarasikan |
| email | VARCHAR(100) | Tidak | UNIQUE | Tidak dideklarasikan |
| email_verified_at | TIMESTAMP | Ya | - | NULL |
| password | VARCHAR(255) | Tidak | - | Tidak dideklarasikan |
| role | VARCHAR(20) | Tidak | - | 'teknisi' |
| remember_token | VARCHAR(100) | Ya | - | NULL |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

Migration `2024_01_01_000016_update_role_column_in_users_table.php` mengganti `role` dari enum admin menjadi VARCHAR(20), default teknisi. Batas nilai admin/teknisi adalah validasi aplikasi, bukan enum database final.

### `kategoris`

Sumber awal: [2024_01_01_000001_create_kategoris_table.php](database/migrations/2024_01_01_000001_create_kategoris_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| nama_kategori | VARCHAR(50) | Tidak | - | Tidak dideklarasikan |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

`nama_kategori` divalidasi unique oleh controller, tetapi **tidak memiliki unique constraint** di migration.

### `brands`

Sumber awal: [2024_01_01_000011_create_brands_table.php](database/migrations/2024_01_01_000011_create_brands_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| nama_brand | VARCHAR(50) | Tidak | UNIQUE | Tidak dideklarasikan |
| logo_url | VARCHAR(255) | Ya | - | NULL |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

### `laptop_models`

Sumber awal: [2024_01_01_000012_create_laptop_models_table.php](database/migrations/2024_01_01_000012_create_laptop_models_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| brand_id | BIGINT UNSIGNED | Tidak | FK -> brands.id | Tidak dideklarasikan |
| nama_model | VARCHAR(100) | Tidak | - | Tidak dideklarasikan |
| seri | VARCHAR(100) | Ya | - | NULL |
| kategori_laptop | ENUM(gaming, business, ultrabook, workstation, mainstream) | Tidak | - | 'mainstream' |
| tahun_rilis | YEAR | Ya | - | NULL |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

Unique gabungan: `(brand_id, nama_model, seri)`. Tidak berarti setiap kolom unik sendiri. Karena `seri` nullable, perilaku beberapa baris bernilai NULL bergantung DBMS; pada MySQL unique tidak menjamin hanya satu kombinasi dengan `seri = NULL`.

### `gejalas`

Sumber awal: [2024_01_01_000002_create_gejalas_table.php](database/migrations/2024_01_01_000002_create_gejalas_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| kode_gejala | VARCHAR(10) | Tidak | UNIQUE | Tidak dideklarasikan |
| nama_gejala | TEXT | Tidak | - | Tidak dideklarasikan |
| is_frequent | BOOLEAN | Tidak | - | false |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |
| deleted_at | TIMESTAMP | Ya | - | NULL |

`deleted_at` ditambahkan oleh `2024_01_01_000014_add_soft_deletes_to_tables.php`; model memakai `SoftDeletes`.

`is_frequent` ditambahkan oleh `2026_08_06_051905_add_is_frequent_to_gejalas_table.php`.

### `kerusakans`

Sumber awal: [2024_01_01_000003_create_kerusakans_table.php](database/migrations/2024_01_01_000003_create_kerusakans_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| kategori_id | BIGINT UNSIGNED | Tidak | FK -> kategoris.id | Tidak dideklarasikan |
| kode_kerusakan | VARCHAR(10) | Tidak | UNIQUE | Tidak dideklarasikan |
| nama_kerusakan | VARCHAR(150) | Tidak | - | Tidak dideklarasikan |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |
| deleted_at | TIMESTAMP | Ya | - | NULL |

`deleted_at` ditambahkan oleh `2024_01_01_000014_add_soft_deletes_to_tables.php`; model memakai `SoftDeletes`.

### `penyebabs`

Sumber awal: [2024_01_01_000004_create_penyebabs_table.php](database/migrations/2024_01_01_000004_create_penyebabs_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| kerusakan_id | BIGINT UNSIGNED | Tidak | FK -> kerusakans.id | Tidak dideklarasikan |
| deskripsi | TEXT | Tidak | - | Tidak dideklarasikan |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

### `solusis`

Sumber awal: [2024_01_01_000005_create_solusis_table.php](database/migrations/2024_01_01_000005_create_solusis_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| kerusakan_id | BIGINT UNSIGNED | Tidak | FK -> kerusakans.id | Tidak dideklarasikan |
| deskripsi | TEXT | Tidak | - | Tidak dideklarasikan |
| urutan | TINYINT (signed) | Tidak | - | 1 |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

### `rules`

Sumber awal: [2024_01_01_000006_create_rules_table.php](database/migrations/2024_01_01_000006_create_rules_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| kerusakan_id | BIGINT UNSIGNED | Tidak | FK -> kerusakans.id | Tidak dideklarasikan |
| kode_rule | VARCHAR(10) | Tidak | UNIQUE | Tidak dideklarasikan |
| keterangan | TEXT | Ya | - | NULL |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |
| deleted_at | TIMESTAMP | Ya | - | NULL |

`deleted_at` ditambahkan oleh `2024_01_01_000014_add_soft_deletes_to_tables.php`; model memakai `SoftDeletes`.

### `rule_gejala`

Sumber awal: [2024_01_01_000007_create_rule_gejala_table.php](database/migrations/2024_01_01_000007_create_rule_gejala_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| rule_id | BIGINT UNSIGNED | Tidak | FK -> rules.id | Tidak dideklarasikan |
| gejala_id | BIGINT UNSIGNED | Tidak | FK -> gejalas.id | Tidak dideklarasikan |
| is_negated | BOOLEAN | Tidak | - | false |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

Tidak ada unique constraint untuk pasangan FK; duplikasi pasangan tidak dicegah oleh skema migration.

### `diagnosis_histories`

Sumber awal: [2024_01_01_000008_create_diagnosis_histories_table.php](database/migrations/2024_01_01_000008_create_diagnosis_histories_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| user_id | BIGINT UNSIGNED | Ya | FK -> users.id | NULL |
| nama_pengguna | VARCHAR(100) | Ya | - | NULL |
| brand_id | BIGINT UNSIGNED | Ya | FK -> brands.id | NULL |
| laptop_model_id | BIGINT UNSIGNED | Ya | FK -> laptop_models.id | NULL |
| laptop_info_manual | VARCHAR(150) | Ya | - | NULL |
| tanggal_diagnosis | TIMESTAMP | Tidak | - | Tidak dideklarasikan |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |
| deleted_at | TIMESTAMP | Ya | - | NULL |

`deleted_at` ditambahkan oleh `2024_01_01_000014_add_soft_deletes_to_tables.php`; model memakai `SoftDeletes`.

Kolom `brand_id`, `laptop_model_id`, dan `laptop_info_manual` berasal dari migration `2024_01_01_000013_add_laptop_info_to_diagnosis_histories.php`.

### `diagnosis_gejala`

Sumber awal: [2024_01_01_000009_create_diagnosis_gejala_table.php](database/migrations/2024_01_01_000009_create_diagnosis_gejala_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| diagnosis_history_id | BIGINT UNSIGNED | Tidak | FK -> diagnosis_histories.id | Tidak dideklarasikan |
| gejala_id | BIGINT UNSIGNED | Tidak | FK -> gejalas.id | Tidak dideklarasikan |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

Tidak ada unique constraint untuk pasangan FK; duplikasi pasangan tidak dicegah oleh skema migration.

### `diagnosis_results`

Sumber awal: [2024_01_01_000010_create_diagnosis_results_table.php](database/migrations/2024_01_01_000010_create_diagnosis_results_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| diagnosis_history_id | BIGINT UNSIGNED | Tidak | FK -> diagnosis_histories.id | Tidak dideklarasikan |
| kerusakan_id | BIGINT UNSIGNED | Tidak | FK -> kerusakans.id | Tidak dideklarasikan |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

Tidak ada unique constraint untuk pasangan FK; duplikasi pasangan tidak dicegah oleh skema migration.

### `activity_logs`

Sumber awal: [2024_01_01_000015_create_activity_logs_table.php](database/migrations/2024_01_01_000015_create_activity_logs_table.php).

| Kolom | Tipe | Nullable | PK / FK / Unique | Default |
|---|---|---|---|---|
| id | BIGINT UNSIGNED | Tidak | PK, auto increment | Tidak dideklarasikan |
| user_id | BIGINT UNSIGNED | Ya | FK -> users.id | NULL |
| action | VARCHAR(20) | Tidak | - | Tidak dideklarasikan |
| model_type | VARCHAR(100) | Tidak | - | Tidak dideklarasikan |
| model_id | BIGINT UNSIGNED | Ya | - | NULL |
| description | VARCHAR(255) | Tidak | - | Tidak dideklarasikan |
| ip_address | ipAddress (VARCHAR(45) pada MySQL) | Ya | - | NULL |
| changes | JSON | Ya | - | NULL |
| created_at | TIMESTAMP | Ya | - | NULL |
| updated_at | TIMESTAMP | Ya | - | NULL |

Index non-unique: `(model_type, model_id)`, `user_id`, dan `created_at`. `model_id` bukan FK database.

## 3. Daftar Foreign Key

| Tabel anak | Kolom FK | Referensi | Nullable | ON DELETE |
|---|---|---|---|---|
| `kerusakans` | `kategori_id` | `kategoris.id` | Tidak | CASCADE |
| `penyebabs` | `kerusakan_id` | `kerusakans.id` | Tidak | CASCADE |
| `solusis` | `kerusakan_id` | `kerusakans.id` | Tidak | CASCADE |
| `rules` | `kerusakan_id` | `kerusakans.id` | Tidak | CASCADE |
| `rule_gejala` | `rule_id` | `rules.id` | Tidak | CASCADE |
| `rule_gejala` | `gejala_id` | `gejalas.id` | Tidak | CASCADE |
| `diagnosis_histories` | `user_id` | `users.id` | Ya | SET NULL |
| `diagnosis_gejala` | `diagnosis_history_id` | `diagnosis_histories.id` | Tidak | CASCADE |
| `diagnosis_gejala` | `gejala_id` | `gejalas.id` | Tidak | CASCADE |
| `diagnosis_results` | `diagnosis_history_id` | `diagnosis_histories.id` | Tidak | CASCADE |
| `diagnosis_results` | `kerusakan_id` | `kerusakans.id` | Tidak | CASCADE |
| `laptop_models` | `brand_id` | `brands.id` | Tidak | CASCADE |
| `activity_logs` | `user_id` | `users.id` | Ya | SET NULL |
| `diagnosis_histories` | `brand_id` | `brands.id` | Ya | SET NULL |
| `diagnosis_histories` | `laptop_model_id` | `laptop_models.id` | Ya | SET NULL |

Tidak ada `cascadeOnUpdate()` yang dideklarasikan. `sessions.user_id` hanya `foreignId()->nullable()->index()` tanpa `constrained()`, sehingga bukan FK database. `activity_logs.model_type + model_id` adalah penunjuk target audit pada level aplikasi; tidak ada FK dan tidak ada method `morphTo()` pada model.

## 4. Relasi Antar Tabel + Kardinalitas

Kardinalitas mengikuti constraint skema: satu induk boleh memiliki **0..N** anak. FK wajib berarti setiap anak merujuk tepat satu induk; FK nullable berarti setiap anak merujuk **0..1** induk. Validasi form dapat mewajibkan detail tertentu tanpa membuat minimum satu anak pada skema.

| Relasi induk 1:N anak | FK pembentuk | Induk per anak |
|---|---|---|
| `kategoris` 1:N `kerusakans` | `kerusakans.kategori_id -> kategoris.id` | 1 |
| `kerusakans` 1:N `penyebabs` | `penyebabs.kerusakan_id -> kerusakans.id` | 1 |
| `kerusakans` 1:N `solusis` | `solusis.kerusakan_id -> kerusakans.id` | 1 |
| `kerusakans` 1:N `rules` | `rules.kerusakan_id -> kerusakans.id` | 1 |
| `rules` 1:N `rule_gejala` | `rule_gejala.rule_id -> rules.id` | 1 |
| `gejalas` 1:N `rule_gejala` | `rule_gejala.gejala_id -> gejalas.id` | 1 |
| `users` 1:N `diagnosis_histories` | `diagnosis_histories.user_id -> users.id` | 0..1 |
| `diagnosis_histories` 1:N `diagnosis_gejala` | `diagnosis_gejala.diagnosis_history_id -> diagnosis_histories.id` | 1 |
| `gejalas` 1:N `diagnosis_gejala` | `diagnosis_gejala.gejala_id -> gejalas.id` | 1 |
| `diagnosis_histories` 1:N `diagnosis_results` | `diagnosis_results.diagnosis_history_id -> diagnosis_histories.id` | 1 |
| `kerusakans` 1:N `diagnosis_results` | `diagnosis_results.kerusakan_id -> kerusakans.id` | 1 |
| `brands` 1:N `laptop_models` | `laptop_models.brand_id -> brands.id` | 1 |
| `users` 1:N `activity_logs` | `activity_logs.user_id -> users.id` | 0..1 |
| `brands` 1:N `diagnosis_histories` | `diagnosis_histories.brand_id -> brands.id` | 0..1 |
| `laptop_models` 1:N `diagnosis_histories` | `diagnosis_histories.laptop_model_id -> laptop_models.id` | 0..1 |

Relasi konseptual M:N yang sudah dipecah:

- `rules` M:N `gejalas` melalui `rule_gejala`.
- `diagnosis_histories` M:N `gejalas` melalui `diagnosis_gejala`.
- `diagnosis_histories` M:N `kerusakans` melalui `diagnosis_results`.

Tidak ada relasi 1:1 yang dipaksakan FK unique. Satu diagnosis boleh menghasilkan nol atau beberapa kerusakan. `nama_pengguna` untuk guest adalah atribut history, bukan FK atau entitas akun tambahan.

### Array, JSON, dan referensi non-FK

- `DiagnosisController::process()` menerima `gejala_ids[]`; `ForwardChainingService::diagnoseAndSave()` menyimpannya sebagai baris `diagnosis_gejala`, **bukan kolom JSON**.
- `RuleController::store()/update()` menerima `gejala_ids[]` dan `is_negated[]` berupa ID gejala; data disimpan sebagai baris `rule_gejala` dengan boolean `is_negated`.
- `DiagnosisController::index()` membentuk `modelsByBrand`, yaitu struktur tampilan berisi ID brand dan model; bukan tabel/kolom persistensi baru.
- Session menyimpan `diagnosis_history_id`; ini referensi aplikasi, tanpa FK database. Pada konfigurasi lokal session disimpan ke file.
- `activity_logs.changes` merupakan JSON yang di-cast array. Pemanggilan audit dapat menyimpan `before`/`after`, termasuk atribut seperti `kategori_id`. ID di dalam snapshot JSON tidak memiliki constraint FK dan bukan relasi permanen tambahan.
- `activity_logs.model_type` diisi `get_class($model)` dan `model_id` diisi `getKey()` oleh trait. Gambarkan sebagai ketergantungan audit atau catatan, bukan FK ke seluruh tabel model.
- Tidak ada FK gabungan yang memastikan `diagnosis_histories.brand_id` sama dengan brand milik `laptop_model_id`. `DiagnosisController` memvalidasi keberadaan masing-masing ID secara terpisah.

Soft delete hanya memperbarui `deleted_at`; tidak menjalankan ON DELETE CASCADE/SET NULL. Komentar `ruleGejala cascade` pada `RuleController::destroy()` tidak mengubah fakta bahwa `Rule` memakai soft delete. Relasi Eloquent ke parent yang soft-deleted dapat tampak kosong walaupun FK fisiknya masih valid.

## 5. Daftar Model dan Relasinya

Seluruh model domain menggunakan `Illuminate\Database\Eloquent\Model`, kecuali `User` yang extends `Authenticatable`. Atribut database bersifat dinamis melalui Eloquent; atribut tersebut bukan deklarasi properti PHP satu per satu. Tidak ditemukan relasi `hasOne()` atau `morphTo()`. Salinan deklarasi dan method relasi di bawah diambil langsung dari file model.

### `ActivityLog` -> `activity_logs`

Sumber: [ActivityLog.php](app/Models/ActivityLog.php).

```php
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'ip_address',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];
```

Method relasi asli:

```php
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
```

Method lain: `scopeForModel()`, `scopeByUser()`.

### `Brand` -> `brands`

Sumber: [Brand.php](app/Models/Brand.php).

```php
    protected $table = 'brands';

    protected $fillable = ['nama_brand', 'logo_url'];
```

Method relasi asli:

```php
    public function laptopModels(): HasMany
    {
        return $this->hasMany(LaptopModel::class, 'brand_id');
    }

    public function diagnosisHistories(): HasMany
    {
        return $this->hasMany(DiagnosisHistory::class, 'brand_id');
    }
```

### `DiagnosisGejala` -> `diagnosis_gejala`

Sumber: [DiagnosisGejala.php](app/Models/DiagnosisGejala.php).

```php
    protected $table = 'diagnosis_gejala';

    protected $fillable = ['diagnosis_history_id', 'gejala_id'];
```

Method relasi asli:

```php
    public function diagnosisHistory(): BelongsTo
    {
        return $this->belongsTo(DiagnosisHistory::class, 'diagnosis_history_id');
    }

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }
```

### `DiagnosisHistory` -> `diagnosis_histories`

Sumber: [DiagnosisHistory.php](app/Models/DiagnosisHistory.php).

```php
    protected $table = 'diagnosis_histories';

    protected $fillable = [
        'user_id', 'nama_pengguna', 'tanggal_diagnosis',
        'brand_id', 'laptop_model_id', 'laptop_info_manual',
    ];

    protected $casts = [
        'tanggal_diagnosis' => 'datetime',
    ];
```

Method relasi asli:

```php
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function laptopModel(): BelongsTo
    {
        return $this->belongsTo(LaptopModel::class, 'laptop_model_id');
    }

    public function diagnosisGejala(): HasMany
    {
        return $this->hasMany(DiagnosisGejala::class, 'diagnosis_history_id');
    }

    public function diagnosisResults(): HasMany
    {
        return $this->hasMany(DiagnosisResult::class, 'diagnosis_history_id');
    }

    public function gejalas()
    {
        return $this->hasManyThrough(
            Gejala::class,
            DiagnosisGejala::class,
            'diagnosis_history_id',
            'id',
            'id',
            'gejala_id'
        );
    }

    public function kerusakans()
    {
        return $this->hasManyThrough(
            Kerusakan::class,
            DiagnosisResult::class,
            'diagnosis_history_id',
            'id',
            'id',
            'kerusakan_id'
        );
    }
```

Method lain: `getLaptopDisplayAttribute()`.

Trait domain penting: `SoftDeletes`.

### `DiagnosisResult` -> `diagnosis_results`

Sumber: [DiagnosisResult.php](app/Models/DiagnosisResult.php).

```php
    protected $table = 'diagnosis_results';

    protected $fillable = ['diagnosis_history_id', 'kerusakan_id'];
```

Method relasi asli:

```php
    public function diagnosisHistory(): BelongsTo
    {
        return $this->belongsTo(DiagnosisHistory::class, 'diagnosis_history_id');
    }

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }
```

### `Gejala` -> `gejalas`

Sumber: [Gejala.php](app/Models/Gejala.php).

```php
    protected $table = 'gejalas';

    protected $fillable = ['kode_gejala', 'nama_gejala', 'is_frequent'];

    protected $casts = [
        'is_frequent' => 'boolean',
    ];
```

Method relasi asli:

```php
    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'rule_gejala', 'gejala_id', 'rule_id')
                    ->withPivot('is_negated')
                    ->withTimestamps();
    }

    public function ruleGejala(): HasMany
    {
        return $this->hasMany(RuleGejala::class, 'gejala_id');
    }

    public function diagnosisGejala(): HasMany
    {
        return $this->hasMany(DiagnosisGejala::class, 'gejala_id');
    }
```

Trait domain penting: `SoftDeletes`.

### `Kategori` -> `kategoris`

Sumber: [Kategori.php](app/Models/Kategori.php).

```php
    protected $table = 'kategoris';

    protected $fillable = ['nama_kategori'];
```

Method relasi asli:

```php
    public function kerusakans(): HasMany
    {
        return $this->hasMany(Kerusakan::class, 'kategori_id');
    }
```

### `Kerusakan` -> `kerusakans`

Sumber: [Kerusakan.php](app/Models/Kerusakan.php).

```php
    protected $table = 'kerusakans';

    protected $fillable = ['kategori_id', 'kode_kerusakan', 'nama_kerusakan'];
```

Method relasi asli:

```php
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class, 'kerusakan_id');
    }

    public function penyebabs(): HasMany
    {
        return $this->hasMany(Penyebab::class, 'kerusakan_id');
    }

    public function solusis(): HasMany
    {
        return $this->hasMany(Solusi::class, 'kerusakan_id')->orderBy('urutan');
    }

    public function diagnosisResults(): HasMany
    {
        return $this->hasMany(DiagnosisResult::class, 'kerusakan_id');
    }
```

Trait domain penting: `SoftDeletes`.

### `LaptopModel` -> `laptop_models`

Sumber: [LaptopModel.php](app/Models/LaptopModel.php).

```php
    protected $table = 'laptop_models';

    protected $fillable = ['brand_id', 'nama_model', 'seri', 'kategori_laptop', 'tahun_rilis'];

    protected $casts = [
        'tahun_rilis' => 'integer',
    ];
```

Method relasi asli:

```php
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function diagnosisHistories(): HasMany
    {
        return $this->hasMany(DiagnosisHistory::class, 'laptop_model_id');
    }
```

Method lain: `getFullNameAttribute()`.

### `Penyebab` -> `penyebabs`

Sumber: [Penyebab.php](app/Models/Penyebab.php).

```php
    protected $table = 'penyebabs';

    protected $fillable = ['kerusakan_id', 'deskripsi'];
```

Method relasi asli:

```php
    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }
```

### `Rule` -> `rules`

Sumber: [Rule.php](app/Models/Rule.php).

```php
    protected $table = 'rules';

    protected $fillable = ['kerusakan_id', 'kode_rule', 'keterangan'];
```

Method relasi asli:

```php
    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }

    public function ruleGejala(): HasMany
    {
        return $this->hasMany(RuleGejala::class, 'rule_id');
    }

    public function gejalas(): BelongsToMany
    {
        return $this->belongsToMany(Gejala::class, 'rule_gejala', 'rule_id', 'gejala_id')
                    ->withPivot('is_negated')
                    ->withTimestamps();
    }
```

Trait domain penting: `SoftDeletes`.

### `RuleGejala` -> `rule_gejala`

Sumber: [RuleGejala.php](app/Models/RuleGejala.php).

```php
    protected $table = 'rule_gejala';

    protected $fillable = ['rule_id', 'gejala_id', 'is_negated'];

    protected $casts = [
        'is_negated' => 'boolean',
    ];
```

Method relasi asli:

```php
    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }
```

### `Solusi` -> `solusis`

Sumber: [Solusi.php](app/Models/Solusi.php).

```php
    protected $table = 'solusis';

    protected $fillable = ['kerusakan_id', 'deskripsi', 'urutan'];
```

Method relasi asli:

```php
    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }
```

### `User` -> `users`

Sumber: [User.php](app/Models/User.php).

```php
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
```

Method relasi asli:

```php
    public function diagnosisHistories(): HasMany
    {
        return $this->hasMany(DiagnosisHistory::class);
    }
```

Method lain: `casts()`, `isAdmin()`, `isTeknisi()`, `hasRole()`.

`DiagnosisHistory::gejalas()` dan `kerusakans()` memakai **hasManyThrough** dengan key eksplisit, bukan belongsToMany. Model penghubung `RuleGejala`, `DiagnosisGejala`, dan `DiagnosisResult` extends `Model`, bukan `Pivot`. `User` tidak mendefinisikan method kebalikan `activityLogs()`, walaupun FK audit ke users ada.

## 6. Daftar Controller dan Service

Seluruh controller extends `App\Http\Controllers\Controller`, sebuah abstract class kosong. Selain properti injeksi pada `DiagnosisController`, tidak ditemukan properti domain eksplisit pada controller/service; variabel filter, query, hasil inferensi, dan request adalah variabel lokal/parameter.

| Class | Tanggung jawab dan perilaku penting |
|---|---|
| `AnalyticsController` | Agregasi riwayat/hasil menurut brand, model, tanggal, kerusakan dan kategori; insight berbasis statistik, bukan machine learning. |
| `LoginController` | Login admin/teknisi melalui Auth, regenerasi session dan logout. |
| `BrandController` | CRUD brand dan jumlah model laptop. |
| `DashboardController` | Statistik jumlah master dan diagnosis terbaru. |
| `DiagnosisHistoryController` | Daftar/detail riwayat dan PDF melalui DomPDF untuk teknisi; print() dan export() saat ini selalu abort(403). |
| `GejalaController` | CRUD gejala, toggleFrequent(), menulis audit; penghapusan dibatasi jika dipakai rule. |
| `KategoriController` | CRUD kategori; validasi nama unique di aplikasi; menulis audit. |
| `KerusakanController` | CRUD kerusakan dan detail kategori/penyebab/solusi/rule; menulis audit. |
| `LaptopModelController` | CRUD katalog model serta filter brand. |
| `PenyebabController` | CRUD bersarang di kerusakan; memeriksa admin dan kesesuaian parent. |
| `RuleController` | CRUD rule dan detail gejala/negasi dalam transaksi; update menghapus detail lama lalu membuat ulang; menulis audit. |
| `SolusiController` | CRUD solusi bersarang, urutan langkah; memeriksa admin dan parent. |
| `UserController` | CRUD akun, hashing password dan audit; aturan satu admin diterapkan di controller, bukan unique constraint role. |
| `DiagnosisController` | Form gejala/katalog, validasi, memanggil diagnoseAndSave(), menyimpan ID history ke session, menampilkan hasil; admin ditolak melakukan diagnosis. |
| `HomeController` | Menampilkan halaman beranda. |

### `AnalyticsController`

Sumber: [AnalyticsController.php](app/Http/Controllers/Admin/AnalyticsController.php).

Method aktual (visibility dan parameter):

```php
public function index(Request $request)
public function data(Request $request)
private function calculateAnalytics($brandId = null, $modelId = null, $startDate = null, $endDate = null): array
private function generateInsights($damageBreakdown, $brandId, $modelId, $totalCases): array
```

Class yang diimpor/digunakan: `App\Models\Brand`, `App\Models\LaptopModel`, `App\Models\DiagnosisHistory`, `App\Models\Kerusakan`, `Illuminate\Http\Request`, `Illuminate\Support\Facades\DB`.


### `LoginController`

Sumber: [LoginController.php](app/Http/Controllers/Admin/Auth/LoginController.php).

Method aktual (visibility dan parameter):

```php
public function showLogin()
public function login(Request $request)
public function logout(Request $request)
```

Class yang diimpor/digunakan: `Illuminate\Http\Request`, `Illuminate\Support\Facades\Auth`.


### `BrandController`

Sumber: [BrandController.php](app/Http/Controllers/Admin/BrandController.php).

Method aktual (visibility dan parameter):

```php
public function index(Request $request)
public function create()
public function store(Request $request)
public function edit(Brand $brand)
public function update(Request $request, Brand $brand)
public function destroy(Brand $brand)
```

Class yang diimpor/digunakan: `App\Models\Brand`, `Illuminate\Http\Request`.


### `DashboardController`

Sumber: [DashboardController.php](app/Http/Controllers/Admin/DashboardController.php).

Method aktual (visibility dan parameter):

```php
public function index()
```

Class yang diimpor/digunakan: `App\Models\DiagnosisHistory`, `App\Models\Gejala`, `App\Models\Kerusakan`, `App\Models\Rule`, `\App\Models\Brand`, `\App\Models\LaptopModel`.


### `DiagnosisHistoryController`

Sumber: [DiagnosisHistoryController.php](app/Http/Controllers/Admin/DiagnosisHistoryController.php).

Method aktual (visibility dan parameter):

```php
public function index(Request $request)
public function show(DiagnosisHistory $riwayat)
public function print(DiagnosisHistory $riwayat)
public function downloadPdf(DiagnosisHistory $riwayat)
public function export(Request $request)
```

Class yang diimpor/digunakan: `App\Models\DiagnosisHistory`, `Illuminate\Http\Request`, `\App\Models\Brand`, `\Barryvdh\DomPDF\Facade\Pdf`.


### `GejalaController`

Sumber: [GejalaController.php](app/Http/Controllers/Admin/GejalaController.php).

Method aktual (visibility dan parameter):

```php
public function index(Request $request)
public function create()
public function store(Request $request)
public function edit(Gejala $gejala)
public function update(Request $request, Gejala $gejala)
public function toggleFrequent(Gejala $gejala)
public function destroy(Gejala $gejala)
```

Class yang diimpor/digunakan: `App\Models\Gejala`, `App\Traits\LogsActivity`, `Illuminate\Http\Request`.

Menggunakan trait `LogsActivity` -> memanggil `logActivity()` -> `ActivityLog::create()`.


### `KategoriController`

Sumber: [KategoriController.php](app/Http/Controllers/Admin/KategoriController.php).

Method aktual (visibility dan parameter):

```php
public function index()
public function create()
public function store(Request $request)
public function edit(Kategori $kategori)
public function update(Request $request, Kategori $kategori)
public function destroy(Kategori $kategori)
```

Class yang diimpor/digunakan: `App\Models\Kategori`, `App\Traits\LogsActivity`, `Illuminate\Http\Request`.

Menggunakan trait `LogsActivity` -> memanggil `logActivity()` -> `ActivityLog::create()`.


### `KerusakanController`

Sumber: [KerusakanController.php](app/Http/Controllers/Admin/KerusakanController.php).

Method aktual (visibility dan parameter):

```php
public function index(Request $request)
public function create()
public function store(Request $request)
public function show(Kerusakan $kerusakan)
public function edit(Kerusakan $kerusakan)
public function update(Request $request, Kerusakan $kerusakan)
public function destroy(Kerusakan $kerusakan)
```

Class yang diimpor/digunakan: `App\Models\Kerusakan`, `App\Models\Kategori`, `App\Traits\LogsActivity`, `Illuminate\Http\Request`.

Menggunakan trait `LogsActivity` -> memanggil `logActivity()` -> `ActivityLog::create()`.


### `LaptopModelController`

Sumber: [LaptopModelController.php](app/Http/Controllers/Admin/LaptopModelController.php).

Method aktual (visibility dan parameter):

```php
public function index(Request $request)
public function create()
public function store(Request $request)
public function edit(LaptopModel $laptop_model)
public function update(Request $request, LaptopModel $laptop_model)
public function destroy(LaptopModel $laptop_model)
```

Class yang diimpor/digunakan: `App\Models\Brand`, `App\Models\LaptopModel`, `Illuminate\Http\Request`.


### `PenyebabController`

Sumber: [PenyebabController.php](app/Http/Controllers/Admin/PenyebabController.php).

Method aktual (visibility dan parameter):

```php
public function create(Kerusakan $kerusakan)
public function store(Request $request, Kerusakan $kerusakan)
public function edit(Kerusakan $kerusakan, Penyebab $penyebab)
public function update(Request $request, Kerusakan $kerusakan, Penyebab $penyebab)
public function destroy(Kerusakan $kerusakan, Penyebab $penyebab)
```

Class yang diimpor/digunakan: `App\Models\Kerusakan`, `App\Models\Penyebab`, `Illuminate\Http\Request`.


### `RuleController`

Sumber: [RuleController.php](app/Http/Controllers/Admin/RuleController.php).

Method aktual (visibility dan parameter):

```php
public function index(Request $request)
public function create()
public function store(Request $request)
public function show(Rule $rule)
public function edit(Rule $rule)
public function update(Request $request, Rule $rule)
public function destroy(Rule $rule)
```

Class yang diimpor/digunakan: `App\Models\Rule`, `App\Models\Kerusakan`, `App\Models\Gejala`, `App\Models\RuleGejala`, `App\Traits\LogsActivity`, `Illuminate\Http\Request`, `Illuminate\Support\Facades\DB`.

Menggunakan trait `LogsActivity` -> memanggil `logActivity()` -> `ActivityLog::create()`.


### `SolusiController`

Sumber: [SolusiController.php](app/Http/Controllers/Admin/SolusiController.php).

Method aktual (visibility dan parameter):

```php
public function create(Kerusakan $kerusakan)
public function store(Request $request, Kerusakan $kerusakan)
public function edit(Kerusakan $kerusakan, Solusi $solusi)
public function update(Request $request, Kerusakan $kerusakan, Solusi $solusi)
public function destroy(Kerusakan $kerusakan, Solusi $solusi)
```

Class yang diimpor/digunakan: `App\Models\Kerusakan`, `App\Models\Solusi`, `Illuminate\Http\Request`.


### `UserController`

Sumber: [UserController.php](app/Http/Controllers/Admin/UserController.php).

Method aktual (visibility dan parameter):

```php
public function index(Request $request)
public function create()
public function store(Request $request)
public function edit(User $user)
public function update(Request $request, User $user)
public function destroy(User $user)
```

Class yang diimpor/digunakan: `App\Models\User`, `App\Traits\LogsActivity`, `Illuminate\Http\Request`, `Illuminate\Support\Facades\Hash`, `Illuminate\Validation\Rule`.

Menggunakan trait `LogsActivity` -> memanggil `logActivity()` -> `ActivityLog::create()`.


### `DiagnosisController`

Sumber: [DiagnosisController.php](app/Http/Controllers/DiagnosisController.php).

Method aktual (visibility dan parameter):

```php
public function __construct(
        private readonly ForwardChainingService $forwardChaining
    )
private function authorizeDiagnosis()
public function index()
public function process(Request $request)
public function result(Request $request)
```

Class yang diimpor/digunakan: `App\Models\Brand`, `App\Models\Gejala`, `App\Services\ForwardChainingService`, `Illuminate\Http\Request`, `\App\Models\DiagnosisHistory`.


### `HomeController`

Sumber: [HomeController.php](app/Http/Controllers/HomeController.php).

Method aktual (visibility dan parameter):

```php
public function index()
```

Class yang diimpor/digunakan: `Illuminate\Http\Request`.


### `ForwardChainingService`

Sumber: [ForwardChainingService.php](app/Services/ForwardChainingService.php).

| Method | Perilaku | Class yang digunakan |
|---|---|---|
| `public diagnose(array $gejalaIds): Collection` | Memuat rule dan kondisi, mencocokkan fakta, deduplikasi kerusakan, memuat kategori/penyebab/solusi | Rule, Kerusakan, Collection |
| `private isRuleFired(Rule $rule, Collection $gejalaSet): bool` | Seluruh kondisi positif harus dipilih; kondisi negasi harus tidak dipilih; rule kosong ditolak | Rule, RuleGejala melalui relasi, Collection |
| `public diagnoseAndSave(array $gejalaIds, ?string $namaPengguna = null, ?int $userId = null, ?int $brandId = null, ?int $laptopModelId = null, ?string $laptopInfoManual = null): array` | Transaksi membuat history, detail gejala dan hasil diagnosis; mengembalikan history dan results | DB, DiagnosisHistory, DiagnosisGejala, DiagnosisResult, method diagnose() |

Service tidak mempunyai properti domain eksplisit. Implementasi mengevaluasi semua rule terhadap fakta gejala sekali; tidak ada loop penambahan fakta baru sampai fixed point. Nama class/metode yang digunakan aplikasi tetap Forward Chaining. Brand dan model hanya disimpan sebagai konteks riwayat; `diagnose()` tidak memakainya untuk memilih rule. Tidak ada confidence score, probabilitas, atau tabel pelatihan pada struktur yang diperiksa.

### `DiagnosisController` dan dependency injection

Properti aktual: `private readonly ForwardChainingService $forwardChaining`, dipasok melalui constructor. Hubungan ke service merupakan dependency/injeksi, bukan pewarisan. Method `process()` memanggil `diagnoseAndSave()`; `result()` membaca `DiagnosisHistory` beserta relasi. User dipakai melalui `auth()` untuk otorisasi/ID akun.

### `LogsActivity` dan class pendukung

`LogsActivity` adalah **trait**, bukan service/model. Method `protected logActivity(string $action, Model $model, string $description, ?array $changes = null): void` menyimpan audit melalui `ActivityLog`. Dipakai oleh KategoriController, GejalaController, KerusakanController, RuleController, dan UserController. BrandController, LaptopModelController, PenyebabController, dan SolusiController tidak menggunakan trait ini pada kode saat dianalisis.

`AppServiceProvider::boot()` mendaftarkan rate limiter login/diagnosis. Middleware AdminMiddleware/RoleMiddleware mendukung pembatasan akses. Keduanya dapat diletakkan pada diagram infrastruktur terpisah agar diagram domain tetap terbaca.

### `MachineLearningDiagnosisService`

**Tidak ditemukan** pada file aplikasi dan tidak direferensikan oleh alur diagnosis yang diperiksa. Jangan memasukkannya ke Class Diagram implementasi aktual. `AnalyticsController::generateInsights()` menghasilkan teks dari agregasi data; keberadaan method ini bukan bukti layanan machine learning.

## 7. Rekomendasi Entitas untuk ERD

Gunakan 13 entitas inti berikut dan satu entitas audit pendukung. Nama tampilan boleh diterjemahkan, tetapi sertakan nama tabel aktual agar dapat ditelusuri.

| Entitas | Tabel aktual | Kelompok |
|---|---|---|
| Akun admin dan teknisi | `users` | Inti |
| Kategori kerusakan | `kategoris` | Inti |
| Merek laptop | `brands` | Inti |
| Katalog model laptop | `laptop_models` | Inti |
| Master gejala | `gejalas` | Inti |
| Master kerusakan | `kerusakans` | Inti |
| Penyebab kerusakan | `penyebabs` | Inti |
| Langkah solusi | `solusis` | Inti |
| Aturan inferensi | `rules` | Inti |
| Kondisi aturan dan negasi | `rule_gejala` | Inti |
| Transaksi/riwayat konsultasi | `diagnosis_histories` | Inti |
| Gejala yang dipilih saat diagnosis | `diagnosis_gejala` | Inti |
| Kerusakan hasil diagnosis | `diagnosis_results` | Inti |
| Audit aktivitas admin | `activity_logs` | Audit pendukung |

Seluruh relasi fisik ERD mengikuti bagian 3?4. Hubungan M:N ditampilkan melalui tiga entitas penghubung; jangan menggambar FK langsung dari `gejalas` ke `kerusakans`. Hubungannya diperoleh melalui rule. Tidak ada entitas Laptop milik pengguna, training dataset, atau Consultation tambahan yang terbukti pada migration.

## 8. Rekomendasi Struktur LRS

### Transformasi ERD ke LRS

1. Setiap entitas master/transaksi dipetakan ke satu record/tabel dengan PK `id`.
2. Relasi 1:N membawa PK induk menjadi FK pada tabel anak sesuai bagian 3.
3. Relasi M:N Rule-Gejala dipecah menjadi `rule_gejala`; atribut hubungan `is_negated` tetap berada di tabel ini.
4. Relasi M:N Riwayat-Gejala dipecah menjadi `diagnosis_gejala`.
5. Relasi M:N Riwayat-Kerusakan dipecah menjadi `diagnosis_results`, sehingga satu riwayat dapat memuat beberapa hasil.
6. Pertahankan FK nullable untuk akun guest, brand/model opsional, dan pengguna audit. Jangan menjadikannya wajib pada LRS.
7. Pertahankan PK surrogate pada tabel penghubung. Jangan mengklaim pasangan FK sebagai candidate key karena tidak ada unique constraint.
8. Audit mempertahankan JSON `changes`; jangan mengubah snapshot ini menjadi relasi FK tambahan.

### Bentuk record final

Notasi `PK`, `FK`, dan `?` (nullable) merupakan anotasi, bukan bagian nama kolom. Detail tipe/default/unique mengikuti bagian 2.

```text
users(
  id [PK],
  name,
  email,
  email_verified_at?,
  password,
  role,
  remember_token?,
  created_at?,
  updated_at?
)
```

```text
kategoris(
  id [PK],
  nama_kategori,
  created_at?,
  updated_at?
)
```

```text
brands(
  id [PK],
  nama_brand,
  logo_url?,
  created_at?,
  updated_at?
)
```

```text
laptop_models(
  id [PK],
  brand_id [FK],
  nama_model,
  seri?,
  kategori_laptop,
  tahun_rilis?,
  created_at?,
  updated_at?
)
```

```text
gejalas(
  id [PK],
  kode_gejala,
  nama_gejala,
  is_frequent,
  created_at?,
  updated_at?,
  deleted_at?
)
```

```text
kerusakans(
  id [PK],
  kategori_id [FK],
  kode_kerusakan,
  nama_kerusakan,
  created_at?,
  updated_at?,
  deleted_at?
)
```

```text
penyebabs(
  id [PK],
  kerusakan_id [FK],
  deskripsi,
  created_at?,
  updated_at?
)
```

```text
solusis(
  id [PK],
  kerusakan_id [FK],
  deskripsi,
  urutan,
  created_at?,
  updated_at?
)
```

```text
rules(
  id [PK],
  kerusakan_id [FK],
  kode_rule,
  keterangan?,
  created_at?,
  updated_at?,
  deleted_at?
)
```

```text
rule_gejala(
  id [PK],
  rule_id [FK],
  gejala_id [FK],
  is_negated,
  created_at?,
  updated_at?
)
```

```text
diagnosis_histories(
  id [PK],
  user_id? [FK],
  nama_pengguna?,
  brand_id? [FK],
  laptop_model_id? [FK],
  laptop_info_manual?,
  tanggal_diagnosis,
  created_at?,
  updated_at?,
  deleted_at?
)
```

```text
diagnosis_gejala(
  id [PK],
  diagnosis_history_id [FK],
  gejala_id [FK],
  created_at?,
  updated_at?
)
```

```text
diagnosis_results(
  id [PK],
  diagnosis_history_id [FK],
  kerusakan_id [FK],
  created_at?,
  updated_at?
)
```

```text
activity_logs(
  id [PK],
  user_id? [FK],
  action,
  model_type,
  model_id?,
  description,
  ip_address?,
  changes?,
  created_at?,
  updated_at?
)
```

### Catatan integritas untuk penjelasan skripsi

- LRS ini merepresentasikan implementasi yang ada, tanpa usulan perubahan migration.
- Unique kode gejala/kerusakan/rule, email, nama brand, dan gabungan katalog tetap dipertahankan.
- Jumlah minimum satu gejala pada form tidak menjamin minimum satu detail pada level database.
- Tidak ada FK dari hasil ke rule yang memicu hasil. Riwayat menyimpan gejala dan kerusakan, bukan snapshot versi rule, nama master, penyebab, atau solusi. Perubahan master dapat memengaruhi informasi yang ditampilkan saat membaca riwayat lama.
- Tidak ada bukti cukup untuk mengklaim semua tabel memenuhi suatu normal form tertentu hanya berdasarkan nama dan FK; khususnya brand dan model pada history tidak dipaksa konsisten oleh constraint gabungan.

## 9. Rekomendasi Class untuk Class Diagram

### Class model dan atribut domain

Atribut berikut berasal dari kolom database/cast. Pada PHP, Eloquent mengaksesnya sebagai atribut dinamis; jangan menggambarkannya sebagai properti private yang dideklarasikan eksplisit. Untuk diagram ringkas, atribut timestamp dapat disembunyikan tanpa menghapusnya dari kamus data.

| Class | Atribut domain penting | Method selain relasi |
|---|---|---|
| `ActivityLog` | id, user_id, action, model_type, model_id, description, ip_address, changes | scopeForModel(), scopeByUser() |
| `Brand` | id, nama_brand, logo_url | Method relasi pada bagian 5 |
| `DiagnosisGejala` | id, diagnosis_history_id, gejala_id | Method relasi pada bagian 5 |
| `DiagnosisHistory` | id, user_id, nama_pengguna, brand_id, laptop_model_id, laptop_info_manual, tanggal_diagnosis | getLaptopDisplayAttribute() -> atribut laptop_display |
| `DiagnosisResult` | id, diagnosis_history_id, kerusakan_id | Method relasi pada bagian 5 |
| `Gejala` | id, kode_gejala, nama_gejala, is_frequent | Method relasi pada bagian 5 |
| `Kategori` | id, nama_kategori | Method relasi pada bagian 5 |
| `Kerusakan` | id, kategori_id, kode_kerusakan, nama_kerusakan | Method relasi pada bagian 5 |
| `LaptopModel` | id, brand_id, nama_model, seri, kategori_laptop, tahun_rilis | getFullNameAttribute() -> atribut full_name |
| `Penyebab` | id, kerusakan_id, deskripsi | Method relasi pada bagian 5 |
| `Rule` | id, kerusakan_id, kode_rule, keterangan | Method relasi pada bagian 5 |
| `RuleGejala` | id, rule_id, gejala_id, is_negated | Method relasi pada bagian 5 |
| `Solusi` | id, kerusakan_id, deskripsi, urutan | Method relasi pada bagian 5 |
| `User` | id, name, email, email_verified_at, password, role | casts(), isAdmin(), isTeknisi(), hasRole() |

### Class kontrol dan service

Masukkan `DiagnosisController`, `ForwardChainingService`, dan controller pengelolaan knowledge base: `KategoriController`, `GejalaController`, `KerusakanController`, `PenyebabController`, `SolusiController`, `RuleController`. Tambahkan `BrandController`, `LaptopModelController`, `DiagnosisHistoryController`, dan `UserController` untuk diagram aplikasi lengkap. `DashboardController`, `AnalyticsController`, `LoginController`, dan `HomeController` adalah pendukung; method dan dependency aktual tersedia pada bagian 6.

Satu-satunya properti controller domain yang dideklarasikan adalah `DiagnosisController.-forwardChaining: ForwardChainingService {readonly}`. Pada `ForwardChainingService`, tampilkan `+diagnose()`, `-isRuleFired()`, dan `+diagnoseAndSave()`. Gunakan signature pada bagian 6 untuk parameter dan return type; method controller tanpa return type eksplisit tidak perlu diberi return type PHP rekaan.

### Hubungan antar class

| Sumber | Tujuan | Jenis hubungan / bukti |
|---|---|---|
| Semua model selain User | Eloquent Model | Generalization/extends |
| User | Authenticatable | Generalization/extends |
| Semua controller | Controller | Generalization/extends |
| DiagnosisController | ForwardChainingService | Dependency injection melalui properti readonly |
| ForwardChainingService | Rule, Kerusakan | Dependency pembacaan kondisi dan hasil |
| ForwardChainingService | DiagnosisHistory, DiagnosisGejala, DiagnosisResult | Dependency persistensi dalam DB::transaction |
| DiagnosisController | Gejala, Brand, DiagnosisHistory, User | Dependency query, eager loading, dan auth |
| Controller knowledge base | Model yang dikelola | Dependency sesuai daftar import dan pemanggilan bagian 6 |
| Controller dengan LogsActivity | LogsActivity | Penggunaan trait, bukan inheritance class |
| LogsActivity | ActivityLog | Dependency pencatatan audit |
| DiagnosisHistoryController | DomPDF Facade Pdf | Dependency pembuatan dokumen PDF |
| Antar model | Model terkait | Association dengan multiplicity berdasarkan FK bagian 4; method asli bagian 5 |

Relasi `hasMany` bukan bukti kepemilikan lifecycle UML composition. Gunakan association biasa untuk model database. Relasi shortcut `hasManyThrough` dapat diberi label derived/through; jangan menggambarkannya sebagai FK baru.

Saran penyajian: pisahkan diagram model domain dan diagram controller/service agar terbaca. Diagram domain memuat 13 class inti plus ActivityLog bila audit masuk cakupan skripsi. Diagram controller/service memuat dependency di atas. `MachineLearningDiagnosisService` tidak dimasukkan karena tidak ada dalam implementasi aktual.

### Jejak sumber dan batas analisis

- Seluruh migration dalam `database/migrations` diperiksa termasuk tabel infrastruktur dan migration perubahan.
- Seluruh model dalam `app/Models` diperiksa; bagian 5 menyalin method relasi tanpa mengganti bentuk relasinya.
- Controller dalam `app/Http/Controllers`, service dalam `app/Services`, `app/Traits/LogsActivity.php`, `routes/web.php`, konfigurasi session/cache, dan provider rate limiter digunakan untuk menelusuri penggunaan.
- Struktur hasil dapat berbeda dari database terpasang apabila migration belum dijalankan atau ada perubahan manual di luar source. Database tidak diakses untuk memverifikasi kondisi tersebut.
- Tidak ada source code, migration, atau data yang diubah dalam pekerjaan analisis ini.
