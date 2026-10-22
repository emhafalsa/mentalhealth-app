# Progres Penelitian dan Implementasi

**Status terakhir:** 22 Oktober 2026.
**Tahap saat ini:** penyelarasan implementasi dengan keputusan penelitian.
**Cakupan pembaruan terakhir:** kode, migrasi, pengujian, dan dokumentasi. Tidak ada aktivasi instrumen, pengumpulan data nyata, atau pelatihan model.

---

## 1. Ringkasan status

- Aplikasi Laravel untuk penelitian DASS-21 dan Random Forest sudah tersedia secara teknis.
- Formulir responden, area admin, penyimpanan skor, dan ekspor CSV sudah diimplementasikan.
- Formulir tetap **tertutup** dan instrumen DASS-21 tetap berstatus `pending_verification`.
- Keputusan metodologi utama sudah dicatat pada `docs/DECISIONS.md`.
- Input yang masih harus dilengkapi sudah dipisahkan pada `docs/PENDING_RESEARCH_INPUTS.md`.
- Alur consent lima tahap, penyimpanan kecamatan opsional, metode verifikasi usia awal, dan penguatan gerbang MSPSS sudah diselaraskan ke kode.
- Pengumpulan data nyata dan pelatihan Random Forest belum dimulai.

---

## 2. Implementasi teknis yang sudah selesai

- Laravel 13.38.0, PHP 8.3.30, Node 22.22.0, MySQL 8.4.3, Blade/Tailwind/Alpine/Vite.
- Autentikasi admin tanpa registrasi publik.
- Pengaturan penelitian melalui `/admin/setup`.
- Audit log untuk perubahan pengaturan, versi instrumen, dan consent.
- Gerbang kesiapan penelitian melalui `ResearchReadinessService`.
- Penskoran DASS-21 melalui `Dass21Scorer`.
- Pengelolaan instrumen dengan status verifikasi dan consent dengan lima tahap alur kerja.
- Akses peserta melalui tautan bertanda tangan atau kode akses; sesi 4 jam.
- Alur responden:
  - akses tertutup;
  - persetujuan;
  - kelayakan;
  - formulir DASS-21 dan faktor pendukung;
  - penyimpanan skor;
  - konfirmasi tanpa menampilkan hasil.
- Area admin data responden di `/admin/submissions`.
- Ekspor CSV dataset valid, termasuk kolom kecamatan.
- Verifikasi usia awal memakai tahun lahir dan deklarasi usia, dengan pemeriksaan selisih maksimal satu tahun.
- Penyimpanan kecamatan opsional dengan label dari 15 kecamatan Kabupaten Wonosobo.
- Gerbang MSPSS menolak aktivasi jika fitur dukungan sosial aktif atau dijadikan fitur model.
- Seeder DASS-21 memuat 21 butir dari sumber Damanik sebagai `pending_verification`; tidak aktif.

---

## 3. Dokumentasi dan keputusan yang sudah dicatat

### 3.1 DASS-21

- Kandidat utama: terjemahan Evelina Damanik dari situs resmi DASS.
- Sumber resmi: halaman Indonesian, halaman Damanik, FAQ, dan halaman unduhan DASS.
- DASS-21 adalah alat skrining, bukan diagnosis.
- Skor, kategori, dan interpretasi tidak ditampilkan kepada responden.
- Skor akhir = skor mentah × 2.
- Pemetaan nomor butir dan aturan penskoran sudah dicatat tanpa menyalin teks butir.
- Ambang kategori masih **sementara** dan belum boleh dikunci sebagai final.

### 3.2 Populasi dan usia

- Generasi Z BPS: lahir 1997–2012.
- Batas operasional penelitian: lahir 1997–2008.
- Usia minimum: 18 tahun saat persetujuan dan partisipasi.
- Verifikasi awal: tahun lahir + deklarasi usia.
- Tidak meminta KTP atau tanggal lahir lengkap kecuali diperlukan dan disetujui.

### 3.3 Wilayah

- Wilayah: Kabupaten Wonosobo, Jawa Tengah.
- 15 kecamatan sudah dicatat.
- Kecamatan bersifat opsional.
- Tidak ada klaim keterwakilan seluruh kabupaten.
- Tidak mengumpulkan alamat lengkap tanpa kebutuhan yang disetujui.

### 3.4 Consent dan etika

- Alur status consent lima tahap sudah ditetapkan dan dipetakan ke `ConsentStatus`:
  - `draft`;
  - `incomplete` (menunggu kelengkapan);
  - `pending_ethics` (menunggu verifikasi etik);
  - `ready_for_review` (siap ditinjau);
  - `approved_for_use` (disetujui untuk digunakan).
- Consent final belum tersedia karena placeholder identitas, institusi, kontak, etik, retensi, dan penghapusan belum lengkap.
- Status etik **belum dikonfirmasi**; peneliti harus bertanya kepada dosen pembimbing/institusi.
- Tidak ada nomor etik atau klaim ethical approval yang dibuat.

### 3.5 MSPSS

- MSPSS Bahasa Indonesia adalah kandidat, bukan instrumen final.
- Artikel validasi awal: Sulistiani, Fajrianthi, & Kristiana (2022), DOI `10.14710/jp.21.1.89-103`.
- Teks, skoring, sumber item, dan hak reproduksi belum diverifikasi.
- Dukungan sosial harus nonaktif sampai verifikasi selesai.

### 3.6 Dataset dan model

- Dataset utama berasal dari pengumpulan primer website.
- Data sintetis tidak boleh tampil sebagai data penelitian nyata.
- Tiga target terpisah: `label_depresi`, `label_kecemasan`, `label_stres`.
- DASS-21, skor subskala, atau label yang sama tidak boleh menjadi fitur untuk target yang sama.
- Pelatihan Random Forest diblokir sampai audit dataset, jumlah sampel, distribusi kelas, split/validasi, fitur, dan metrik disetujui.
- Tidak ada metrik, confusion matrix, atau hasil model yang dibuat.

---

## 4. Verifikasi sumber

Diperiksa pada 21 Oktober 2026:

- `https://dass.psy.unsw.edu.au/Indonesian/Indonesian.htm`
  - Halaman resmi mencantumkan terjemahan Damanik dan Potangaroa.
- `https://dass.psy.unsw.edu.au/Indonesian/Damanik.htm`
  - Mencantumkan Evelina Damanik sebagai penerjemah dan menyatakan urutan butir mengikuti DASS Inggris.
- `https://dass.psy.unsw.edu.au/DASSFAQ.htm`
  - Membatasi penggunaan website/aplikasi untuk kelompok penelitian; hasil untuk peneliti.
- `https://dass.psy.unsw.edu.au/down.htm`
  - Menyediakan formulir respons DASS21 dan lembar skoring; formulir boleh diunduh/disalin, tetapi skala tidak boleh dimodifikasi atau dijual untuk profit.
- `https://website.wonosobokab.go.id/page/geografis-kabupaten-wonosobo`
  - Mencantumkan 15 kecamatan Kabupaten Wonosobo.
- `https://doi.org/10.14710/jp.21.1.89-103`
  - Metadata artikel validasi MSPSS versi Indonesia.

Catatan: verifikasi metadata sumber belum sama dengan persetujuan akhir atas redaksi, ambang, atau kelayakan penggunaan instrumen.

---

## 5. Status pengujian dan data lokal

Status pengujian terakhir setelah penyelarasan kode:

- **54 tes lulus**, **307 assertion**.
- Pint lulus.
- Vite build lulus.
- Migration `2026_10_21_000013_align_research_decisions.php` sudah dijalankan pada database lokal.

Status database lokal terakhir:

- `users = 0`.
- `instruments = 1`.
- `active = 0`.
- `consents = 0`.
- `submissions = 0`.
- `age_verification_method = birth_year_plus_age_confirmation`.
- Formulir tertutup.
- Belum ada admin lokal; gunakan `php artisan admin:create` bila aplikasi akan dijalankan.

Pengujian dijalankan ulang setelah perubahan enum consent, metode usia, field kecamatan, ekspor CSV, dan gerbang MSPSS. Formulir tetap tertutup dan tidak ada data nyata yang dikumpulkan.

---

## 6. Perbedaan dokumentasi dan implementasi saat ini

Penyelarasan yang sudah diterapkan:

- Consent lima tahap sudah dipetakan ke enum, request, controller, tampilan admin, dan migration data lama.
- Kecamatan sudah disimpan sebagai field opsional, ditampilkan di admin, dan diekspor ke CSV.
- Metode verifikasi usia `birth_year_plus_age_confirmation` sudah menjadi default konfigurasi dan meminta deklarasi usia numerik.
- Gerbang MSPSS menolak aktivasi jika fitur dukungan sosial aktif atau dijadikan fitur model.

Hal yang masih perlu ditinjau atau menunggu keputusan:

- Metode verifikasi usia sudah tersedia secara teknis, tetapi pilihan metodologis final tetap menunggu peneliti/dosen pembimbing.
- Ambang kategori DASS-21 masih berupa nilai konfigurasi sementara.
- Consent final tanpa placeholder dan status etik masih belum tersedia.
- MSPSS belum memiliki versi, teks, atau skor yang terverifikasi.

Jangan mengubah konfigurasi untuk membuka formulir atau melatih model sampai keputusan peneliti/dosen pembimbing tersedia.

---

## 7. Blocker saat ini

### Sebelum formulir dapat dibuka

- Persetujuan final atas redaksi, urutan, dan instruksi DASS-21.
- Verifikasi ambang kategori.
- Consent final tanpa placeholder.
- Konfirmasi prosedur dan status etik.
- Persetujuan metode verifikasi usia dan definisi lokasi.
- Penetapan retensi, penghapusan, akses data, dan prosedur distress.
- Pembatasan akses peserta yang tidak membuka formulir untuk publik.

### Sebelum analisis data nyata

- Dataset primer sudah terkumpul dan diperiksa.
- Duplikasi, data tidak lengkap, dan inkonsistensi ditangani.
- Jumlah sampel dan distribusi kelas ditinjau.
- Data sintetis dipisahkan dari data nyata.

### Sebelum Random Forest dilatih

- Daftar fitur final.
- Konstruksi label referensi.
- Penanganan data hilang dan kategori langka.
- Split/validasi, random state, dan metrik.
- Artefak model serta hash dataset.

---

## 8. Langkah berikutnya

1. Peneliti membawa keputusan dan pertanyaan pada `docs/PENDING_RESEARCH_INPUTS.md` kepada dosen pembimbing/institusi.
2. Setelah ada keputusan, verifikasi final DASS-21 dan consent dilakukan sebelum aktivasi.
3. Lakukan pemeriksaan manual area admin setelah `php artisan admin:create`, tanpa mengaktifkan formulir atau memasukkan data nyata.
4. Formulir tetap tertutup selama blocker belum selesai.
5. Setelah data nyata tersedia dan audit dataset selesai, protokol fitur, label, split, dan metrik disusun sebelum pelatihan model.

---

## 9. Dokumen terkait

- `docs/DECISIONS.md` — keputusan metodologi dan aturan penggunaan.
- `docs/PENDING_RESEARCH_INPUTS.md` — keputusan yang masih menunggu pihak berwenang.
- `docs/INSTRUMENT_LIFECYCLE.md` — status instrumen dan gerbang aktivasi.
- `docs/SOURCES.md` — daftar sumber dan metadata yang perlu diverifikasi.
- `docs/RUNBOOK.md` — operasional lokal dan batas pengumpulan data.
- `README.md` — ringkasan proyek dan langkah menjalankan.
