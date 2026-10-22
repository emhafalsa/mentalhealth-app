# Rancangan Status dan Gerbang Aktivasi Instrumen

**Status:** sebagian diterapkan; gerbang aktivasi masih berlaku.
**Tanggal dicatat:** 21 Oktober 2026.
**Batasan:** dokumen ini adalah rancangan dan catatan implementasi, bukan protokol penelitian final atau persetujuan etik.

---

## 1. Prinsip

1. **Fail closed**: jika syarat belum lengkap, formulir tidak boleh aktif.
2. **Tidak ada aktivasi otomatis**: status tidak boleh melompat dari draf ke aktif.
3. **Versi tidak berubah diam-diam**: teks dan metadata yang sudah dipakai harus dapat dilacak.
4. **Persetujuan sebelum jawaban**: tidak ada jawaban yang disimpan sebelum persetujuan dicatat.
5. **Hasil bukan diagnosis**: responden tidak menerima skor atau interpretasi otomatis.
6. **Data nyata menunggu kesiapan**: data sintetis hanya untuk pengembangan dan harus diberi label.
7. **Akses terbatas**: formulir hanya untuk peserta penelitian, bukan terbuka bagi masyarakat umum.
8. **Audit**: setiap perubahan status dan aktivasi harus tercatat.

---

## 2. Status instrumen dan consent

### 2.1 Status instrumen

Kode status yang diusulkan:

| Kode | Label tampilan | Arti | Formulir publik |
|---|---|---|---|
| `draft` | Draft | Teks dan metadata sedang disiapkan; belum ada klaim verifikasi | Tidak |
| `pending_verification` | Menunggu verifikasi | Sumber/kandidat sudah diidentifikasi, tetapi belum diverifikasi | Tidak |
| `verified` | Terverifikasi | Sumber, terjemahan, instruksi, penggunaan, dan penskoran sudah diverifikasi oleh pihak berwenang | Tidak otomatis |
| `active` | Aktif | Semua gerbang aktivasi terpenuhi dan disetujui untuk pengumpulan data | Ya |

Ketentuan:

- Hanya satu versi DASS-21 yang boleh `active` untuk satu kode instrumen dan locale pada satu waktu.
- Status `verified` belum berarti boleh mengumpulkan data. Status `active` adalah keputusan terpisah.
- Instrumen nonaktif tetap dapat ditampilkan di dashboard admin sebagai “belum aktif”.
- Versi yang sudah pernah dipakai tidak boleh dihapus; penonaktifan harus melalui perubahan status yang tercatat.

### 2.2 Status consent

| Kode | Label tampilan | Arti | Dapat diaktifkan |
|---|---|---|---|
| `draft` | Draft | Teks dan metadata mulai disiapkan | Tidak |
| `incomplete` | Menunggu kelengkapan | Placeholder, identitas, kontak, retensi, atau prosedur belum lengkap | Tidak |
| `pending_ethics` | Menunggu verifikasi etik | Isi lengkap untuk diajukan, tetapi status/prosedur etik belum dikonfirmasi | Tidak |
| `ready_for_review` | Siap ditinjau | Dokumen siap diperiksa peneliti/dosen pembimbing/institusi | Tidak |
| `approved_for_use` | Disetujui untuk digunakan | Versi disetujui untuk dipakai | Ya, setelah `is_active` diaktifkan dan seluruh gerbang terpenuhi |

Ketentuan:

- `is_active` tetap menjadi gerbang teknis terpisah dari status.
- Hanya versi `approved_for_use` yang dapat diaktifkan.
- Placeholder wajib ditolak untuk `pending_ethics`, `ready_for_review`, dan `approved_for_use`.
- `verified_at` dan `verified_by` hanya diisi ketika versi disetujui untuk digunakan.

---

## 3. Transisi status

### `draft` → `pending_verification`

Syarat:

- kandidat sumber dicatat;
- URL sumber dicatat;
- alasan pemilihan versi dicatat;
- tidak ada klaim bahwa instrumen sudah tervalidasi untuk populasi penelitian.

### `pending_verification` → `verified`

Syarat:

- dokumen sumber resmi sudah diperiksa;
- penerjemah/versi dan referensi sudah dicatat;
- instruksi, pilihan jawaban, urutan, dan kerangka waktu sudah dicocokkan;
- dasar penskoran dan ambang sudah dicatat;
- status penggunaan/izin sudah dicatat;
- tanggal dan identitas verifikator dicatat;
- tidak ada placeholder atau teks yang belum pasti;
- hasil verifikasi disetujui peneliti/dosen pembimbing.

### `verified` → `active`

Hanya boleh melalui gerbang aktivasi pada bagian 4. Status ini tidak boleh dicapai dengan mengubah satu boolean secara langsung.

### `active` → `verified` atau `pending_verification`

Dilakukan untuk menonaktifkan formulir, misalnya karena ada koreksi sumber atau masalah data. Data yang sudah masuk tidak dihapus otomatis. Alasan penonaktifan wajib dicatat.

### Transisi yang dilarang

- `draft` → `active`
- `pending_verification` → `active`
- aktivasi tanpa persetujuan admin/peneliti
- aktivasi saat consent belum aktif
- aktivasi saat placeholder consent masih ada
- aktivasi saat metode verifikasi usia belum ditetapkan

---

## 4. Gerbang aktivasi

Formulir hanya boleh aktif jika **semua** kondisi berikut benar.

### 4.1 Instrumen

- [ ] Status instrumen = `verified`.
- [ ] Sumber resmi dan tanggal pengambilan tercatat.
- [ ] Referensi/versi/penerjemah tercatat.
- [ ] Teks butir, urutan, instruksi, pilihan jawaban, dan kerangka waktu telah diverifikasi.
- [ ] Hash/arsip sumber disimpan jika memungkinkan.
- [ ] Tidak ada placeholder pada teks instrumen.
- [ ] Penskoran dipisahkan dari teks butir.
- [ ] Tujuh butir per subskala sudah dipetakan dengan benar.
- [ ] Skor akhir = skor mentah × 2.
- [ ] Kategori ditentukan dari skor akhir, bukan skor mentah.
- [ ] Pemetaan butir dan ambang telah diperiksa.
- [ ] Tidak ada klaim validasi khusus Gen Z Wonosobo tanpa bukti.

### 4.2 Akses formulir

- [ ] Formulir hanya dapat diakses peserta penelitian melalui tautan/kode khusus.
- [ ] Formulir tidak diindeks mesin pencari dan tidak ditautkan sebagai kuesioner terbuka untuk publik.
- [ ] Hasil dan skor hanya tersedia untuk peneliti/admin.
- [ ] Responden hanya melihat konfirmasi pengiriman.
- [ ] Akses publik ke halaman informasi tidak membuka formulir secara otomatis.

### 4.3 Persetujuan responden

- [ ] Ada versi consent berstatus aktif.
- [ ] Semua placeholder wajib sudah diisi.
- [ ] Tidak ada pola placeholder `[...]` yang tersisa.
- [ ] Isi consent memuat seluruh unsur minimum.
- [ ] Waktu pengisian, retensi, dan penghapusan data sudah ditetapkan.
- [ ] Kontak peneliti dan prosedur etik sudah dikonfirmasi.
- [ ] Hash/versi teks consent tersimpan.
- [ ] Persetujuan dicatat sebelum jawaban disimpan.
- [ ] Pilihan menolak tersedia dan tidak menyimpan jawaban.

### 4.4 Kriteria responden

- [ ] Tahun lahir 1997–2008 dikonfigurasi.
- [ ] Usia minimum 18 tahun dikonfigurasi.
- [ ] Metode verifikasi usia sudah ditetapkan dan tidak membiarkan peserta di bawah 18 tahun lolos.
- [ ] Definisi operasional lokasi Kabupaten Wonosobo sudah ditetapkan.
- [ ] Kriteria inklusi/eksklusi sudah dicatat.
- [ ] Penanganan data tidak lengkap/duplikat sudah ditetapkan.

### 4.5 Etika dan data

- [ ] Prosedur etik universitas/dosen pembimbing sudah dikonfirmasi.
- [ ] Status nomor/tanggal persetujuan etik tercatat dengan benar.
- [ ] Tidak ada nomor etik fiktif yang ditampilkan.
- [ ] Masa retensi dan prosedur penghapusan sudah ditetapkan.
- [ ] Hak akses data mentah dan hasil skrining sudah ditetapkan.
- [ ] Mekanisme penarikan data setelah pengiriman sudah dijelaskan, jika berlaku.
- [ ] Rencana penanganan distress/risiko responden sudah ada.

### 4.6 Instrumen tambahan

- [ ] MSPSS berstatus `verified` dan `active`, **atau** secara eksplisit nonaktif/tidak dipakai.
- [ ] Tidak ada item MSPSS buatan sendiri.
- [ ] Fitur dukungan sosial tidak dipakai model jika instrumennya belum terverifikasi.

### 4.7 Persetujuan aktivasi

- [ ] Admin/peneliti berwenang menekan aktivasi.
- [ ] Sistem menampilkan ringkasan gerbang yang belum terpenuhi.
- [ ] Aktivasi dicatat di audit log: waktu, aktor, versi instrumen, versi consent.
- [ ] Formulir publik hanya muncul setelah status `active`.

---

## 5. Usulan metadata dan skema

Sebagian field sudah ditambahkan melalui migration `2026_10_21_000011_add_verification_fields_to_research_tables.php` dan `2026_10_21_000012_add_questionnaire_content_and_access_fields.php`. Daftar di bawah tetap menjadi rancangan; status implementasi dirangkum pada bagian 8.

### 5.1 `instrument_versions`

Field yang perlu dipertimbangkan:

- `status` (`draft`, `pending_verification`, `verified`, `active`).
- `source_url`.
- `source_retrieved_at`.
- `source_reference`.
- `translator`.
- `copyright_status`.
- `verification_notes`.
- `verified_at`.
- `verified_by`.
- `instructions`.
- `item_texts` (21 butir, urutan tetap).
- `response_options`.
- `content_hash` atau hash dokumen sumber.
- `is_active` perlu dipertahankan sementara untuk kompatibilitas, tetapi sebaiknya tidak menjadi satu-satunya penentu aktivasi.
- `effective_from`.

### 5.2 `consent_versions`

Field yang perlu dipertimbangkan:

- `status` (`draft`, `incomplete`, `pending_ethics`, `ready_for_review`, `approved_for_use`).
- `placeholder_count`/`is_complete`.
- `verified_at`.
- `verified_by`.
- `effective_from`.
- `content_hash` (sudah ada).
- `is_active` untuk kompatibilitas.

### 5.3 `research_settings`

Field yang perlu dipertimbangkan:

- `region_definition`.
- `study_start_date`, `study_end_date`.
- `age_verification_method`.
- `access_mode` (misalnya tautan/kode peserta; bukan publik).
- `access_code_hash` untuk mode kode akses.
- `ethics_confirmation_status`.
- `ethics_reference` (opsional; jangan diisi jika belum ada).
- `retention_months` (sudah ada).
- `deletion_procedure`.
- `public_contact`/`research_contact` bila diperlukan.

### 5.4 Audit

Aktivasi, penonaktifan, perubahan status, dan perubahan teks harus masuk `audit_logs`. Minimal mencatat:

- aktor;
- waktu;
- jenis perubahan;
- nilai lama dan baru;
- versi instrumen/consent;
- alasan.

---

## 6. Alur responden yang diusulkan

1. Responden membuka halaman penelitian melalui tautan/kode peserta yang dibatasi.
2. Jika instrumen belum `active`, tampil status belum dibuka; tidak ada formulir.
3. Jika aktif, tampil lembar informasi dan pilihan setuju/tolak.
4. Jika menolak, proses berhenti; tidak ada jawaban yang disimpan.
5. Jika setuju, sistem mencatat `consent_version_id` dan waktu persetujuan.
6. Baru setelah itu responden dapat mengisi data dan DASS-21.
7. Setelah pengiriman, responden hanya melihat konfirmasi pengiriman.
8. Skor, kategori, dan hasil skrining hanya terlihat di area admin yang dilindungi.
9. Tidak ada tampilan “Anda mengalami depresi/kecemasan/stres” atau interpretasi otomatis kepada responden.

---

## 7. Data sintetis

- Data sintetis hanya untuk pengujian pipeline, tampilan, dan validasi teknis.
- Data sintetis wajib diberi penanda yang jelas dan tidak boleh dicampur dengan data nyata.
- Data sintetis tidak boleh dihitung sebagai data penelitian atau dipakai untuk mengklaim performa model.
- Dashboard produksi harus dapat mengecualikan data sintetis dari statistik penelitian.

---

## 8. Status implementasi

Sudah diterapkan:

- Enum `InstrumentStatus` dengan nilai `draft`, `pending_verification`, `verified`, `active`.
- Enum `ConsentStatus` dengan nilai `draft`, `incomplete`, `pending_ethics`, `ready_for_review`, `approved_for_use`.
- Kolom status dan metadata verifikasi pada `instrument_versions` dan `consent_versions`.
- Kolom definisi lokasi, periode penelitian, metode verifikasi usia, mode akses, status etik, referensi etik, dan prosedur penghapusan pada `research_settings`.
- `ResearchReadinessService` untuk memeriksa gerbang aktivasi tanpa membuka formulir.
- `Dass21Scorer` untuk menghitung skor mentah, skor akhir, dan kategori per subskala.
- Tampilan dashboard admin menampilkan daftar hal yang masih menahan aktivasi.
- Halaman `/admin/setup` untuk pengaturan penelitian, metadata instrumen, dan teks persetujuan.
- Aktivasi instrumen dan consent dilakukan lewat aksi terpisah; record aktif tidak dapat diedit sebelum dinonaktifkan.
- Validasi menolak status `active` dari form, metadata instrumen yang belum lengkap, consent berplaceholder, dan mode akses publik.
- `AuditLogger` mencatat perubahan pengaturan, pembuatan/perubahan versi, serta aktivasi/penonaktifan instrumen dan consent.
- Feature test `AdminResearchSetupTest` mencakup akses admin, validasi, aktivasi, penonaktifan versi lama, dan larangan edit record aktif.
- Migration `2026_10_21_000012_add_questionnaire_content_and_access_fields.php` menambahkan teks butir, instruksi, opsi jawaban, hash kode akses, dan usia saat pengiriman.
- Migration `2026_10_21_000013_align_research_decisions.php` menambahkan `submissions.subdistrict`, memetakan status consent lama, dan mengisi default metode verifikasi usia.
- Penyimpanan kecamatan opsional ditampilkan di area admin dan disertakan dalam ekspor CSV.
- Metode `birth_year_plus_age_confirmation` meminta usia numerik dan memeriksa selisih maksimal satu tahun terhadap tahun lahir.
- Gerbang MSPSS menolak aktivasi jika `social_support_score` aktif atau dijadikan fitur model.
- `Dass21InstrumentSeeder` memuat 21 butir dari dokumen Damanik yang dipetakan ke DASS21 English response form; status tetap `pending_verification` dan tidak aktif.
- Formulir responden tersedia melalui `/kuesioner` dan hanya terbuka jika seluruh gerbang siap.
- Akses peserta memakai tautan bertanda tangan atau kode akses; sesi akses berlaku 4 jam.
- Alur responden mencakup persetujuan, kelayakan, formulir DASS-21 + faktor, penyimpanan skor, dan konfirmasi tanpa menampilkan hasil.
- Area admin `/admin/submissions` menampilkan data responden dan mengekspor dataset CSV valid.
- Feature test `QuestionnaireFlowTest` dan `AdminSubmissionsTest` mencakup akses tertutup, tautan/kode, alur lengkap, penyimpanan skor, penyimpanan kecamatan, tampilan admin, dan ekspor.
- Suite pengujian: **54 tes lulus**, **307 assertion**; Pint dan Vite build lulus.

Belum diterapkan atau masih perlu ditinjau:

- Teks 21 butir masih berstatus `pending_verification` sampai disetujui peneliti/dosen pembimbing; jangan aktifkan sebelum itu.
- Metode verifikasi usia sudah tersedia secara teknis, tetapi pilihan metodologis final tetap harus dikonfirmasi peneliti. `age_years` meminta usia saat ini, `date_of_birth` menghitung usia, dan `birth_year_plus_age_confirmation` meminta usia yang dinyatakan serta memeriksanya terhadap tahun lahir.
- Consent final tanpa placeholder belum tersedia.
- `is_active` masih dipertahankan bersama `status`; aktivasi mensyaratkan keduanya.
- Aktivasi masih dapat dilakukan admin tanpa persetujuan eksplisit peneliti pada layar terpisah; keputusan ini perlu ditinjau sebelum data nyata.
- Pelatihan Random Forest belum diimplementasikan karena dataset dan keputusan metodologi belum tersedia.

Formulir tetap tidak boleh dibuka sampai seluruh gerbang pada bagian 4 dan input pada `docs/PENDING_RESEARCH_INPUTS.md` terpenuhi.

---

## 9. Kriteria penerimaan sebelum implementasi

- [ ] Peneliti menyetujui status dan urutan transisi.
- [ ] Peneliti menyetujui daftar gerbang aktivasi.
- [ ] Versi DASS-21 final dan sumbernya tersedia.
- [ ] Consent final tanpa placeholder tersedia.
- [ ] Metode verifikasi usia dan definisi lokasi disetujui.
- [ ] Prosedur etik dikonfirmasi.
- [ ] Rencana perubahan skema dan migration disetujui.
- [ ] Rencana pengujian untuk mencegah aktivasi yang tidak sah disetujui.
