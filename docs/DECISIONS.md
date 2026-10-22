# Keputusan Metodologi Penelitian

**Status dokumen:** keputusan kerja yang dicatat untuk penelitian; belum merupakan protokol penelitian final, belum merupakan persetujuan etik, dan belum membuka pengumpulan data.
**Tanggal dicatat:** 21 Oktober 2026.
**Ruang lingkup:** menjadi dasar rancangan sistem, dokumentasi metodologi, dan pembatasan pekerjaan tahap berikutnya.

Dokumen ini tidak memuat teks butir DASS-21 atau MSPSS, identitas peneliti, nomor persetujuan etik, atau informasi lain yang belum diberikan secara eksplisit.

---

## Ringkasan keputusan

| ID | Keputusan | Status |
|---|---|---|
| D-01 | DASS-21 Bahasa Indonesia dari situs resmi DASS; terjemahan Damanik diprioritaskan | Kandidat utama, menunggu verifikasi akhir |
| D-02 | Generasi Z BPS 1997–2012; batas operasional 1997–2008; minimal 18 tahun saat partisipasi | Ditetapkan sebagai batas kerja |
| D-03 | Wilayah Kabupaten Wonosobo, 15 kecamatan; kecamatan bersifat opsional | Ditetapkan |
| D-04 | Alur status consent lima tahap; consent final belum tersedia | Ditetapkan alurnya, isi belum lengkap |
| D-05 | MSPSS Bahasa Indonesia sebagai kandidat; harus dapat dinonaktifkan | Menunggu verifikasi |
| D-06 | Dataset primer dari website; tiga target terpisah; tidak ada training sebelum audit data | Ditetapkan sebagai batas kerja |

---

## D-01 — DASS-21 Bahasa Indonesia

### Keputusan instrumen

- Instrumen yang digunakan adalah **DASS-21 versi Bahasa Indonesia** yang tersedia melalui situs resmi DASS:
  `https://dass.psy.unsw.edu.au/Indonesian/Indonesian.htm`
- Kandidat utama adalah terjemahan **Evelina Damanik**:
  `https://dass.psy.unsw.edu.au/Indonesian/Damanik.htm`
- Halaman resmi juga mencantumkan terjemahan Potangaroa. Potangaroa tetap menjadi alternatif yang belum dipilih; jangan mencampur butir, instruksi, atau pemetaan dari dua versi.
- Versi Damanik belum boleh disebut sebagai instrumen final yang terverifikasi penuh sampai redaksi, urutan, instruksi, penggunaan, dan pemetaan skoringnya disetujui oleh peneliti/dosen pembimbing.
- Status teknis instrumen tetap `pending_verification` dan tidak aktif. Teks butir yang sudah tersimpan dalam seeder tidak boleh diaktifkan hanya karena tersedia secara teknis.

### Hasil pemeriksaan sumber resmi

- Halaman resmi DASS mencantumkan terjemahan Bahasa Indonesia dari Damanik dan Potangaroa.
- Halaman Damanik mencantumkan nama penerjemah, Evelina Damanik, dan menyatakan bahwa urutan butir mengikuti urutan DASS versi Inggris.
- Halaman unduhan resmi DASS menyediakan formulir respons DASS21 dan lembar skoring.
- Formulir resmi boleh diunduh dan disalin tanpa restriksi; skala tidak boleh dimodifikasi atau dijual untuk profit. Ketentuan ini tidak otomatis menyelesaikan verifikasi kualitas terjemahan atau kelayakan penggunaan versi Bahasa Indonesia.
- FAQ resmi DASS membatasi penggunaan website/aplikasi untuk kelompok penelitian, bukan situs yang terbuka bebas untuk masyarakat umum. Hasil harus diberikan kepada peneliti, bukan kepada responden.
- Tanggal pemeriksaan: **21 Oktober 2026**. Arsip/hash halaman sumber masih perlu disimpan untuk audit.

### Aturan penskoran yang ditetapkan

- DASS-21 memiliki 21 butir, dengan 7 butir untuk masing-masing subskala:
  - depresi;
  - kecemasan;
  - stres.
- Setiap butir diberi nilai 0–3 sesuai pilihan jawaban resmi.
- Skor mentah setiap subskala adalah jumlah nilai 7 butir pada subskala tersebut.
- Skor akhir setiap subskala adalah skor mentah dikalikan dua, untuk disetarakan dengan DASS-42.
- Kategori keparahan ditentukan dari skor akhir, bukan skor mentah.
- Pemetaan nomor butir yang dipakai saat ini:
  - depresi: 3, 5, 10, 13, 16, 17, 21;
  - kecemasan: 2, 4, 7, 9, 15, 19, 20;
  - stres: 1, 6, 8, 11, 12, 14, 18.
- Pemetaan tersebut harus dicocokkan kembali dengan lembar skoring resmi dan disetujui sebelum aktivasi.
- Instruksi yang tercatat memakai kerangka waktu **satu minggu terakhir**, empat pilihan jawaban dengan nilai 0–3, dan penegasan bahwa tidak ada jawaban benar atau salah. Redaksi final Bahasa Indonesia tetap menunggu persetujuan peneliti/dosen pembimbing.
- Skor mentah, skor akhir, dan kategori disimpan sebagai tiga nilai terpisah untuk setiap subskala.
- **Ambang kategori belum dikunci.** Nilai ambang yang ada dalam konfigurasi bersifat sementara dan tidak boleh dipresentasikan sebagai ketentuan final sebelum sumber resmi dan keputusan dosen pembimbing diverifikasi.

### Aturan penggunaan dan penyajian

- DASS-21 adalah alat skrining, bukan diagnosis klinis.
- Responden tidak boleh menerima skor, kategori, interpretasi otomatis, atau klaim “Anda mengalami depresi/kecemasan/stres”.
- Setelah pengiriman, responden hanya menerima konfirmasi bahwa jawaban berhasil dikirim.
- Skor dan hasil skrining hanya tersedia untuk peneliti/admin berwenang.
- Formulir hanya boleh diakses peserta penelitian melalui tautan atau kode peserta, bukan sebagai kuesioner publik.
- Jangan menyalin, membuat ulang, memparafrasa, atau merekonstruksi 21 butir dari ingatan atau keluaran AI.
- Jangan mengubah redaksi, urutan, pilihan jawaban, atau kerangka waktu tanpa dasar sumber dan persetujuan yang sesuai.
- Jangan menyatakan terjemahan telah tervalidasi khusus untuk Gen Z di Wonosobo tanpa bukti penelitian yang memadai.

### Konsekuensi teknis

- Definisi instrumen dipisahkan dari logika penskoran.
- Metadata sumber, versi, penerjemah, tanggal akses, status verifikasi, dan isi instrumen harus dapat dilacak.
- Formulir penelitian hanya boleh diaktifkan setelah instrumen, consent, etika, dan kriteria responden memenuhi gerbang aktivasi.
- Jika teks atau metadata belum diverifikasi, sistem harus menampilkan status belum siap dan menghentikan aktivasi.

Sumber:

- `https://dass.psy.unsw.edu.au/Indonesian/Indonesian.htm`
- `https://dass.psy.unsw.edu.au/Indonesian/Damanik.htm`
- `https://dass.psy.unsw.edu.au/DASSFAQ.htm`
- `https://dass.psy.unsw.edu.au/down.htm`

---

## D-02 — Populasi, batas Generasi Z, dan usia

### Keputusan

- Definisi BPS yang digunakan: Generasi Z adalah penduduk yang lahir pada tahun **1997–2012**.
- Batas operasional calon responden penelitian ini adalah lahir pada tahun **1997–2008**.
- Responden harus berusia **minimal 18 tahun** ketika memberikan persetujuan dan mengikuti penelitian pada tahun 2026.
- Kriteria responden:
  - lahir pada tahun 1997–2008;
  - berusia minimal 18 tahun saat memberikan persetujuan dan mengikuti penelitian;
  - berada di wilayah penelitian Kabupaten Wonosobo sesuai definisi operasional yang disetujui;
  - memberikan persetujuan dan melengkapi data yang diperlukan.
- Tahun lahir 2008 tidak otomatis berarti sudah berusia 18 tahun pada 2026. Karena itu, tahun lahir saja tidak boleh dipakai untuk menyimpulkan status dewasa.
- Pendekatan verifikasi awal yang ditetapkan: **tahun lahir ditambah deklarasi usia** pada saat partisipasi.
- Jangan meminta unggahan KTP atau tanggal lahir lengkap kecuali benar-benar diperlukan dan disetujui oleh peneliti/dosen pembimbing/institusi.
- Jika tanggal lahir lengkap tetap dikumpulkan atas dasar yang disetujui, usia harus dihitung terhadap tanggal partisipasi, bukan hanya tahun.
- Responden di bawah 18 tahun tidak boleh diizinkan mengikuti pengisian penelitian.
- Definisi populasi, kriteria inklusi, dan kriteria eksklusi harus disimpan dalam dokumentasi metodologi.

### Konsekuensi teknis

- Usia tidak boleh dihitung hanya dari tahun lahir apabila status dewasa pada tanggal partisipasi belum pasti.
- Verifikasi awal dengan tahun lahir dan deklarasi usia adalah pengaman, bukan bukti identitas.
- Data kelayakan harus dapat membedakan peserta yang memenuhi syarat, tidak memenuhi syarat, dan datanya tidak lengkap.
- Metode ini harus dikonfirmasi sebagai metode final sebelum formulir diaktifkan.

Sumber definisi kerja:

- `https://sensus.bps.go.id/topik/tabular/sp2020/2/13/1`

---

## D-03 — Wilayah penelitian

### Keputusan

- Wilayah penelitian adalah **Kabupaten Wonosobo, Jawa Tengah**.
- Kabupaten Wonosobo memiliki **15 kecamatan**:
  Wadaslintang, Kepil, Sapuran, Kalibawang, Kaliwiro, Leksono, Sukoharjo, Selomerto, Kalikajar, Kertek, Wonosobo, Watumalang, Mojotengah, Garung, dan Kejajar.
- Kecamatan bersifat **opsional** dalam data responden. Jangan mewajibkan kecamatan jika tidak diperlukan untuk analisis.
- Jika kecamatan dikumpulkan, gunakan hanya untuk deskripsi atau pemeriksaan ketahanan hasil, bukan untuk mengklaim keterwakilan seluruh kabupaten.
- Jangan mengumpulkan alamat lengkap, nomor KTP, atau dokumen domisili kecuali ada kebutuhan penelitian yang disetujui dan dijelaskan dalam consent.
- Penelitian ini tidak boleh mengklaim bahwa sampel mewakili seluruh Kabupaten Wonosobo tanpa rancangan sampling dan bukti cakupan yang memadai.

### Konsekuensi teknis

- Kecamatan disimpan sebagai field opsional terpisah pada submission dan ditampilkan di area admin serta ekspor CSV.
- Definisi operasional "berada di wilayah penelitian" masih perlu disetujui: domisili saat ini, aktivitas sehari-hari, atau definisi lain.
- Data wilayah tidak boleh digunakan untuk mengidentifikasi individu.

Sumber:

- `https://website.wonosobokab.go.id/page/geografis-kabupaten-wonosobo`

---

## D-04 — Lembar informasi dan persetujuan responden

### Keputusan alur status consent

Gunakan status berikut sebagai keputusan alur kerja consent:

1. `draft` — teks dan metadata mulai disiapkan; belum ada klaim kelengkapan atau verifikasi.
2. `menunggu kelengkapan` — placeholder, identitas, kontak, retensi, atau prosedur masih belum lengkap.
3. `menunggu verifikasi etik` — isi sudah lengkap untuk diajukan, tetapi status/prosedur etik belum dikonfirmasi.
4. `siap ditinjau` — dokumen lengkap dan siap diperiksa peneliti/dosen pembimbing/institusi.
5. `disetujui untuk digunakan` — versi disetujui untuk dipakai, tetapi formulir tetap hanya boleh dibuka setelah seluruh gerbang aktivasi terpenuhi.

Status tersebut sudah dipetakan ke enum `ConsentStatus` (`draft`, `incomplete`, `pending_ethics`, `ready_for_review`, `approved_for_use`). `is_active` tetap menjadi gerbang teknis terpisah dan hanya boleh diaktifkan untuk versi berstatus `approved_for_use`.

### Isi minimum persetujuan

1. Judul dan tujuan penelitian.
2. Kriteria responden dan alasan kelayakan.
3. Jenis informasi yang dikumpulkan.
4. Perkiraan waktu pengisian setelah ditetapkan peneliti.
5. Sifat partisipasi yang sukarela.
6. Hak menolak atau menghentikan partisipasi sebelum pengiriman.
7. Risiko atau ketidaknyamanan yang mungkin timbul ketika menjawab pertanyaan terkait kondisi emosional.
8. Manfaat penelitian tanpa menjanjikan manfaat pribadi.
9. Cara data disimpan, digunakan, diakses, dan dihapus.
10. Upaya meminimalkan pengumpulan identitas langsung.
11. Batas kerahasiaan dan cara menghubungi peneliti.
12. Penjelasan bahwa DASS-21 bukan alat untuk memastikan diagnosis klinis.
13. Penjelasan bahwa hasil individual tidak diberikan sebagai diagnosis atau interpretasi otomatis.
14. Pernyataan persetujuan aktif oleh responden dewasa.

### Placeholder yang wajib dilengkapi

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

### Aturan yang mengikat

- Jangan mengarang identitas, kontak, institusi, tanggal, nomor etik, masa retensi, atau prosedur penghapusan.
- Consent final tidak boleh dibuat selama placeholder belum lengkap dan prosedur etik belum dikonfirmasi.
- Status etik saat ini **belum dikonfirmasi**. Peneliti harus bertanya kepada dosen pembimbing/institusi; jangan mengisi status etik berdasarkan asumsi.
- Jangan menampilkan nomor persetujuan etik yang belum benar-benar diterbitkan.
- Jangan mengklaim telah memperoleh ethical approval sebelum ada dokumen resmi.
- Jawaban kuesioner tidak boleh disimpan jika persetujuan belum dicatat.
- Catatan persetujuan disimpan bersama tanggal/waktu dan versi teks persetujuan yang disetujui.
- Responden harus mendapat pilihan yang jelas untuk setuju atau menolak.
- Pengumpulan data nyata tidak boleh diaktifkan sebelum consent final, prosedur etik, dan seluruh gerbang aktivasi terpenuhi.
- Data sintetis yang diberi label jelas boleh digunakan untuk pengembangan teknis, tetapi tidak boleh disajikan sebagai data atau hasil penelitian nyata.

Pedoman awal, bukan pengganti prosedur etik kampus:

- `https://komite-etik.fk.ui.ac.id/p/index.php/p/userGuidelines`

---

## D-05 — Instrumen dukungan sosial (MSPSS)

### Keputusan

- Multidimensional Scale of Perceived Social Support (MSPSS) versi Bahasa Indonesia adalah kandidat awal variabel dukungan sosial.
- Statusnya adalah **menunggu verifikasi versi dan penggunaan**.
- Dasar awal:
  Sulistiani, W., Fajrianthi, & Kristiana, I. F. (2022). “Validation of the Indonesian Version of the Multidimensional Scale of Perceived Social Support (MSPSS): A Rasch Model Approach.” *Jurnal Psikologi*, 21(1), 89–103.
  `https://doi.org/10.14710/jp.21.1.89-103`

### Sebelum instrumen dimasukkan ke website

- Periksa artikel, versi Bahasa Indonesia yang benar, sumber item, petunjuk pengisian, sistem penskoran, dan hak reproduksi.
- Jangan menyimpulkan bahwa artikel validasi otomatis memberi izin untuk mereproduksi seluruh item.
- Jangan membuat sendiri 12 pertanyaan MSPSS atau menerjemahkannya secara bebas.
- Jangan mengaktifkan pertanyaan MSPSS sebelum versi dan ketentuan penggunaannya dipastikan.
- Konfirmasi kepada peneliti/dosen pembimbing diperlukan jika versi atau izin reproduksi belum jelas.

### Status sistem dan analisis

- Jika verifikasi belum selesai, dukungan sosial tetap **opsional/nonaktif**.
- Fitur dukungan sosial harus dapat dinonaktifkan melalui konfigurasi.
- Jangan mengganti MSPSS secara diam-diam dengan pertanyaan buatan sendiri.
- Jika MSPSS tidak dapat diverifikasi, variabel dukungan sosial tidak boleh dipakai sebagai fitur model.
- Alternatif instrumen dibahas kemudian bersama dosen pembimbing.

---

## D-06 — Dataset dan model Random Forest

### Keputusan dataset

- Dataset utama berasal dari pengumpulan data primer melalui website penelitian.
- Data sintetis tidak boleh disajikan sebagai data penelitian nyata.
- Data sintetis hanya boleh dipakai untuk pengujian pipeline, tampilan, dan validasi teknis; harus diberi penanda jelas, dipisahkan dari data nyata, dan dikecualikan dari statistik penelitian.
- Jangan membuat data responden fiktif untuk mengisi dashboard produksi.
- Dataset final harus melalui pemeriksaan kelengkapan, duplikasi, konsistensi, dan distribusi kelas sebelum dipakai.

### Keputusan target dan fitur

- Pertahankan tiga target terpisah:
  - `label_depresi`;
  - `label_kecemasan`;
  - `label_stres`.
- Skor DASS-21, 21 butir DASS-21, atau label yang dibentuk dari skor tersebut tidak boleh menjadi fitur untuk memprediksi label yang sama.
- Variabel pendukung yang disetujui dapat digunakan sebagai fitur model, tetapi daftar fitur final belum ditetapkan.
- Durasi tidur, aktivitas fisik, penggunaan media sosial, pendidikan/pekerjaan, dan dukungan sosial adalah kandidat fitur, bukan daftar final yang otomatis disetujui.
- Fitur yang belum diverifikasi harus dapat dinonaktifkan melalui konfigurasi.
- Fitur yang benar-benar digunakan harus dicatat pada setiap eksperimen.
- Skor skrining DASS-21, label referensi untuk pelatihan/evaluasi, dan prediksi eksperimental Random Forest harus dipisahkan secara jelas.

### Batas pelatihan model

Pelatihan Random Forest **belum boleh dimulai** sampai:

- dataset diperiksa dan dibersihkan;
- jumlah sampel nyata ditinjau;
- distribusi kelas setiap target diperiksa;
- konstruksi label referensi disetujui;
- rancangan split/validasi disetujui;
- daftar fitur final dan penanganan data hilang ditetapkan;
- metrik evaluasi ditetapkan sebelum melihat hasil uji.

Jangan menetapkan ukuran sampel minimum secara sembarang, mengarang metrik, membuat confusion matrix fiktif, atau mengklaim performa model dari data sintetis. Keputusan mengenai jumlah data, split, validasi, dan metrik dicatat sebagai keputusan yang masih terbuka.

---

## D-07 — Batas pekerjaan

Sampai konten penelitian dinyatakan final, tidak boleh dilakukan:

- membuat atau menyalin butir DASS-21 tanpa sumber terverifikasi;
- membuat atau menerjemahkan butir MSPSS;
- membuat consent final yang memuat identitas atau informasi belum terverifikasi;
- mengaktifkan formulir penelitian;
- mengumpulkan data responden nyata;
- melatih atau mengklaim hasil model dari data sintetis;
- mengubah kode aplikasi sebagai bagian dari tugas dokumentasi ini.

Implementasi logika penskoran DASS-21 dan gerbang kesiapan boleh dipertahankan sebagai dasar teknis tanpa membuka formulir. Formulir tetap nonaktif sampai seluruh gerbang pada `docs/INSTRUMENT_LIFECYCLE.md` terpenuhi.

---

## Keputusan yang masih terbuka

Rincian dan statusnya dicatat pada `docs/PENDING_RESEARCH_INPUTS.md`. Keputusan yang paling mendesak:

1. Menyetujui redaksi, urutan, instruksi, dan ambang DASS-21 versi Damanik.
2. Mengonfirmasi metode verifikasi usia dan definisi operasional lokasi kepada dosen pembimbing.
3. Melengkapi seluruh placeholder consent dan mengonfirmasi prosedur etik.
4. Memastikan versi, izin, dan cara penskoran MSPSS atau menonaktifkannya.
5. Menetapkan daftar fitur final, konstruksi label, jumlah data, split/validasi, dan metrik.
6. Memetakan alur consent lima tahap ke sistem pada tahap implementasi berikutnya.
