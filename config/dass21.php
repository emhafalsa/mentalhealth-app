<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pemetaan butir DASS-21
    |--------------------------------------------------------------------------
    |
    | Pemetaan ini mengikuti urutan baku DASS-21. Teks butir dan terjemahan
    | resmi tidak disimpan di file ini. Simpan pemetaan dan ambang final di
    | tabel instrument_versions setelah disetujui dosen pembimbing.
    |
    */

    'code' => 'dass21',
    'locale' => 'id',
    'item_count' => 21,
    'score_multiplier' => 2,

    'instructions' => 'Kuesioner ini terdiri dari berbagai pernyataan yang mungkin sesuai dengan pengalaman Anda dalam menghadapi situasi hidup sehari-hari. Bacalah setiap pernyataan dan pilihlah jawaban yang paling sesuai dengan pengalaman Anda selama satu minggu belakangan ini. Tidak ada jawaban yang benar atau salah. Jawablah berdasarkan keadaan diri Anda yang sesungguhnya dan jangan menghabiskan terlalu banyak waktu pada satu pernyataan.',

    'response_options' => [
        0 => 'Tidak sesuai dengan saya sama sekali, atau tidak pernah.',
        1 => 'Sesuai dengan saya sampai tingkat tertentu, atau kadang-kadang.',
        2 => 'Sesuai dengan saya sampai batas yang dapat dipertimbangkan, atau lumayan sering.',
        3 => 'Sangat sesuai dengan saya, atau sering sekali.',
    ],

    'item_subscale_map' => [
        'depression' => [3, 5, 10, 13, 16, 17, 21],
        'anxiety' => [2, 4, 7, 9, 15, 19, 20],
        'stress' => [1, 6, 8, 11, 12, 14, 18],
    ],

    'subscale_labels' => [
        'depression' => 'Depresi',
        'anxiety' => 'Kecemasan',
        'stress' => 'Stres',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ambang kategori
    |--------------------------------------------------------------------------
    |
    | Kategori ditentukan dari skor akhir (skor mentah x 2). Nilai max null
    | berarti tidak ada batas atas.
    |
    */

    'severity_thresholds' => [
        'depression' => [
            ['min' => 0, 'max' => 9, 'category' => 'normal'],
            ['min' => 10, 'max' => 13, 'category' => 'ringan'],
            ['min' => 14, 'max' => 20, 'category' => 'sedang'],
            ['min' => 21, 'max' => 27, 'category' => 'berat'],
            ['min' => 28, 'max' => null, 'category' => 'sangat_berat'],
        ],
        'anxiety' => [
            ['min' => 0, 'max' => 7, 'category' => 'normal'],
            ['min' => 8, 'max' => 9, 'category' => 'ringan'],
            ['min' => 10, 'max' => 14, 'category' => 'sedang'],
            ['min' => 15, 'max' => 19, 'category' => 'berat'],
            ['min' => 20, 'max' => null, 'category' => 'sangat_berat'],
        ],
        'stress' => [
            ['min' => 0, 'max' => 14, 'category' => 'normal'],
            ['min' => 15, 'max' => 18, 'category' => 'ringan'],
            ['min' => 19, 'max' => 25, 'category' => 'sedang'],
            ['min' => 26, 'max' => 33, 'category' => 'berat'],
            ['min' => 34, 'max' => null, 'category' => 'sangat_berat'],
        ],
    ],

    'response_values' => [0, 1, 2, 3],
];
