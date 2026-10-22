# Input Penelitian dan Keputusan yang Masih Diperlukan

**Status:** daftar kerja. Dokumen ini bukan protokol final, bukan persetujuan etik, dan tidak membuka pengumpulan data.
**Tanggal dicatat:** 21 Oktober 2026.
**Batasan:** formulir responden, area data admin, dan ekspor CSV sudah tersedia secara teknis, tetapi formulir tetap tertutup sampai seluruh blocker selesai.

Dokumen ini dipisahkan menjadi:

- **Bagian A** — keputusan kerja yang sudah dapat ditetapkan sekarang dan tidak perlu ditanyakan lagi kecuali ada perubahan rancangan.
- **Bagian B** — hal yang hanya dapat dilengkapi atau disetujui oleh peneliti, dosen pembimbing, institusi, atau pihak sumber instrumen.
- **Bagian C** — ringkasan blocker sebelum formulir, data nyata, atau pemodelan dibuka.

---

## Bagian A — Keputusan yang sudah dapat ditetapkan sekarang

### A.1 DASS-21

- [x] Gunakan DASS-21 Bahasa Indonesia dari situs resmi DASS.
- [x] Prioritaskan terjemahan **Evelina Damanik** sebagai kandidat utama.
- [x] Jangan mencampur butir, instruksi, atau pemetaan dari versi Damanik dan Potangaroa.
- [x] Gunakan 21 butir dengan 7 butir per subskala.
- [x] Gunakan respons 0–3 dan kerangka waktu satu minggu terakhir.
- [x] Hitung skor mentah per subskala, lalu skor akhir = skor mentah × 2.
- [x] Tentukan kategori dari skor akhir, bukan skor mentah.
- [x] Catat pemetaan nomor butir: depresi 3, 5, 10, 13, 16, 17, 21; kecemasan 2, 4, 7, 9, 15, 19, 20; stres 1, 6, 8, 11, 12, 14, 18.
- [x] Perlakukan DASS-21 sebagai alat skrining, bukan diagnosis.
- [x] Jangan tampilkan skor, kategori, atau interpretasi kepada responden.
- [x] Jangan mengunci ambang kategori sebagai final sebelum sumber resmi dan dosen pembimbing memverifikasinya.
- [x] Batasi formulir untuk peserta penelitian melalui tautan/kode, bukan kuesioner publik.
- [x] Jangan menyalin atau merekonstruksi butir dari ingatan atau keluaran AI.

**Yang belum diselesaikan pada bagian ini:** persetujuan akhir redaksi/urutan/instruksi, verifikasi ambang, dan pencocokan pemetaan dengan lembar skoring resmi. Itu ada di Bagian B.

### A.2 Populasi dan usia

- [x] Definisi BPS: Generasi Z lahir pada 1997–2012.
- [x] Batas operasional calon responden: lahir pada 1997–2008.
- [x] Usia minimum: 18 tahun saat memberikan persetujuan dan mengikuti penelitian.
- [x] Jangan menyimpulkan status dewasa hanya dari tahun lahir.
- [x] Gunakan tahun lahir ditambah deklarasi usia sebagai pendekatan verifikasi awal.
- [x] Jangan meminta unggahan KTP atau tanggal lahir lengkap kecuali benar-benar diperlukan dan disetujui.
- [x] Jika tanggal lahir lengkap kelak dikumpulkan atas dasar yang disetujui, hitung usia terhadap tanggal partisipasi.

### A.3 Wilayah

- [x] Wilayah penelitian: Kabupaten Wonosobo, Jawa Tengah.
- [x] Catat 15 kecamatan: Wadaslintang, Kepil, Sapuran, Kalibawang, Kaliwiro, Leksono, Sukoharjo, Selomerto, Kalikajar, Kertek, Wonosobo, Watumalang, Mojotengah, Garung, Kejajar.
- [x] Kecamatan bersifat opsional, bukan field wajib.
- [x] Jangan mengumpulkan alamat lengkap atau dokumen domisili tanpa kebutuhan yang disetujui.
- [x] Jangan mengklaim sampel mewakili seluruh Kabupaten Wonosobo tanpa dasar sampling dan bukti cakupan.

### A.4 Consent dan etika

- [x] Gunakan alur status consent: `draft`, `menunggu kelengkapan`, `menunggu verifikasi etik`, `siap ditinjau`, `disetujui untuk digunakan`.
- [x] Jangan mengarang identitas, kontak, institusi, nomor etik, tanggal, retensi, atau prosedur penghapusan.
- [x] Jangan menampilkan atau mengklaim nomor persetujuan etik sebelum benar-benar diterbitkan.
- [x] Jangan menyimpan jawaban sebelum persetujuan dicatat.
- [x] Consent final belum boleh dibuat selama placeholder dan prosedur etik belum lengkap.
- [x] Status etik saat ini **belum dikonfirmasi**; jangan mengisi status berdasarkan asumsi.

### A.5 MSPSS

- [x] MSPSS Bahasa Indonesia adalah kandidat, bukan instrumen final.
- [x] Jangan membuat atau menerjemahkan 12 butir MSPSS sendiri.
- [x] Jangan mengaktifkan MSPSS sebelum versi, skoring, sumber, dan hak reproduksi diverifikasi.
- [x] Fitur dukungan sosial harus dapat dinonaktifkan.
- [x] Jika MSPSS tidak terverifikasi, dukungan sosial tidak boleh dipakai sebagai fitur model.

### A.6 Dataset dan Random Forest

- [x] Dataset utama berasal dari pengumpulan data primer website.
- [x] Data sintetis tidak boleh disajikan sebagai data penelitian nyata.
- [x] Data sintetis hanya untuk pengujian teknis, harus diberi label, dan dipisahkan dari data nyata.
- [x] Pertahankan tiga target terpisah: `label_depresi`, `label_kecemasan`, `label_stres`.
- [x] Jangan memakai 21 butir DASS, skor subskala, atau label yang sama sebagai fitur untuk target yang sama.
- [x] Jangan melatih Random Forest sebelum dataset diperiksa, jumlah sampel ditinjau, dan distribusi kelas diketahui.
- [x] Jangan menetapkan ukuran sampel minimum secara sembarang.
- [x] Jangan membuat metrik, confusion matrix, atau hasil evaluasi fiktif.
- [x] Jangan mengklaim performa model dari data sintetis.

### A.7 Batas pekerjaan saat ini

- [x] Tugas dokumentasi ini hanya mengubah dokumen.
- [x] Jangan mengubah kode, membuat instrumen baru, mengaktifkan formulir, mengumpulkan data nyata, atau memulai pelatihan model.
- [x] Jangan mengaktifkan formulir sampai seluruh blocker di Bagian C selesai.

---

## Bagian B — Menunggu peneliti, dosen pembimbing, institusi, atau sumber instrumen

### B.1 Verifikasi final DASS-21

- [ ] Setujui redaksi dan urutan 21 butir versi Damanik.
- [ ] Verifikasi ulang instruksi pengisian dan empat pilihan jawaban terhadap dokumen resmi.
- [ ] Cocokkan pemetaan nomor butir dan aturan skoring dengan lembar skoring resmi.
- [ ] Verifikasi ambang kategori final; jangan memakai ambang sebagai keputusan final sebelum disetujui.
- [ ] Simpan salinan/arsip halaman sumber, tanggal akses, dan hash bila memungkinkan.
- [ ] Tentukan siapa yang berwenang menyatakan instrumen terverifikasi.
- [ ] Tentukan dasar penamaan versi dan tanggal berlaku.
- [ ] Konfirmasi ketentuan penggunaan untuk penelitian dan pembatasan akses.
- [ ] Pastikan tidak ada klaim validasi khusus Gen Z Wonosobo tanpa bukti.

**Pertanyaan untuk peneliti/dosen:**

1. Apakah versi Damanik disetujui sebagai versi final?
2. Apakah ambang kategori mengikuti ketentuan baku DASS-21 atau ada keputusan metodologis lain?
3. Siapa yang memverifikasi dan menandatangani status verifikasi instrumen?

### B.2 Usia, populasi, dan lokasi

- [ ] Konfirmasi apakah “tahun lahir + deklarasi usia” disetujui sebagai metode final.
- [ ] Tetapkan definisi operasional “berada di wilayah penelitian Kabupaten Wonosobo”.
- [ ] Tetapkan periode penelitian dan tanggal partisipasi yang dipakai untuk menghitung usia.
- [ ] Tetapkan cara menangani peserta yang lahir 2008 tetapi belum berusia 18 tahun pada tanggal partisipasi.
- [ ] Tetapkan apakah tahun lahir disimpan dan apakah tanggal lahir lengkap benar-benar diperlukan.
- [ ] Tetapkan kriteria inklusi final.
- [ ] Tetapkan kriteria eksklusi final, termasuk data tidak lengkap, duplikasi, dan ketidakkonsistenan.
- [x] Kecamatan disediakan sebagai field opsional pada formulir, disimpan terpisah, dan diekspor; penggunaan dalam analisis tetap opsional.
- [ ] Tetapkan bukti domisili/keberadaan di Wonosobo, jika diperlukan.

**Pertanyaan untuk peneliti/dosen:**

1. Apakah deklarasi usia cukup, atau diperlukan bukti tambahan?
2. Apakah domisili, tempat tinggal saat ini, atau aktivitas di Wonosobo yang dipakai?
3. Bagaimana peserta yang tidak memenuhi syarat diberi tahu tanpa mengumpulkan data berlebih?

### B.3 Consent dan etika

- [ ] Lengkapi seluruh placeholder consent:
  - `[NAMA PENELITI]`
  - `[PROGRAM STUDI]`
  - `[FAKULTAS]`
  - `[NAMA UNIVERSITAS]`
  - `[NAMA DOSEN PEMBIMBING]`
  - `[EMAIL KONTAK PENELITI]`
  - `[NOMOR KONTAK PENELITI, JIKA DISEDIAKAN]`
  - `[KONTAK KOMITE ETIK, JIKA BERLAKU]`
  - `[NOMOR/TANGGAL PERSETUJUAN ETIK, JIKA DIPERSYARATKAN]`
  - `[MASA PENYIMPANAN DATA]`
  - `[PROSEDUR PENGHAPUSAN DATA]`
- [ ] Konfirmasi prosedur etik universitas/dosen pembimbing.
- [ ] Konfirmasi apakah penelitian memerlukan izin penelitian tambahan.
- [ ] Konfirmasi apakah nomor/tanggal persetujuan etik sudah benar-benar diterbitkan.
- [ ] Tetapkan perkiraan waktu pengisian.
- [ ] Tetapkan risiko/ketidaknyamanan spesifik dan cara mengatasinya.
- [ ] Tetapkan prosedur jika responden mengalami distress saat mengisi.
- [ ] Tetapkan apakah ada kompensasi; jika tidak, nyatakan dengan jelas.
- [ ] Tetapkan masa penyimpanan data.
- [ ] Tetapkan prosedur penghapusan data.
- [ ] Tetapkan siapa yang menjadi pengendali data dan siapa yang dapat mengakses data mentah.
- [ ] Tetapkan prosedur penarikan data setelah pengiriman, jika berlaku.
- [ ] Tetapkan mekanisme pelaporan masalah atau insiden data.
- [ ] Tentukan versi teks consent final dan tanggal berlaku.
- [ ] Tentukan apakah persetujuan ulang diperlukan jika teks berubah.

**Pertanyaan untuk peneliti/dosen/institusi:**

1. Apakah penelitian ini memerlukan ethical approval, dan bagaimana prosedurnya?
2. Siapa yang boleh mengakses data mentah dan hasil skrining?
3. Berapa lama data disimpan dan bagaimana data dihapus?

### B.4 MSPSS

- [ ] Baca artikel Sulistiani, Fajrianthi, & Kristiana (2022) dan periksa versi Bahasa Indonesia yang digunakan.
- [ ] Verifikasi sumber 12 item, instruksi, skala jawaban, dan sistem penskoran.
- [ ] Verifikasi hak reproduksi item; validasi psikometrik tidak otomatis berarti izin reproduksi.
- [ ] Tentukan apakah MSPSS dipakai, diganti instrumen lain yang disetujui, atau tidak dipakai.
- [ ] Jika belum terverifikasi, pertahankan dukungan sosial sebagai opsional/nonaktif.
- [ ] Catat keputusan akhir di metodologi.

**Pertanyaan untuk peneliti/dosen:**

1. Apakah MSPSS tetap dipakai jika versi/izin belum jelas?
2. Apakah ada instrumen alternatif yang sudah disetujui?
3. Apakah dukungan sosial dikeluarkan dari model jika tidak dapat diverifikasi?

### B.5 Dataset dan Random Forest

- [ ] Tetapkan daftar fitur final yang disetujui.
- [ ] Tetapkan fitur mana yang aktif dan mana yang nonaktif.
- [ ] Tetapkan cara menangani data hilang.
- [ ] Tetapkan cara menangani kategori langka.
- [ ] Tetapkan konstruksi label referensi untuk tiga target.
- [ ] Tetapkan apakah kelas digabung atau dipertahankan, beserta dasar dan persetujuannya.
- [ ] Tetapkan ambang minimal jumlah data per kelas.
- [ ] Tetapkan pembagian data latih/uji, stratifikasi, dan random state.
- [ ] Tetapkan validasi silang dan aturan bahwa tuning tidak menyentuh data uji.
- [ ] Tetapkan metrik utama dan metrik pendukung.
- [ ] Tetapkan cara menyimpan artefak model dan hash dataset.
- [ ] Tetapkan cara mencatat fitur yang benar-benar dipakai pada setiap eksperimen.
- [ ] Tetapkan aturan agar data sintetis tidak dicampur dengan data nyata.
- [ ] Tetapkan siapa yang berwenang menjalankan eksperimen dan melihat hasil.
- [ ] Pastikan tidak ada training sebelum seluruh keputusan di atas selesai.

**Pertanyaan untuk peneliti/dosen:**

1. Apakah jumlah data nyata memadai untuk tiga target dan kelas yang dipilih?
2. Bagaimana label referensi dibentuk tanpa menjadikan DASS-21 sebagai fitur?
3. Metrik apa yang paling relevan untuk tujuan penelitian dan distribusi kelas?

### B.6 Operasional

- [ ] Buat akun admin lokal melalui prosedur yang disetujui bila aplikasi akan dijalankan.
- [ ] Konfirmasi mode akses peserta: tautan bertanda tangan, kode akses, atau kombinasi.
- [ ] Pastikan formulir tidak diindeks mesin pencari dan tidak ditautkan sebagai kuesioner publik.
- [ ] Pastikan data sintetis tidak muncul dalam statistik penelitian nyata.
- [ ] Tinjau pemetaan alur consent lima tahap ke enum teknis aplikasi sebelum implementasi berikutnya.

---

## Bagian C — Ringkasan blocker

### C.1 Sebelum formulir dibuka

Formulir tidak boleh aktif jika masih ada salah satu kondisi berikut:

- [ ] Teks, urutan, dan instruksi DASS-21 belum disetujui peneliti/dosen.
- [ ] Ambang kategori belum diverifikasi atau masih diperlakukan sebagai final tanpa dasar.
- [ ] Consent final belum lengkap dan masih mengandung placeholder.
- [ ] Prosedur/status etik belum dikonfirmasi.
- [ ] Metode verifikasi usia dan definisi lokasi belum disetujui sebagai metode final.
- [ ] Akses peserta belum dibatasi dan masih berpotensi menjadi kuesioner publik.
- [ ] Retensi, penghapusan, dan akses data belum ditetapkan.
- [ ] Prosedur penanganan distress belum tersedia.

### C.2 Sebelum data nyata dianalisis

- [ ] Dataset primer telah diperiksa kelengkapan, duplikasi, dan konsistensinya.
- [ ] Jumlah sampel dan distribusi kelas telah ditinjau.
- [ ] Kriteria inklusi/eksklusi diterapkan secara konsisten.
- [ ] Data sintetis telah dipisahkan dan tidak tercampur.
- [ ] Label referensi telah dibentuk dan disetujui.

### C.3 Sebelum Random Forest dilatih

- [ ] Daftar fitur final disetujui.
- [ ] Fitur DASS-21/skor/label yang sama tidak dipakai untuk target yang sama.
- [ ] Penanganan data hilang dan kategori langka ditetapkan.
- [ ] Split/validasi dan random state ditetapkan.
- [ ] Metrik utama dan pendukung ditetapkan.
- [ ] Artefak, hash dataset, dan pencatatan eksperimen disiapkan.
- [ ] Tidak ada klaim performa dari data sintetis atau hasil yang belum dijalankan.

---

## Keputusan yang diminta dari peneliti

1. Apakah versi Damanik disetujui sebagai versi final, dan siapa yang memverifikasi?
2. Apakah “tahun lahir + deklarasi usia” cukup untuk verifikasi usia?
3. Apa definisi operasional lokasi Wonosobo?
4. Bagaimana status dan prosedur etik yang berlaku?
5. Apakah MSPSS dipakai, ditunda, atau diganti?
6. Bagaimana label referensi, fitur final, jumlah data, split/validasi, dan metrik ditetapkan?
