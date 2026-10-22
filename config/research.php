<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Identitas penelitian
    |--------------------------------------------------------------------------
    |
    | Nilai kontak peneliti dan kriteria Gen Z tetap disimpan di tabel
    | research_settings. File ini hanya menyimpan definisi yang dipakai kode.
    |
    */

    'title' => 'Klasifikasi Mental Health Menggunakan Algoritma Random Forest (Studi pada Gen Z di Wonosobo)',
    'region' => 'Kabupaten Wonosobo',
    'minimum_age' => 18,
    'genz_operational_start' => 1997,
    'genz_operational_end' => 2008,
    'age_verification_method' => 'birth_year_plus_age_confirmation',

    'subdistricts' => [
        'wadaslintang' => 'Wadaslintang',
        'kepil' => 'Kepil',
        'sapuran' => 'Sapuran',
        'kalibawang' => 'Kalibawang',
        'kaliwiro' => 'Kaliwiro',
        'leksono' => 'Leksono',
        'sukoharjo' => 'Sukoharjo',
        'selomerto' => 'Selomerto',
        'kalikajar' => 'Kalikajar',
        'kertek' => 'Kertek',
        'wonosobo' => 'Wonosobo',
        'watumalang' => 'Watumalang',
        'mojotengah' => 'Mojotengah',
        'garung' => 'Garung',
        'kejajar' => 'Kejajar',
    ],

    'consent_required_placeholders' => [
        '[NAMA PENELITI]',
        '[PROGRAM STUDI]',
        '[FAKULTAS]',
        '[NAMA UNIVERSITAS]',
        '[NAMA DOSEN PEMBIMBING]',
        '[EMAIL KONTAK PENELITI]',
        '[NOMOR KONTAK PENELITI, JIKA DISEDIAKAN]',
        '[KONTAK KOMITE ETIK, JIKA BERLAKU]',
        '[NOMOR/TANGGAL PERSETUJUAN ETIK, JIKA DIPERSYARATKAN]',
        '[MASA PENYIMPANAN DATA]',
        '[PROSEDUR PENGHAPUSAN DATA]',
    ],

    /*
    |--------------------------------------------------------------------------
    | Definisi fitur
    |--------------------------------------------------------------------------
    |
    | Daftar ini adalah sumber konfigurasi untuk formulir, validasi, ekspor,
    | dan pemilihan fitur model. Fitur yang belum disetujui dosen pembimbing
    | diberi nilai active = false dan tidak boleh dipakai model.
    |
    */

    'features' => [
        'age_years' => [
            'label' => 'Usia',
            'type' => 'integer',
            'source' => 'derived',
            'required' => true,
            'active' => true,
            'model_feature' => true,
            'min' => 18,
            'max' => 120,
            'unit' => 'tahun',
            'operational_definition' => 'Usia yang dinyatakan responden saat mengirim kuesioner dan diperiksa terhadap tahun lahir.',
        ],
        'education_status' => [
            'label' => 'Status pendidikan',
            'type' => 'categorical',
            'source' => 'form',
            'required' => true,
            'active' => true,
            'model_feature' => true,
            'options' => [
                'tidak_sekolah' => 'Tidak pernah bersekolah',
                'sd' => 'SD/sederajat',
                'smp' => 'SMP/sederajat',
                'sma_smk' => 'SMA/SMK/sederajat',
                'd3' => 'D3',
                's1' => 'S1',
                's2_s3' => 'S2/S3',
                'lainnya' => 'Lainnya',
            ],
            'operational_definition' => 'Pendidikan terakhir atau jenjang yang sedang ditempuh.',
        ],
        'employment_status' => [
            'label' => 'Status pekerjaan',
            'type' => 'categorical',
            'source' => 'form',
            'required' => true,
            'active' => true,
            'model_feature' => true,
            'options' => [
                'pelajar_mahasiswa' => 'Pelajar/mahasiswa',
                'bekerja' => 'Bekerja',
                'wirausaha' => 'Wirausaha',
                'tidak_bekerja' => 'Tidak bekerja/mencari kerja',
                'lainnya' => 'Lainnya',
            ],
            'operational_definition' => 'Aktivitas utama responden saat ini.',
        ],
        'sleep_duration_hours' => [
            'label' => 'Durasi tidur',
            'type' => 'decimal',
            'source' => 'form',
            'required' => true,
            'active' => true,
            'model_feature' => true,
            'min' => 0,
            'max' => 24,
            'step' => 0.5,
            'unit' => 'jam per malam',
            'operational_definition' => 'Rata-rata durasi tidur per malam dalam 7 hari terakhir.',
        ],
        'physical_activity_days' => [
            'label' => 'Hari aktivitas fisik',
            'type' => 'integer',
            'source' => 'form',
            'required' => true,
            'active' => true,
            'model_feature' => true,
            'min' => 0,
            'max' => 7,
            'unit' => 'hari dalam 7 hari terakhir',
            'operational_definition' => 'Jumlah hari dengan aktivitas fisik sedang minimal 30 menit dalam 7 hari terakhir.',
        ],
        'social_media_hours_per_day' => [
            'label' => 'Durasi media sosial',
            'type' => 'decimal',
            'source' => 'form',
            'required' => true,
            'active' => true,
            'model_feature' => true,
            'min' => 0,
            'max' => 24,
            'step' => 0.5,
            'unit' => 'jam per hari',
            'operational_definition' => 'Rata-rata durasi penggunaan media sosial pribadi per hari dalam 7 hari terakhir.',
        ],
        'social_support_score' => [
            'label' => 'Dukungan sosial',
            'type' => 'integer',
            'source' => 'form',
            'required' => false,
            'active' => false,
            'model_feature' => false,
            'min' => 1,
            'max' => 5,
            'operational_definition' => 'Skor instrumen dukungan sosial yang telah disetujui dosen pembimbing.',
            'note' => 'Belum diaktifkan karena instrumen dukungan sosial belum ditetapkan.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Kolom yang dilarang masuk fitur model
    |--------------------------------------------------------------------------
    |
    | Kolom ini membocorkan target atau merupakan pengenal. Laravel dan
    | layanan Python harus menolak dataset yang memuat kolom-kolom ini.
    |
    */

    'forbidden_model_columns' => [
        'id',
        'submission_id',
        'birth_year',
        'consent_version_id',
        'consent_accepted_at',
        'data_status',
        'exclusion_reason',
        'submitted_at',
        'item_01', 'item_02', 'item_03', 'item_04', 'item_05', 'item_06', 'item_07',
        'item_08', 'item_09', 'item_10', 'item_11', 'item_12', 'item_13', 'item_14',
        'item_15', 'item_16', 'item_17', 'item_18', 'item_19', 'item_20', 'item_21',
        'depression_raw', 'depression_final', 'depression_category',
        'anxiety_raw', 'anxiety_final', 'anxiety_category',
        'stress_raw', 'stress_final', 'stress_category',
        'label_depresi', 'label_kecemasan', 'label_stres',
    ],

    'targets' => [
        'label_depresi' => [
            'target' => 'depresi',
            'label' => 'Depresi',
            'category_column' => 'depression_category',
        ],
        'label_kecemasan' => [
            'target' => 'kecemasan',
            'label' => 'Kecemasan',
            'category_column' => 'anxiety_category',
        ],
        'label_stres' => [
            'target' => 'stres',
            'label' => 'Stres',
            'category_column' => 'stress_category',
        ],
    ],

    'model' => [
        'test_size' => 0.20,
        'random_state' => 42,
        'cv_folds' => 5,
        'primary_metric' => 'f1_macro',
    ],
];
