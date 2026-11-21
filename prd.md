# PRD — Sistem Pakar Diagnosa Kerusakan Laptop

## 1. Problem Statement

Teknisi atau pengguna laptop sering mengalami kesulitan dalam mengidentifikasi penyebab kerusakan hardware maupun software secara cepat dan sistematis. Proses diagnosis masih banyak bergantung pada pengalaman teknisi sehingga hasil diagnosis dapat berbeda antara satu orang dengan lainnya.

Sistem yang akan dibuat adalah aplikasi web sistem pakar yang membantu pengguna melakukan diagnosis kerusakan laptop berdasarkan gejala yang dialami.

Sistem menggunakan metode **Forward Chaining** untuk mencocokkan gejala dengan knowledge base dan menghasilkan kemungkinan kerusakan beserta informasi penyebab dan solusi.

Sistem dibangun menggunakan **Laravel** sebagai framework utama agar dapat memanfaatkan ecosystem dan library Laravel yang tersedia.

---

## 2. Goals

Tujuan utama sistem:

1. Membantu pengguna melakukan diagnosis awal kerusakan laptop.
2. Mendiagnosis kerusakan hardware dan software berdasarkan gejala yang dipilih pengguna.
3. Mengimplementasikan metode Forward Chaining sebagai mesin inferensi.
4. Menyediakan hasil diagnosis yang mudah dipahami.
5. Menyediakan informasi penyebab dan solusi berdasarkan hasil diagnosis.
6. Memungkinkan admin mengelola knowledge base sistem pakar.
7. Menjaga agar proses diagnosis konsisten berdasarkan rule yang tersimpan.
8. Menyediakan sistem web yang mudah dikembangkan dan dipelihara menggunakan Laravel.

---

## 3. Target Users

### 3.1 Guest / Pengguna

Pengguna yang mengakses sistem tanpa login.

Hak akses:
- Melihat informasi sistem.
- Melakukan diagnosis laptop.
- Memilih gejala yang dialami.
- Melihat hasil diagnosis.
- Melihat penyebab dan solusi kerusakan.

### 3.2 Admin

Pengelola sistem dan knowledge base.

Hak akses:
- Login ke admin panel.
- Mengelola data kerusakan.
- Mengelola data gejala.
- Mengelola rule Forward Chaining.
- Mengelola kategori hardware/software.
- Mengelola informasi penyebab dan solusi.
- Melihat riwayat diagnosis.
- Mengelola konten/informasi sistem jika diperlukan.

---

## 4. User Stories

### Guest

- Sebagai pengguna, saya ingin melihat informasi sistem agar memahami fungsi aplikasi.
- Sebagai pengguna, saya ingin memilih gejala yang dialami laptop agar sistem dapat melakukan diagnosis.
- Sebagai pengguna, saya ingin mendapatkan hasil diagnosis berdasarkan gejala yang saya pilih.
- Sebagai pengguna, saya ingin mengetahui jenis kerusakan yang kemungkinan terjadi.
- Sebagai pengguna, saya ingin melihat penyebab kerusakan.
- Sebagai pengguna, saya ingin melihat solusi atau rekomendasi penanganan.
- Sebagai pengguna, saya ingin mengulangi diagnosis jika hasil sebelumnya belum sesuai.

### Admin

- Sebagai admin, saya ingin login agar hanya pihak yang berwenang dapat mengelola sistem.
- Sebagai admin, saya ingin mengelola data gejala.
- Sebagai admin, saya ingin mengelola data kerusakan hardware dan software.
- Sebagai admin, saya ingin membuat dan mengubah rule diagnosis.
- Sebagai admin, saya ingin menghubungkan gejala dengan kerusakan melalui rule.
- Sebagai admin, saya ingin mengelola penyebab dan solusi kerusakan.
- Sebagai admin, saya ingin melihat riwayat hasil diagnosis.

---

## 5. Functional Requirement

### 5.1 Authentication

- Sistem menyediakan login untuk admin.
- Sistem menggunakan authentication Laravel.
- Password harus disimpan menggunakan hashing.
- Admin yang belum login tidak dapat mengakses admin panel.

### 5.2 Diagnosis

Sistem menyediakan alur diagnosis:

1. Pengguna membuka halaman diagnosis.
2. Sistem menampilkan daftar gejala.
3. Pengguna memilih gejala yang sesuai dengan kondisi laptop.
4. Sistem memproses gejala menggunakan metode Forward Chaining.
5. Sistem mencocokkan fakta/gejala dengan rule yang tersedia.
6. Sistem menghasilkan kerusakan yang sesuai.
7. Sistem menampilkan hasil diagnosis.
8. Sistem menampilkan kategori kerusakan, penyebab, dan solusi.

Diagnosis harus menggunakan **knowledge base yang tersimpan di database**, bukan rule yang ditulis secara hardcode di controller.

### 5.3 Forward Chaining

Mesin inferensi harus mengikuti konsep Forward Chaining:

- Gejala yang dipilih pengguna menjadi fakta awal.
- Sistem memeriksa rule yang memiliki kondisi sesuai dengan fakta.
- Rule yang terpenuhi menghasilkan fakta/kerusakan baru.
- Proses berlanjut sampai tidak ada rule yang dapat dijalankan.
- Hasil akhir digunakan sebagai dasar diagnosis.

Struktur rule harus dapat dikelola melalui admin sehingga perubahan knowledge base tidak membutuhkan perubahan source code.

### 5.4 Knowledge Base Management

Admin dapat mengelola:

- Kategori kerusakan.
- Data kerusakan.
- Data gejala.
- Rule diagnosis.
- Hubungan gejala dengan rule.
- Penyebab kerusakan.
- Solusi/rekomendasi.

Knowledge base harus mendukung dua kategori utama:

- Hardware
- Software

### 5.5 Diagnosis Result

Hasil diagnosis minimal menampilkan:

- Nama kerusakan.
- Kategori kerusakan.
- Gejala yang mendukung diagnosis.
- Penyebab.
- Solusi/rekomendasi.
- Informasi tambahan jika tersedia.

### 5.6 Diagnosis History

Sistem dapat menyimpan riwayat diagnosis yang berisi:

- Waktu diagnosis.
- Gejala yang dipilih.
- Hasil diagnosis.
- Informasi pendukung lainnya.

Riwayat dapat digunakan admin untuk monitoring dan evaluasi sistem.

### 5.7 Admin CRUD

Admin panel menyediakan operasi CRUD untuk seluruh data knowledge base yang diperlukan.

Setiap operasi CRUD harus memiliki validasi input dan konfirmasi sebelum data penting dihapus.

### 5.8 Database

Database menggunakan relasional database dan harus menyimpan:

- Users/Admin.
- Gejala.
- Kerusakan.
- Kategori.
- Rule.
- Relasi rule dengan gejala.
- Penyebab.
- Solusi.
- Riwayat diagnosis.

Struktur database harus mengikuti relasi yang jelas dan menghindari duplikasi data yang tidak diperlukan.

---

## 6. Non-Functional Requirement

### 6.1 Technology

- Framework: Laravel.
- Bahasa: PHP.
- Database: MySQL.
- Frontend menggunakan Blade dan teknologi frontend yang kompatibel dengan Laravel.
- Gunakan library Laravel yang tersedia jika dapat menyederhanakan implementasi.
- Hindari menambahkan framework frontend besar jika tidak diperlukan.

### 6.2 Security

Sistem minimal menerapkan:

- Authentication.
- Authorization.
- Password hashing.
- CSRF protection.
- Input validation.
- Protection terhadap SQL Injection menggunakan Laravel Eloquent/Query Builder.
- Protection terhadap XSS.
- Secure session management.
- Validasi dan sanitasi data yang diterima pengguna.

### 6.3 Performance

- Proses diagnosis harus dapat berjalan dengan cepat untuk jumlah knowledge base normal.
- Query database harus dibuat efisien.
- Hindari query database yang tidak diperlukan.
- Logic Forward Chaining harus dipisahkan dari presentation layer.

### 6.4 Maintainability

- Mengikuti struktur dan convention Laravel.
- Menggunakan MVC.
- Logic bisnis sistem pakar dipisahkan dari controller.
- Gunakan Service/Domain layer jika diperlukan untuk logic Forward Chaining.
- Hindari hardcoded diagnosis rules.
- Kode harus mudah dikembangkan ketika jumlah gejala, kerusakan, dan rule bertambah.

### 6.5 Usability

- Interface sederhana dan mudah dipahami.
- Proses diagnosis tidak membingungkan pengguna.
- Istilah teknis dijelaskan dengan bahasa yang mudah dipahami.
- Hasil diagnosis harus jelas membedakan kerusakan hardware dan software.

### 6.6 Consistency

Architecture, database, business logic, dan user flow harus mengikuti PRD ini.

Agent AI **tidak boleh mengubah alur utama, menambahkan fitur besar, mengganti teknologi, atau mengubah metode Forward Chaining tanpa instruksi eksplisit dari developer/user, tidak boleh mengubah rule, gejala, kerusakan, penyebab, atau solusi tanpa instruksi eksplisit dari developer/user**

Jika terdapat kebutuhan yang belum dijelaskan dalam PRD, implementasi harus memilih solusi paling sederhana yang tetap konsisten dengan PRD.

---

## 7. Scope

### 7.1 In Scope

- Web application menggunakan Laravel.
- Guest diagnosis.
- Admin authentication.
- Admin dashboard.
- CRUD gejala.
- CRUD kerusakan.
- CRUD kategori hardware/software.
- CRUD rule Forward Chaining.
- Pengelolaan hubungan gejala dan rule.
- Data penyebab kerusakan.
- Data solusi/rekomendasi.
- Mesin inferensi Forward Chaining.
- Hasil diagnosis.
- Riwayat diagnosis.
- Database MySQL.
- Basic security Laravel.
- Responsive interface.

### 7.2 Out of Scope

Fitur berikut tidak termasuk dalam versi awal kecuali diminta secara eksplisit:

- Mobile application native.
- Integrasi IoT.
- Integrasi hardware sensor laptop.
- Automatic hardware scanning.
- Machine Learning.
- Deep Learning.
- Generative AI sebagai mesin diagnosis utama.
- Chatbot AI sebagai mesin diagnosis utama.
- Integrasi marketplace/service center.
- Pembayaran online.
- Multi-tenant system.
- Sistem rekomendasi spare part otomatis.
- Remote diagnosis.
- Diagnosis berdasarkan data hardware yang dibaca otomatis dari perangkat.

### 7.3 Development Rule

PRD ini merupakan **single source of truth** untuk scope dan alur utama aplikasi.

Prioritas implementasi:

1. Database dan knowledge base.
2. Mesin Forward Chaining.
3. Alur diagnosis guest.
4. Hasil diagnosis.
5. Admin authentication.
6. Admin CRUD knowledge base.
7. Riwayat diagnosis.
8. UI/UX dan penyempurnaan.

Setiap implementasi baru harus tetap mengikuti tujuan dan batasan PRD ini.

Jangan membuat fitur hanya karena dianggap "bagus untuk ditambahkan". Fitur di luar scope harus menunggu instruksi eksplisit.

Metode diagnosis utama sistem adalah **Forward Chaining** dan tidak boleh diganti dengan metode lain tanpa instruksi eksplisit.

