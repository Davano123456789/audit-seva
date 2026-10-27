# Sistem Pengukuran Capability Level COBIT 2019

Sistem pengukuran **capability level** dan **maturity level** tata kelola TI pada aspek keamanan TI berdasarkan kerangka kerja **COBIT 2019**.

Nama sistem diatur lewat `APP_NAME` di `.env`.

Ruang lingkup: 3 domain (APO, BAI, DSS) dan 6 proses TI, yaitu APO07, APO12, APO13, APO14, BAI09, dan DSS05. Totalnya 233 pertanyaan kuesioner untuk level 2 sampai 5.

## Kebutuhan

- PHP 8.1 atau lebih baru (diuji dengan PHP 8.3 di Laragon)
- MySQL 8
- Composer

## Instalasi

```bash
composer install
cp .env.example .env        # lalu atur DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan key:generate
php artisan migrate --seed  # membuat tabel + data COBIT + 233 pertanyaan + akun awal
php artisan storage:link    # agar file bukti & foto profil bisa dibuka
php artisan serve
```

Buka `http://127.0.0.1:8000`.

### Akun awal

| Role   | Email                  | Password   |
|--------|------------------------|------------|
| Admin  | admin@ptxyz.com       | `password` |
| Asesor | asesor@ptxyz.com      | `password` |

Segera ganti password lewat menu **Profil Saya**.

## Alur penggunaan

1. **Admin** mengelola data master: domain, proses TI, praktik, pertanyaan, dan pengguna.
2. **Admin** membuat proyek audit: memilih asesor, memilih proses TI, dan menentukan target level.
3. **Asesor** menilai setiap proses mulai dari Level 2. Setiap aktivitas dijawab **Ya/Tidak**, dan asesor bisa menambahkan catatan serta file bukti.
4. Sistem menghitung capability level setiap proses, lalu maturity level proyek.
5. **Laporan** dapat dilihat dan dicetak/disimpan sebagai PDF oleh admin maupun asesor pemilik proyek.

## Aturan penilaian

Persentase capaian per level:

```
Capaian = jumlah jawaban Ya / jumlah pertanyaan x 100%
```

| Rating | Kategori           | Rentang     | Keputusan                                |
|--------|--------------------|-------------|------------------------------------------|
| F      | Fully Achieved     | 85% - 100%  | Level lulus, lanjut ke level berikutnya  |
| L      | Largely Achieved   | 50% - < 85% | Berhenti, capability = level ini         |
| P      | Partially Achieved | 15% - < 50% | Berhenti, capability = level sebelumnya  |
| N      | Not Achieved       | 0% - < 15%  | Berhenti, capability = level sebelumnya  |

Level yang tidak memiliki pertanyaan dilewati. Contohnya APO07 dan DSS05 yang tidak punya Level 5.

Maturity level proyek:

```
Maturity = jumlah capability level proses / jumlah proses
```

Hasilnya dibulatkan dengan tabel indeks berikut:

| Index       | Level |
|-------------|-------|
| 0,00 – 0,50 | 0     |
| 0,51 – 1,50 | 1     |
| 1,51 – 2,50 | 2     |
| 2,51 – 3,50 | 3     |
| 3,51 – 4,50 | 4     |
| 4,51 – 5,00 | 5     |

Contoh: (3 + 3 + 3 + 3 + 2 + 3) / 6 = 2,83, sehingga hasilnya **Level 3 (Established Process)**.

Semua angka di atas (nama level, batas rating, dan tabel pembulatan) disimpan di `config/cobit.php`.

## Struktur penting

```
app/
├── Services/
│   ├── CapabilityAssessor.php   # logika perhitungan capability & maturity
│   └── AuditReport.php          # penyusun data laporan
├── Http/Controllers/
│   ├── Master/                  # CRUD domain, proses, praktik, pertanyaan, pengguna
│   ├── Audit/                   # proyek audit (admin)
│   ├── Penilaian/               # ruang kerja penilaian (asesor)
│   └── Laporan/                 # laporan & cetak
└── Http/Requests/               # aturan validasi form
config/cobit.php                 # nama level, skala rating, tabel maturity
database/seeders/
├── CobitSeeder.php              # 3 domain, 6 proses, 37 praktik
├── QuestionSeeder.php           # 233 pertanyaan
└── data/                        # questions.php + file Excel sumber kuesioner
resources/views/
├── layouts/                     # app, guest, print + partials (sidebar, topbar, dll.)
├── components/                  # komponen tampilan yang dipakai ulang
├── master/  audit/  penilaian/  laporan/  dashboard/  profil/  errors/
```
