# Knowledge Base — Sistem Pakar Diagnosa Kerusakan Laptop

Metode: Forward Chaining. Struktur: Gejala (fakta awal) → Rule → Kerusakan (fakta hasil) → Penyebab & Solusi.

---

## 1. Master Data Gejala

| Kode | Gejala |
|------|--------|
| G01 | Laptop tidak mau menyala sama sekali (no power) |
| G02 | Lampu indikator power menyala tapi layar tetap blank/hitam |
| G03 | Laptop menyala lalu langsung mati sendiri (shutdown mendadak) |
| G04 | Muncul bunyi beep berulang saat booting |
| G05 | Layar menampilkan garis-garis vertikal/horizontal |
| G06 | Layar berkedip-kedip (flickering) |
| G07 | Tampilan layar pecah/blank spot tapi laptop tetap menyala normal |
| G08 | Layar retak fisik akibat benturan |
| G09 | Laptop sangat lambat saat membuka aplikasi |
| G10 | Muncul Blue Screen of Death (BSOD) |
| G11 | Laptop restart sendiri secara tiba-tiba |
| G12 | Suara kipas sangat kencang/berisik |
| G13 | Bodi laptop terasa sangat panas |
| G14 | Laptop mati otomatis saat digunakan untuk kerja berat (gaming/render) |
| G15 | Baterai cepat habis meski baru saja diisi penuh |
| G16 | Baterai tidak terisi walau charger terpasang |
| G17 | Indikator baterai menunjukkan 0% atau tidak terdeteksi |
| G18 | Laptop hanya bisa menyala saat charger terpasang |
| G19 | Charger tidak mengeluarkan lampu indikator sama sekali |
| G20 | Kabel charger terasa panas berlebih saat dipakai |
| G21 | Beberapa tombol keyboard tidak berfungsi |
| G22 | Semua tombol keyboard tidak berfungsi |
| G23 | Tombol keyboard menekan huruf yang salah dari yang diketik |
| G24 | Suara dari speaker tidak keluar sama sekali |
| G25 | Suara dari speaker pecah/berdesing |
| G26 | Engsel layar terasa longgar/goyang |
| G27 | Engsel layar berbunyi berderit saat dibuka-tutup |
| G28 | Port USB tidak mendeteksi perangkat apa pun |
| G29 | Port USB mendeteksi perangkat tapi koneksi putus-nyambung |
| G30 | Sistem sering freeze/hang tanpa sebab jelas |
| G31 | Muncul pesan error "Operating System Not Found" |
| G32 | Proses booting Windows sangat lama lalu gagal masuk |
| G33 | Muncul banyak iklan pop-up saat browsing atau bahkan saat offline |
| G34 | File tiba-tiba hilang, terenkripsi, atau berubah ekstensi |
| G35 | Antivirus mendeteksi ancaman berulang kali |
| G36 | Perangkat seperti WiFi/Bluetooth/printer tidak terdeteksi sistem |
| G37 | Muncul tanda seru kuning pada Device Manager |
| G38 | Notifikasi penyimpanan hampir penuh terus muncul |
| G39 | Proses install/copy file berjalan sangat lambat |
| G40 | Windows Update gagal terus-menerus dengan kode error |
| G41 | Aplikasi tertentu sering "Not Responding" atau force close |
| G42 | RAM usage di Task Manager selalu di atas 90% saat idle |
| G43 | Touchpad tidak merespons sentuhan sama sekali |
| G44 | Kursor bergerak sendiri tanpa disentuh (touchpad ghosting/drift) |
| G45 | Webcam tidak terdeteksi atau gambar tidak muncul saat video call |
| G46 | Fingerprint sensor gagal mengenali sidik jari berulang kali |
| G47 | Windows Hello (face recognition) gagal login meski wajah sudah terdaftar |
| G48 | Laptop tidak bisa masuk BIOS/UEFI sama sekali (tombol akses tidak merespons) |
| G49 | Muncul pesan "Secure Boot Violation" / "Secure Boot state corrupted" saat booting |
| G50 | Muncul pesan "TPM device not detected/not found" |
| G51 | BitLocker terus meminta recovery key setiap booting tanpa ada perubahan hardware |
| G52 | Port USB-C/Thunderbolt tidak transfer data maupun charging sama sekali |
| G53 | Laptop tidak bisa charging lewat port USB-C tertentu meski charger lain normal |
| G54 | Koneksi WiFi sering putus-nyambung meski indikator sinyal penuh |
| G55 | Bluetooth tidak bisa mendeteksi atau pairing perangkat apa pun |
| G56 | Muncul bunyi dengung bernada tinggi (coil whine) dari dalam bodi saat beban tinggi |
| G57 | Muncul bayangan gambar menetap di layar (burn-in), umumnya pada panel OLED |
| G58 | Refresh rate layar turun sendiri dari spek normal (mis. dari 120Hz/144Hz ke 60Hz) |
| G59 | Fitur AI/Copilot+ (Recall, Windows Studio Effects, dll) error "NPU not detected" |
| G60 | Sistem freeze khusus saat menjalankan aplikasi AI lokal/GPU-intensive (LLM lokal, image generation) |
| G61 | Laptop bootloop (restart terus-menerus) setelah update Windows besar (24H2/25H2/26H2) |
| G62 | Muncul BSOD dengan kode "INACCESSIBLE_BOOT_DEVICE" setelah update besar |
| G63 | Fast charging tidak berfungsi, waktu ngecas jadi jauh lebih lama dari biasanya |
| G64 | Baterai health turun drastis (di bawah 50%) dalam waktu kurang dari 1 tahun pemakaian |
| G65 | SSD NVMe terdeteksi di BIOS tapi hilang/tidak terbaca di File Explorer Windows |
| G66 | Suhu SSD NVMe sangat tinggi (>70°C) disertai penurunan kecepatan baca/tulis drastis |

---

## 1.1. Kategorisasi Gejala per Subsistem

Pengelompokan seluruh gejala (G01–G66) berdasarkan subsistem/komponen laptop yang berkaitan. Satu gejala bisa masuk lebih dari satu kategori jika dipakai di rule dengan kerusakan berbeda (mis. G36, G60).

### 🖥️ Display / Layar (7 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G02 | Lampu indikator power menyala tapi layar tetap blank/hitam | K03 VGA/GPU |
| G05 | Layar menampilkan garis-garis vertikal/horizontal | K03 VGA/GPU |
| G06 | Layar berkedip-kedip (flickering) | K03 VGA/GPU |
| G07 | Tampilan layar pecah/blank spot tapi laptop tetap menyala normal | K08 LCD |
| G08 | Layar retak fisik akibat benturan | K08 LCD |
| G57 | Muncul bayangan gambar menetap di layar (burn-in), umumnya pada panel OLED | K29 OLED Burn-in |
| G58 | Refresh rate layar turun sendiri dari spek normal (mis. 120Hz/144Hz ke 60Hz) | K15 Driver GPU |

### ⌨️ Input — Keyboard (3 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G21 | Beberapa tombol keyboard tidak berfungsi | K07 Keyboard |
| G22 | Semua tombol keyboard tidak berfungsi | K07 Keyboard |
| G23 | Tombol keyboard menekan huruf yang salah dari yang diketik | K07 Keyboard |

### 🖱️ Input — Touchpad (2 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G43 | Touchpad tidak merespons sentuhan sama sekali | K21 Touchpad |
| G44 | Kursor bergerak sendiri tanpa disentuh (touchpad ghosting/drift) | K21 Touchpad |

### 💾 Storage — HDD/SSD (6 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G31 | Muncul pesan error "Operating System Not Found" | K02 HDD/SSD |
| G32 | Proses booting Windows sangat lama lalu gagal masuk | K02 HDD/SSD *atau* K13 OS Corrupt |
| G38 | Notifikasi penyimpanan hampir penuh terus muncul | K17 Storage Penuh |
| G39 | Proses install/copy file berjalan sangat lambat | K02 HDD/SSD *atau* K17 Storage Penuh |
| G65 | SSD NVMe terdeteksi di BIOS tapi hilang/tidak terbaca di File Explorer Windows | K02 HDD/SSD |
| G66 | Suhu SSD NVMe sangat tinggi (>70°C) disertai penurunan kecepatan baca/tulis drastis | K33 NVMe Thermal Throttling |

### 🔋 Power — Baterai & Charger (9 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G01 | Laptop tidak mau menyala sama sekali (no power) | K04 Motherboard *atau* K05 Baterai |
| G15 | Baterai cepat habis meski baru saja diisi penuh | K05 Baterai |
| G16 | Baterai tidak terisi walau charger terpasang | K06 Charger |
| G17 | Indikator baterai menunjukkan 0% atau tidak terdeteksi | K05 Baterai |
| G18 | Laptop hanya bisa menyala saat charger terpasang | K05 Baterai |
| G19 | Charger tidak mengeluarkan lampu indikator sama sekali | K06 Charger |
| G20 | Kabel charger terasa panas berlebih saat dipakai | K06 Charger |
| G63 | Fast charging tidak berfungsi, waktu ngecas jadi jauh lebih lama dari biasanya | K06 Charger (fast charging PD gagal nego) |
| G64 | Baterai health turun drastis (di bawah 50%) dalam waktu kurang dari 1 tahun pemakaian | K32 Baterai Rapid Degradation |

### 🌡️ Thermal — Sistem Pendingin (5 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G12 | Suara kipas sangat kencang/berisik | K03 VGA/GPU *atau* K09 Pendingin |
| G13 | Bodi laptop terasa sangat panas | K03 VGA/GPU *atau* K09 Pendingin |
| G14 | Laptop mati otomatis saat digunakan untuk kerja berat (gaming/render) | K09 Pendingin |
| G56 | Muncul bunyi dengung bernada tinggi (coil whine) dari dalam bodi saat beban tinggi | K28 Coil Whine |
| G60 | Sistem freeze khusus saat menjalankan aplikasi AI lokal/GPU-intensive | K09 Pendingin *atau* K30 NPU |

### 🧠 RAM & Motherboard (5 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G03 | Laptop menyala lalu langsung mati sendiri (shutdown mendadak) | K01 RAM |
| G04 | Muncul bunyi beep berulang saat booting | K04 Motherboard |
| G10 | Muncul Blue Screen of Death (BSOD) | K01 RAM |
| G11 | Laptop restart sendiri secara tiba-tiba | K01 RAM |
| G30 | Sistem sering freeze/hang tanpa sebab jelas | K01 RAM *atau* K20 Registry Corrupt |

### 🔊 Audio — Speaker (2 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G24 | Suara dari speaker tidak keluar sama sekali | K10 Speaker |
| G25 | Suara dari speaker pecah/berdesing | K10 Speaker |

### 🔩 Mekanik — Engsel (2 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G26 | Engsel layar terasa longgar/goyang | K11 Engsel |
| G27 | Engsel layar berbunyi berderit saat dibuka-tutup | K11 Engsel |

### 🔌 Port & Konektivitas (7 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G28 | Port USB tidak mendeteksi perangkat apa pun | K12 Port USB |
| G29 | Port USB mendeteksi perangkat tapi koneksi putus-nyambung | K12 Port USB |
| G36 | Perangkat seperti WiFi/Bluetooth/printer tidak terdeteksi sistem | K15 Driver |
| G52 | Port USB-C/Thunderbolt tidak transfer data maupun charging sama sekali | K26 USB-C/Thunderbolt |
| G53 | Laptop tidak bisa charging lewat port USB-C tertentu meski charger lain normal | K26 USB-C/Thunderbolt |
| G54 | Koneksi WiFi sering putus-nyambung meski indikator sinyal penuh | K27 Modul WiFi/Bluetooth |
| G55 | Bluetooth tidak bisa mendeteksi atau pairing perangkat apa pun | K27 Modul WiFi/Bluetooth |

### 📷 Biometrik & Kamera (3 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G45 | Webcam tidak terdeteksi atau gambar tidak muncul saat video call | K22 Webcam |
| G46 | Fingerprint sensor gagal mengenali sidik jari berulang kali | K23 Fingerprint/Biometric |
| G47 | Windows Hello (face recognition) gagal login meski wajah sudah terdaftar | K23 Fingerprint/Biometric |

### 🔧 Firmware — BIOS/UEFI & Security (4 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G48 | Laptop tidak bisa masuk BIOS/UEFI sama sekali (tombol akses tidak merespons) | K24 BIOS/UEFI Corrupt |
| G49 | Muncul pesan "Secure Boot Violation" / "Secure Boot state corrupted" saat booting | K25 TPM/Secure Boot |
| G50 | Muncul pesan "TPM device not detected/not found" | K25 TPM/Secure Boot |
| G51 | BitLocker terus meminta recovery key setiap booting tanpa ada perubahan hardware | K25 TPM/Secure Boot |

### 💻 Software — OS, Update & Aplikasi (8 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G09 | Laptop sangat lambat saat membuka aplikasi | K02 HDD/SSD *atau* K16 RAM Overload SW |
| G37 | Muncul tanda seru kuning pada Device Manager | K15 Driver Bermasalah |
| G40 | Windows Update gagal terus-menerus dengan kode error | K18 Update Gagal |
| G41 | Aplikasi tertentu sering "Not Responding" atau force close | K19 Konflik Aplikasi *atau* K20 Registry |
| G42 | RAM usage di Task Manager selalu di atas 90% saat idle | K16 RAM Overload SW |
| G61 | Laptop bootloop (restart terus-menerus) setelah update Windows besar | K31 Bootloop Pasca-Update |
| G62 | Muncul BSOD dengan kode "INACCESSIBLE_BOOT_DEVICE" setelah update besar | K31 Bootloop Pasca-Update |

### 🦠 Software — Virus/Malware/Ransomware (3 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G33 | Muncul banyak iklan pop-up saat browsing atau bahkan saat offline | K14 Virus/Malware |
| G34 | File tiba-tiba hilang, terenkripsi, atau berubah ekstensi | K14 Ransomware |
| G35 | Antivirus mendeteksi ancaman berulang kali | K14 Virus/Malware |

### 🤖 AI / NPU (2 gejala)

| Kode | Gejala | → Kerusakan |
|------|--------|-------------|
| G59 | Fitur AI/Copilot+ (Recall, Windows Studio Effects, dll) error "NPU not detected" | K30 NPU Driver-Firmware Error |
| G60 | Sistem freeze khusus saat menjalankan aplikasi AI lokal/GPU-intensive | K09 Pendingin *atau* K30 NPU |

### 📊 Ringkasan Jumlah Gejala per Subsistem

| Subsistem | Jumlah Gejala |
|-----------|:-------------:|
| Power (Baterai & Charger) | 9 |
| Storage (HDD/SSD) | 6 |
| Display / Layar | 7 |
| Software (OS, Update, Aplikasi) | 7 |
| Port & Konektivitas | 7 |
| Thermal / Sistem Pendingin | 5 |
| RAM & Motherboard | 5 |
| Input Keyboard | 3 |
| Input Touchpad | 2 |
| Firmware (BIOS/UEFI/TPM) | 4 |
| Virus / Malware | 3 |
| Biometrik & Kamera | 3 |
| Audio / Speaker | 2 |
| Mekanik / Engsel | 2 |
| AI / NPU | 2 |
| **Total unik** | **66** |

> Catatan: G36 (WiFi/BT tidak terdeteksi → Driver) dan G60 (freeze AI → Pendingin/NPU) tercatat di dua subsistem karena memang dipakai di rule dengan kerusakan berbeda. Total baris tabel = 68, tapi gejala unik tetap 66.

---

## 2. Master Data Kerusakan

| Kode | Nama Kerusakan | Kategori |
|------|-----------------|----------|
| K01 | Kerusakan RAM | Hardware |
| K02 | Kerusakan Hardisk/SSD (bad sector / storage fail) | Hardware |
| K03 | Kerusakan VGA/GPU | Hardware |
| K04 | Kerusakan Motherboard (short circuit) | Hardware |
| K05 | Kerusakan Baterai (drop/aus) | Hardware |
| K06 | Kerusakan Charger/Adaptor | Hardware |
| K07 | Kerusakan Keyboard | Hardware |
| K08 | Kerusakan LCD/Layar | Hardware |
| K09 | Kerusakan Sistem Pendingin (Fan/Heatsink) | Hardware |
| K10 | Kerusakan Speaker | Hardware |
| K11 | Kerusakan Engsel (Hinge) | Hardware |
| K12 | Kerusakan Port USB/Konektor | Hardware |
| K13 | Sistem Operasi Corrupt/Rusak | Software |
| K14 | Infeksi Virus/Malware/Ransomware | Software |
| K15 | Driver Bermasalah/Tidak Kompatibel | Software |
| K16 | RAM Overload akibat Software (bukan hardware) | Software |
| K17 | Penyimpanan Penuh (Storage Overload) | Software |
| K18 | Windows Update Gagal/Corrupt | Software |
| K19 | Konflik Aplikasi/Software Crash | Software |
| K20 | Registry Windows Corrupt | Software |
| K21 | Kerusakan Touchpad | Hardware |
| K22 | Kerusakan Webcam | Hardware |
| K23 | Kerusakan Fingerprint/Biometric Sensor | Hardware |
| K24 | BIOS/UEFI Firmware Corrupt | Firmware |
| K25 | TPM/Secure Boot Corrupt | Firmware |
| K26 | Kerusakan Port Thunderbolt/USB-C | Hardware |
| K27 | Kerusakan Modul WiFi/Bluetooth | Hardware |
| K28 | Kerusakan Komponen Elektronik (Coil Whine) | Hardware |
| K29 | Burn-in Panel OLED | Hardware |
| K30 | NPU/AI Chip Driver-Firmware Error | Software |
| K31 | Update Windows Corrupt (Bootloop Pasca-Update) | Software |
| K32 | Baterai Rapid Degradation (Kegagalan Sel Dini) | Hardware |
| K33 | Kerusakan Controller SSD NVMe (Thermal Throttling) | Hardware |

> Catatan kategori: K24 dan K25 diberi kategori baru **Firmware** (bukan murni Hardware atau Software) karena BIOS/UEFI dan TPM berada di lapisan firmware — perbaikannya beda jalur dari reinstall software biasa maupun ganti komponen hardware. Kalau skema database/enum kategori di `kerusakans` table cuma punya 2 nilai (Hardware/Software), tambahkan value ketiga atau petakan sementara K24/K25 ke "Hardware" dengan sub-note di field terpisah.

---

## 3. Rule Forward Chaining

**Format:** `IF (gejala AND gejala ...) THEN kerusakan`

| Rule | Kondisi (IF) | Hasil (THEN) |
|------|--------------|---------------|
| R01 | G01 AND G04 | K04 — Kerusakan Motherboard |
| R02 | G01 AND NOT G19 AND G18 | K05 — Kerusakan Baterai |
| R03 | G02 AND G12 AND G13 | K03 — Kerusakan VGA/GPU |
| R04 | G05 OR G06 (tanpa G08) | K03 — Kerusakan VGA/GPU |
| R05 | G07 AND G08 | K08 — Kerusakan LCD/Layar |
| R06 | G03 AND G09 AND G30 | K01 — Kerusakan RAM |
| R07 | G10 AND G11 | K01 — Kerusakan RAM |
| R08 | G09 AND G39 AND G32 | K02 — Kerusakan Hardisk/SSD |
| R09 | G31 AND G32 | K02 — Kerusakan Hardisk/SSD |
| R10 | G12 AND G13 AND G14 | K09 — Kerusakan Sistem Pendingin |
| R11 | G11 AND G13 AND NOT G12 | K09 — Kerusakan Sistem Pendingin |
| R12 | G15 AND G17 | K05 — Kerusakan Baterai |
| R13 | G16 AND G19 | K06 — Kerusakan Charger |
| R14 | G16 AND G20 | K06 — Kerusakan Charger |
| R15 | G21 AND G23 | K07 — Kerusakan Keyboard |
| R16 | G22 | K07 — Kerusakan Keyboard |
| R17 | G24 AND NOT G36 | K10 — Kerusakan Speaker |
| R18 | G25 | K10 — Kerusakan Speaker |
| R19 | G26 AND G27 | K11 — Kerusakan Engsel |
| R20 | G28 | K12 — Kerusakan Port USB |
| R21 | G29 | K12 — Kerusakan Port USB |
| R22 | G32 AND NOT G31 AND NOT G39 | K13 — Sistem Operasi Corrupt |
| R23 | G33 AND G34 AND G35 | K14 — Infeksi Virus/Malware |
| R24 | G34 AND NOT G35 | K14 — Infeksi Virus/Malware (ransomware kemungkinan) |
| R25 | G36 AND G37 | K15 — Driver Bermasalah |
| R26 | G09 AND G42 AND NOT G39 | K16 — RAM Overload akibat Software |
| R27 | G38 AND G39 | K17 — Penyimpanan Penuh |
| R28 | G40 | K18 — Windows Update Gagal |
| R29 | G41 AND NOT G10 | K19 — Konflik Aplikasi/Software Crash |
| R30 | G30 AND G41 AND NOT G01 | K20 — Registry Windows Corrupt |
| R31 | G43 AND NOT G44 | K21 — Kerusakan Touchpad |
| R32 | G44 | K21 — Kerusakan Touchpad |
| R33 | G45 | K22 — Kerusakan Webcam |
| R34 | G46 | K23 — Kerusakan Fingerprint/Biometric Sensor |
| R35 | G47 | K23 — Kerusakan Fingerprint/Biometric Sensor |
| R36 | G48 | K24 — BIOS/UEFI Firmware Corrupt |
| R37 | G49 OR G50 | K25 — TPM/Secure Boot Corrupt |
| R38 | G51 AND NOT G50 | K25 — TPM/Secure Boot Corrupt |
| R39 | G52 | K26 — Kerusakan Port Thunderbolt/USB-C |
| R40 | G53 AND NOT G52 | K26 — Kerusakan Port Thunderbolt/USB-C |
| R41 | G54 | K27 — Kerusakan Modul WiFi/Bluetooth |
| R42 | G55 | K27 — Kerusakan Modul WiFi/Bluetooth |
| R43 | G56 | K28 — Kerusakan Komponen Elektronik (Coil Whine) |
| R44 | G57 | K29 — Burn-in Panel OLED |
| R45 | G58 AND NOT G57 | K15 — Driver Bermasalah (refresh rate turun akibat driver GPU) |
| R46 | G59 | K30 — NPU/AI Chip Driver-Firmware Error |
| R47 | G60 AND G13 AND NOT G59 | K09 — Kerusakan Sistem Pendingin (overheat saat beban AI/GPU) |
| R48 | G61 OR G62 | K31 — Update Windows Corrupt (Bootloop Pasca-Update) |
| R49 | G63 AND NOT G64 | K06 — Kerusakan Charger/Adaptor (fast charging PD gagal nego) |
| R50 | G64 AND NOT G63 | K32 — Baterai Rapid Degradation |
| R51 | G65 AND NOT G66 | K02 — Kerusakan Hardisk/SSD |
| R52 | G66 | K33 — Kerusakan Controller SSD NVMe (Thermal Throttling) |

Catatan: kondisi `NOT` dipakai untuk membedakan kerusakan dengan gejala yang overlap (misal G12+G13 bisa mengarah ke VGA atau ke sistem pendingin — dibedakan lewat kombinasi gejala tambahan). Sesuaikan lagi berdasar hasil wawancara dengan teknisi (expert validation). Rule tambahan (R31–R52) mengikuti pola yang sama: R37 pakai operator `OR` (seperti R04), sedangkan R31, R38, R40, R45, R47, R49, R50, R51 pakai `NOT` untuk memisahkan kerusakan yang gejalanya mirip (mis. G63 fast charging lambat vs G64 baterai drop permanen — dua-duanya bisa membuat "laptop lama nge-cas", tapi penyebab dan solusinya beda jalur).

---

## 4. Detail Kerusakan: Penyebab & Solusi

### K01 — Kerusakan RAM
- **Penyebab:** Modul RAM kotor/kendor di slot, RAM rusak fisik, ketidakcocokan RAM dual-channel, RAM usia pakai lama.
- **Solusi:** Bersihkan pin RAM dengan penghapus karet, cek dengan aplikasi MemTest86, coba pasang di slot lain, ganti modul RAM jika rusak permanen.

### K02 — Kerusakan Hardisk/SSD
- **Penyebab:** Bad sector, usia pakai, kerusakan fisik akibat guncangan (HDD), kegagalan controller SSD.
- **Solusi:** Backup data segera, cek dengan CrystalDiskInfo/HDDScan, jalankan CHKDSK, ganti ke SSD baru jika bad sector parah.

### K03 — Kerusakan VGA/GPU
- **Penyebab:** Overheat berkepanjangan, thermal paste kering, chip GPU retak solder (kasus umum laptop gaming lama).
- **Solusi:** Reflow/reball chip GPU oleh teknisi, ganti thermal paste, pastikan ventilasi tidak tertutup, update driver GPU.

### K04 — Kerusakan Motherboard
- **Penyebab:** Korsleting akibat cairan masuk, komponen VRM/capacitor rusak, kerusakan akibat lonjakan listrik.
- **Solusi:** Bawa ke teknisi untuk pengecekan jalur PCB, ganti komponen yang short, dalam kasus parah motherboard perlu diganti.

### K05 — Kerusakan Baterai
- **Penyebab:** Siklus charge sudah tinggi (health menurun), sel baterai kembung/aus, kalibrasi baterai salah.
- **Solusi:** Cek battery health lewat `powercfg /batteryreport` (Windows), kalibrasi ulang, ganti baterai jika health di bawah 50%.

### K06 — Kerusakan Charger/Adaptor
- **Penyebab:** Kabel putus di dalam, adaptor rusak akibat korsleting, konektor DC jack aus.
- **Solusi:** Cek output tegangan dengan multimeter, ganti kabel/adaptor, servis DC jack di motherboard bila konektor yang bermasalah.

### K07 — Kerusakan Keyboard
- **Penyebab:** Debu/kotoran menyumbat mekanisme tombol, cairan tumpah, konektor keyboard ke motherboard longgar.
- **Solusi:** Bersihkan dengan compressed air, lepas-pasang konektor keyboard, ganti keyboard jika membrane rusak, sementara gunakan keyboard eksternal.

### K08 — Kerusakan LCD/Layar
- **Penyebab:** Benturan fisik, panel LCD pecah, kabel fleksibel LCD kendor/putus.
- **Solusi:** Ganti panel LCD, cek dan pasang ulang kabel fleksibel, hindari tekanan pada layar saat ditutup.

### K09 — Kerusakan Sistem Pendingin
- **Penyebab:** Kipas kotor berdebu, bearing kipas aus, thermal paste kering, ventilasi tersumbat.
- **Solusi:** Bongkar dan bersihkan kipas/heatsink, ganti thermal paste, ganti kipas jika bunyi kasar/putaran tidak stabil.

### K10 — Kerusakan Speaker
- **Penyebab:** Membran speaker rusak, konektor audio longgar, kerusakan chip audio.
- **Solusi:** Cek pengaturan audio driver dulu, pasang ulang konektor speaker, ganti unit speaker jika membran robek.

### K11 — Kerusakan Engsel (Hinge)
- **Penyebab:** Pemakaian jangka panjang, sering dibuka-tutup kasar, baut engsel kendor/patah.
- **Solusi:** Kencangkan/ganti baut engsel, ganti unit hinge jika sudah retak di casing.

### K12 — Kerusakan Port USB
- **Penyebab:** Pin port bengkok/patah, solder port lepas dari motherboard, port aus akibat pemakaian.
- **Solusi:** Cek fisik port dari kotoran/pin bengkok, solder ulang jika lepas, ganti port oleh teknisi.

### K13 — Sistem Operasi Corrupt
- **Penyebab:** File sistem rusak akibat mati mendadak saat update, bad sector di partisi sistem, crash saat instalasi.
- **Solusi:** Jalankan Startup Repair, gunakan `sfc /scannow`, repair install Windows, install ulang jika sudah parah.

### K14 — Infeksi Virus/Malware
- **Penyebab:** Download file dari sumber tidak terpercaya, flashdisk terinfeksi, celah keamanan browser.
- **Solusi:** Scan penuh dengan Windows Defender/Malwarebytes, putuskan koneksi internet saat scan, restore dari backup jika file terenkripsi (ransomware), jangan bayar tebusan.

### K15 — Driver Bermasalah
- **Penyebab:** Driver belum terinstall, driver corrupt setelah update Windows, driver tidak kompatibel dengan versi OS.
- **Solusi:** Cek Device Manager, uninstall lalu install ulang driver dari situs resmi vendor, gunakan Windows Update untuk driver otomatis.

### K16 — RAM Overload akibat Software
- **Penyebab:** Terlalu banyak aplikasi berjalan di background, startup program berlebihan, memory leak dari aplikasi tertentu.
- **Solusi:** Matikan startup program tidak perlu lewat Task Manager, tutup aplikasi background, upgrade RAM jika kebutuhan memang tinggi.

### K17 — Penyimpanan Penuh
- **Penyebab:** File temporary menumpuk, cache aplikasi besar, tidak ada disk cleanup rutin.
- **Solusi:** Jalankan Disk Cleanup, hapus file temporary, uninstall aplikasi tak terpakai, pindahkan file besar ke storage eksternal/cloud.

### K18 — Windows Update Gagal
- **Penyebab:** File update corrupt, komponen Windows Update service bermasalah, ruang penyimpanan tidak cukup.
- **Solusi:** Jalankan Windows Update Troubleshooter, reset komponen update via Command Prompt, pastikan ruang kosong minimal 20GB.

### K19 — Konflik Aplikasi/Software Crash
- **Penyebab:** Aplikasi tidak kompatibel dengan versi OS, dua aplikasi rebutan resource, aplikasi corrupt saat instalasi.
- **Solusi:** Update aplikasi ke versi terbaru, reinstall aplikasi bermasalah, cek Event Viewer untuk detail error.

### K20 — Registry Windows Corrupt
- **Penyebab:** Instalasi/uninstall software tidak bersih, crash sistem saat menulis registry, malware yang mengubah registry.
- **Solusi:** Gunakan System Restore ke titik sebelumnya, scan dengan CCleaner registry cleaner (hati-hati), repair install Windows jika parah.

### K21 — Kerusakan Touchpad
- **Penyebab:** Driver touchpad corrupt/belum update, kabel flex touchpad kendor, debu/kelembaban di bawah panel, chip controller touchpad rusak, atau tidak sengaja ter-disable lewat kombinasi tombol Fn.
- **Solusi:** Cek toggle Fn+touchpad dan Settings > Bluetooth & devices > Touchpad, update driver precision touchpad lewat Device Manager, buka casing dan cek konektor flex, ganti unit touchpad jika fisik rusak, sementara gunakan mouse eksternal.

### K22 — Kerusakan Webcam
- **Penyebab:** Driver webcam belum terinstall/corrupt, izin privasi kamera di-nonaktifkan di Windows Settings, kabel fleksibel webcam ke motherboard longgar, modul kamera fisik rusak.
- **Solusi:** Cek Settings > Privacy & Security > Camera pastikan aplikasi diizinkan akses, update/reinstall driver kamera, cek tanda seru di Device Manager, buka casing untuk cek konektor bila masalah berlanjut, ganti modul kamera jika rusak fisik.

### K23 — Kerusakan Fingerprint/Biometric Sensor
- **Penyebab:** Sensor kotor oleh debu/minyak tangan, driver biometric corrupt, data enrollment Windows Hello corrupt, kabel sensor longgar, chip sensor rusak fisik.
- **Solusi:** Bersihkan permukaan sensor, hapus dan daftar ulang sidik jari/wajah lewat Settings > Accounts > Sign-in options, update driver biometric via Windows Update, reset TPM (`tpm.msc`) jika Windows Hello tetap gagal, ganti modul sensor bila rusak fisik.

### K24 — BIOS/UEFI Firmware Corrupt
- **Penyebab:** Update BIOS terputus di tengah proses (mati listrik/baterai habis saat flashing), firmware corrupt akibat serangan malware level-firmware, chip BIOS rusak fisik.
- **Solusi:** Coba BIOS recovery mode (kombinasi tombol khusus vendor, umumnya Fn+Esc atau Fn+B saat power on), flash ulang BIOS pakai USB recovery dari situs resmi vendor, bawa ke teknisi untuk reflash chip BIOS via programmer eksternal jika recovery mode gagal total.

### K25 — TPM/Secure Boot Corrupt
- **Penyebab:** Pengaturan Secure Boot/TPM berubah tidak sengaja di BIOS, proses update Windows besar (24H2/25H2/26H2) menyentuh konfigurasi sertifikat Secure Boot, baterai CMOS habis sehingga setting BIOS reset ke default, firmware TPM corrupt.
- **Solusi:** Masuk BIOS dan aktifkan kembali TPM 2.0 & Secure Boot, pastikan sudah menerima update sertifikat Secure Boot terbaru lewat Windows Update (Microsoft sedang bertahap me-rollout sertifikat baru di laptop-laptop lama menjelang masa berlaku sertifikat lama habis), simpan BitLocker recovery key dari akun Microsoft sebelum melakukan update besar, reset TPM lewat `tpm.msc` bila perlu, ganti baterai CMOS kalau setting BIOS terus-menerus reset sendiri.

### K26 — Kerusakan Port Thunderbolt/USB-C
- **Penyebab:** Kabel/konektor USB-C aus akibat pemakaian intensif, controller Thunderbolt di motherboard rusak, debu/kotoran menyumbat port, pin port longgar akibat sering dipakai untuk beban daya (Power Delivery) tinggi.
- **Solusi:** Cek dengan kabel & charger lain untuk isolasi masalah, bersihkan port dari debu pakai udara bertekanan, update driver/firmware Thunderbolt lewat tool resmi Intel/vendor, servis solder ulang port oleh teknisi jika kontak fisik lepas dari motherboard.

### K27 — Kerusakan Modul WiFi/Bluetooth
- **Penyebab:** Driver wireless corrupt/belum update, modul WiFi card kendor di slot M.2, interferensi sinyal dari perangkat lain, kerusakan fisik antena atau modul kombo WiFi-Bluetooth.
- **Solusi:** Update driver wireless dari situs resmi vendor chipset (Intel/Qualcomm/MediaTek), cek tanda seru di Device Manager, buka casing dan pastikan modul WiFi terpasang rapat di slot M.2 serta kabel antena tersambung dengan benar, ganti modul WiFi/Bluetooth jika rusak permanen.

### K28 — Kerusakan Komponen Elektronik (Coil Whine)
- **Penyebab:** Induktor/capacitor pada jalur VRM bergetar akibat frekuensi switching tinggi saat beban CPU/GPU naik, kualitas komponen power delivery kurang baik — umumnya bukan kerusakan berbahaya, tapi indikasi power delivery kurang stabil.
- **Solusi:** Batasi frame rate/power limit lewat software (mis. cap FPS saat gaming) untuk mengurangi beban VRM, update BIOS untuk power management yang lebih baik, kalau bunyi sangat mengganggu dan disertai gejala lain (panas berlebih, restart mendadak), bawa ke teknisi untuk cek jalur VRM.

### K29 — Burn-in Panel OLED
- **Penyebab:** Menampilkan gambar statis (taskbar, logo, watermark) dalam durasi sangat lama tanpa jeda, brightness terlalu tinggi terus-menerus, karakteristik alami degradasi sub-pixel OLED seiring usia pemakaian.
- **Solusi:** Aktifkan fitur pixel refresh/anti burn-in bawaan vendor, gunakan wallpaper dinamis dan auto-hide taskbar, turunkan brightness ke level wajar, kalau burn-in sudah parah dan mengganggu, panel OLED perlu diganti (biaya jauh lebih tinggi dibanding panel LCD biasa).

### K30 — NPU/AI Chip Driver-Firmware Error
- **Penyebab:** Driver NPU belum terinstall/corrupt, firmware chip AI (mis. Intel Core Ultra 200V, AMD Ryzen AI 300, Snapdragon X series) belum update, aplikasi AI/Copilot+ tidak kompatibel dengan versi Windows terpasang, konflik antara driver NPU dan driver GPU.
- **Solusi:** Update driver NPU lewat Windows Update atau situs resmi vendor chipset, pastikan Windows 11 sudah di versi 24H2/25H2 ke atas (syarat minimum fitur Copilot+), cek di Settings > System > About apakah prosesor memenuhi syarat Copilot+ PC (NPU ≥40 TOPS, RAM ≥16GB, storage ≥256GB — standar resmi Microsoft), reinstall aplikasi AI yang bermasalah, hubungi support vendor bila firmware NPU corrupt total.

### K31 — Update Windows Corrupt (Bootloop Pasca-Update)
- **Penyebab:** Update fitur besar (24H2/25H2/26H2) terputus di tengah instalasi, driver storage tidak kompatibel dengan build baru, file sistem korup saat proses update menulis ulang boot configuration.
- **Solusi:** Masuk Windows Recovery Environment (WinRE) lewat restart paksa 3x berturut-turut, gunakan opsi "Uninstall Updates" untuk rollback ke build sebelumnya, jalankan Startup Repair, kalau masih gagal jalankan `bootrec /rebuildbcd` lewat Command Prompt di recovery mode, langkah terakhir reset PC dengan opsi "Keep my files".

### K32 — Baterai Rapid Degradation (Kegagalan Sel Dini)
- **Penyebab:** Cacat produksi pada batch sel baterai, sering dibiarkan di suhu tinggi (mis. di dalam mobil/kena sinar matahari langsung), kebiasaan charging 0%–100% penuh terus-menerus tanpa manajemen charging pintar, firmware Battery Management System (BMS) bermasalah.
- **Solusi:** Cek battery report (`powercfg /batteryreport`) untuk bandingkan design capacity vs full charge capacity, aktifkan fitur battery care/charge limit (biasanya di BIOS atau software vendor, umumnya membatasi charging di 80%), ajukan klaim garansi kalau drop drastis terjadi kurang dari 1 tahun pemakaian (tergolong cacat produk), ganti baterai kalau sudah di luar masa garansi.

### K33 — Kerusakan Controller SSD NVMe (Thermal Throttling)
- **Penyebab:** SSD NVMe tanpa heatsink di slot M.2 yang berdekatan dengan CPU/GPU, thermal pad SSD tidak terpasang dari pabrik, ventilasi laptop buruk, beban baca/tulis berat berkepanjangan (video editing, transfer file besar).
- **Solusi:** Pasang heatsink/thermal pad tambahan pada SSD NVMe, cek suhu SSD lewat CrystalDiskInfo, pastikan sirkulasi udara laptop baik (bersihkan kipas & ventilasi secara berkala), kurangi beban baca/tulis berkepanjangan, kalau performa tetap drop signifikan meski suhu sudah normal, kemungkinan controller SSD sudah aus dan perlu diganti unit.

---

## 5. Catatan Implementasi untuk Agent AI / Developer

- Tabel di atas adalah **contoh isi awal knowledge base**, bukan final. Jumlah gejala/kerusakan/rule harus divalidasi ulang dengan teknisi ahli (expert validation) sesuai kebutuhan riset LapTech Diagnosa.
- Struktur ini mengasumsikan rule bisa punya operator `AND`/`OR`/`NOT` sederhana. Kalau mesin Forward Chaining di Laravel cuma dukung `AND` murni tanpa `NOT`/`OR`, rule R02, R04, R11, R17, R22, R24, R26, R29, R30, R31, R37, R38, R40, R45, R47, R49, R50, R51 perlu ditulis ulang jadi kombinasi gejala positif saja — sebutkan ke agent AI batasan ini sebelum coding.
- Belum ada Certainty Factor (CF)/bobot di sini — tambahkan kolom CF per gejala-rule kalau metodologi skripsi memutuskan pakai CF.
- Simpan sebagai referensi seeder database (`gejalas`, `kerusakans`, `rules`, `rule_gejala` pivot table) — jangan hardcode di controller, sesuai PRD section 5.3.

### Changelog — Update Agustus 2026 (data real terkini)
- Ditambahkan **24 gejala baru** (G43–G66), **13 kerusakan baru** (K21–K33), dan **22 rule baru** (R31–R52) untuk mencakup kasus-kasus laptop modern yang relevan per 2026: touchpad/webcam/fingerprint, BIOS/UEFI & Secure Boot/TPM, port Thunderbolt/USB-C & PD charging, WiFi/Bluetooth module, coil whine, panel OLED burn-in & refresh rate tinggi, NPU/AI chip (Copilot+ PC), bootloop pasca-update Windows, degradasi baterai dini, dan thermal throttling SSD NVMe.
- Kategori kerusakan bertambah satu nilai baru: **Firmware** (dipakai K24, K25), di luar Hardware/Software yang sudah ada — pastikan skema/enum kategori di database diupdate sebelum seeding.
- Konteks data dicek ulang terhadap kondisi aktual per Agustus 2026: versi Windows 11 yang beredar adalah **25H2** (build 26200-an), dengan **26H2** dijadwalkan rilis akhir 2026 sebagai *enablement package* ringan (bukan update besar terpisah) — jadi baik 24H2 maupun 25H2/26H2 relevan untuk skenario G61/G62/K31. Standar **Copilot+ PC** dari Microsoft: NPU minimal 40 TOPS, RAM minimal 16GB, storage minimal 256GB SSD, dengan chip yang memenuhi antara lain Snapdragon X Elite/Plus, Intel Core Ultra 200V series, dan AMD Ryzen AI 300 series — jadi dasar gejala G59/G60 dan kerusakan K30.
- Rekomendasi: saat wawancara expert validation ke teknisi laptop, tanyakan juga seberapa sering mereka menemui kasus-kasus baru ini di lapangan (mis. Secure Boot/TPM error pasca-update, SSD NVMe overheat tanpa heatsink) — kalau jarang ditemukan di segmen laptop yang ditangani mitra riset (biasanya laptop entry-mid range), rule-rule ini bisa diberi prioritas lebih rendah atau digabung dengan kategori lama supaya knowledge base tidak terlalu bengkak untuk skripsi.