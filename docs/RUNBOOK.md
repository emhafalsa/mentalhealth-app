# Runbook Lokal

**Status:** panduan operasional pengembangan.
**Tanggal dicatat:** 21 Oktober 2026.

## 1. Menyiapkan database

Database aplikasi: `mental_health_research`.
Database pengujian: `mental_health_research_test`.

Jika MySQL tidak berjalan sebagai service, jalankan instance MySQL 8.4 secara manual, lalu periksa koneksi:

```powershell
mysqladmin -h 127.0.0.1 -P 3306 -u root ping
```

Jika folder Laravel berada di OneDrive dan muncul error izin tulis:

```powershell
attrib -R bootstrap\cache /S /D
attrib -R storage /S /D
```

## 2. Menyiapkan aplikasi

```powershell
composer install
npm install
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=Dass21InstrumentSeeder --force
php artisan admin:create
```

Perintah `admin:create` meminta nama, email, dan password admin. Jangan memakai password contoh atau menyimpannya di repository.

## 3. Menjalankan server

Terminal pertama:

```powershell
npm run dev
```

Terminal kedua:

```powershell
php artisan serve
```

Alamat:

- Publik: `http://localhost:8000`
- Login admin: `http://localhost:8000/login`
- Persiapan penelitian: `http://localhost:8000/admin/setup`
- Data responden: `http://localhost:8000/admin/submissions`
- Formulir peserta: `http://localhost:8000/kuesioner`

## 4. Membuka formulir penelitian

Formulir tetap tertutup sampai semua kondisi berikut benar:

- instrumen DASS-21 aktif dan memiliki 21 teks butir;
- teks persetujuan aktif tanpa placeholder;
- rentang lahir operasional 1997–2008;
- usia minimum 18 dan metode verifikasi usia dipilih;
- definisi wilayah penelitian diisi;
- mode akses peserta bukan publik dan kredensialnya tersedia;
- status etik dikonfirmasi;
- masa retensi dan prosedur penghapusan diisi;
- fitur dukungan sosial tetap nonaktif sampai instrumennya terverifikasi.

Gunakan **Persiapan penelitian** untuk melihat daftar penghambat. Jangan mengaktifkan instrumen atau consent hanya untuk menghilangkan peringatan.

## 5. Akses peserta

### Tautan peserta

Pilih mode **Tautan khusus peserta**, lalu simpan pengaturan. Tautan bertanda tangan berlaku 7 hari dan ditampilkan di halaman persiapan setelah penelitian siap. Sesi akses peserta berlaku 4 jam.

### Kode akses

Pilih mode **Kode akses peserta** atau **Kelompok penelitian terbatas**, lalu isi kode akses minimal 6 karakter. Kode disimpan sebagai hash dan tidak dapat dilihat kembali. Bagikan kode hanya kepada peserta.

## 6. Data dan ekspor

- `/admin/submissions` hanya dapat diakses admin.
- Ekspor CSV memuat data berstatus `valid` dan memiliki `age_at_submission`.
- Kolom ekspor: usia, kecamatan, pendidikan, pekerjaan, durasi tidur, aktivitas fisik, media sosial, dan tiga label DASS-21.
- Kecamatan bersifat opsional; sel kosong berarti responden tidak mengisinya.
- Baris tanpa usia tidak diekspor agar tidak memberi fitur usia yang tidak diketahui.
- Jangan memakai CSV ini untuk klaim performa sebelum eksperimen dan metodologi disetujui.

## 7. Pemeriksaan wajib

```powershell
php artisan test
php vendor/bin/pint --test
npm run build
```

Hasil terakhir: 54 tes lulus, 307 assertion; Pint dan Vite build lulus.

## 8. Pemecahan masalah

- **Formulir tertutup:** buka `/admin/setup`, baca daftar penghambat, dan lengkapi input penelitian.
- **Tautan peserta kedaluwarsa:** buat tautan baru dari halaman persiapan.
- **Kode akses lupa:** isi kode baru di pengaturan; kode lama tidak dapat dipulihkan.
- **Data responden kosong:** belum ada pengiriman riil; jangan menambahkan data palsu.
- **Gagal migrasi karena izin:** jalankan perintah `attrib` di atas, lalu ulangi.
- **Aset tampilan tidak muncul:** jalankan `npm run build` atau pastikan `npm run dev` aktif.

## 9. Belum tersedia

Pelatihan dan evaluasi Random Forest belum diimplementasikan. Tahap itu memerlukan dataset riil, keputusan target/label, fitur final, pembagian data, dan metrik evaluasi yang disetujui.
