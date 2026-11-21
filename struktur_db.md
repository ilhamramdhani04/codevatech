Saya sedang menyusun perancangan basis data dan Class Diagram untuk skripsi Laravel ini.

Tugas kamu adalah MENGANALISIS project saja. Jangan mengubah file apa pun.

Saya membutuhkan data untuk membuat:
1. ERD
2. Transformasi ERD ke LRS
3. LRS
4. Class Diagram

Lakukan hal berikut:

A. STRUKTUR DATABASE
1. Telusuri seluruh file migration.
2. Tampilkan seluruh tabel yang masih digunakan oleh sistem.
3. Untuk setiap tabel, tampilkan:
   - nama tabel
   - nama kolom
   - tipe data
   - primary key
   - foreign key
   - referensi foreign key ke tabel mana
   - nullable atau tidak
   - unique jika ada
   - default value jika ada
4. Identifikasi tabel pivot atau tabel penghubung jika ada.
5. Jangan tampilkan tabel bawaan Laravel yang tidak relevan dengan sistem skripsi, kecuali memang digunakan langsung.

B. RELASI DATABASE
1. Identifikasi hubungan antar tabel.
2. Tuliskan kardinalitasnya, misalnya:
   - users 1:N consultations
   - diagnoses 1:N consultations
   - brands 1:N laptop_models
3. Jelaskan foreign key yang membentuk masing-masing hubungan.
4. Jika ada data array/JSON yang sebenarnya menyimpan ID tabel lain, jelaskan secara khusus karena tidak selalu berbentuk foreign key database.

C. MODEL LARAVEL
1. Telusuri folder app/Models.
2. Untuk setiap model yang digunakan sistem, tampilkan:
   - nama class
   - tabel yang direpresentasikan
   - fillable/casts penting
   - relasi belongsTo
   - relasi hasMany
   - relasi belongsToMany
   - relasi lain jika ada
3. Salin method relasi aslinya.

D. CLASS DIAGRAM
Identifikasi class utama yang relevan dengan sistem skripsi:
- Model
- Controller
- Service

Untuk setiap class tampilkan:
- nama class
- attribute/properti penting
- method penting
- class yang dipanggil atau digunakan
- hubungan antar class

Prioritaskan class yang berkaitan dengan:
- User
- Category
- Brand
- LaptopModel
- Symptom
- Diagnosis/Kerusakan
- Solution
- Rule
- Consultation/Riwayat Diagnosis
- ForwardChainingService
- MachineLearningDiagnosisService
- DiagnosisController
- Controller admin yang berhubungan dengan knowledge base

E. OUTPUT FINAL

Gunakan format:

1. Daftar Tabel
2. Struktur Setiap Tabel
3. Daftar Foreign Key
4. Relasi Antar Tabel + Kardinalitas
5. Daftar Model dan Relasinya
6. Daftar Controller dan Service
7. Rekomendasi Entitas untuk ERD
8. Rekomendasi Struktur LRS
9. Rekomendasi Class untuk Class Diagram

PENTING:
- Jangan mengarang tabel atau relasi.
- Jangan menyimpulkan relasi hanya dari nama tabel jika tidak ada bukti pada migration/model.
- Jangan mengubah source code.
- Jangan melakukan migration.
- Jangan menjalankan perintah yang mengubah database.
- Gunakan source code aktual project ini sebagai sumber utama.