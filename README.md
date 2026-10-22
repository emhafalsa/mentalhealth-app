# Klasifikasi Mental Health Gen Z Wonosobo

Aplikasi Laravel untuk penelitian klasifikasi mental health menggunakan DASS-21 dan algoritma Random Forest pada Generasi Z di Kabupaten Wonosobo.

## Batas penelitian

- Tidak ada registrasi publik; area admin hanya untuk peneliti.
- Formulir responden hanya dibuka melalui tautan atau kode peserta.
- Skor dan kategori DASS-21 tidak ditampilkan kepada responden dan bukan diagnosis.
- Jangan mengaktifkan formulir atau mengumpulkan data nyata sebelum teks persetujuan, prosedur etik, metode verifikasi usia, dan instrumen disetujui peneliti/dosen pembimbing.
- Jangan membuat data responden sintetis untuk mengisi dashboard produksi.

Status input yang masih diperlukan ada di [`docs/PENDING_RESEARCH_INPUTS.md`](docs/PENDING_RESEARCH_INPUTS.md).

## Kebutuhan

- PHP 8.3+
- Composer
- Node.js 22+
- MySQL 8+
- Python 3.13+ hanya diperlukan untuk tahap pemodelan berikutnya

## Menjalankan aplikasi

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Sesuaikan koneksi database di `.env`:

```dotenv
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mental_health_research
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi dan seeder instrumen:

```bash
php artisan migrate --force
php artisan db:seed --class=Dass21InstrumentSeeder --force
```

Buat akun admin lokal:

```bash
php artisan admin:create
```

Jalankan server:

```bash
npm run dev
php artisan serve
```

Buka `http://localhost:8000`. Dashboard admin: `http://localhost:8000/login`.

## Alur kesiapan

1. Masuk admin, buka **Persiapan penelitian**.
2. Isi pengaturan penelitian, kriteria usia, akses peserta, etik, retensi, dan prosedur penghapusan.
3. Periksa instrumen DASS-21. Seeder sudah memuat 21 butir, tetapi statusnya `pending_verification`.
4. Buat/verifikasi consent tanpa placeholder.
5. Aktifkan instrumen dan consent secara terpisah setelah disetujui.
6. Formulir `/kuesioner` baru terbuka jika seluruh gerbang siap.
7. Data responden dan ekspor dataset tersedia di **Data responden**.

## Pengujian

```bash
php artisan test
php vendor/bin/pint --test
npm run build
```

## Dokumentasi

- [`docs/DECISIONS.md`](docs/DECISIONS.md) — keputusan metodologi awal.
- [`docs/PENDING_RESEARCH_INPUTS.md`](docs/PENDING_RESEARCH_INPUTS.md) — input penelitian yang masih diperlukan.
- [`docs/INSTRUMENT_LIFECYCLE.md`](docs/INSTRUMENT_LIFECYCLE.md) — status instrumen dan gerbang aktivasi.
- [`docs/SOURCES.md`](docs/SOURCES.md) — sumber instrumen dan referensi.
- [`docs/RUNBOOK.md`](docs/RUNBOOK.md) — langkah operasional lokal.
