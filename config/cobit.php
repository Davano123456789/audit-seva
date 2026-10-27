<?php

/*
|--------------------------------------------------------------------------
| Konfigurasi Penilaian COBIT 2019
|--------------------------------------------------------------------------
| Sumber: ISACA (2018), COBIT 2019 Framework: Introduction and Methodology,
| sesuai Tabel 2.1 - 2.4 pada proposal.
*/

return [

    /*
    | Tingkat capability level proses (Tabel 2.1 & 2.3).
    */
    'levels' => [
        0 => [
            'name' => 'Incomplete Process',
            'description' => 'Proses tidak memiliki kapabilitas dasar dan mencerminkan pendekatan yang belum lengkap dalam memenuhi tujuan tata kelola dan manajemen.',
        ],
        1 => [
            'name' => 'Performed Process',
            'description' => 'Proses kurang lebih telah mencapai tujuannya melalui penerapan rangkaian aktivitas yang belum lengkap, bersifat awal dan intuitif, serta belum terorganisasi dengan baik.',
        ],
        2 => [
            'name' => 'Managed Process',
            'description' => 'Proses telah mencapai tujuannya melalui penerapan aktivitas dasar yang lengkap, direncanakan, dipantau, dan dikelola dengan baik.',
        ],
        3 => [
            'name' => 'Established Process',
            'description' => 'Proses mencapai tujuannya dengan cara yang lebih terorganisasi menggunakan aset organisasi; proses telah terdefinisi, distandarkan, dan diterapkan secara konsisten.',
        ],
        4 => [
            'name' => 'Predictable Process',
            'description' => 'Proses telah mencapai tujuannya, terdefinisi dengan baik, serta kinerjanya diukur dan dikendalikan secara kuantitatif.',
        ],
        5 => [
            'name' => 'Optimizing Process',
            'description' => 'Proses telah mencapai tujuannya, terdefinisi, terukur, dan terus-menerus ditingkatkan untuk memenuhi tujuan organisasi saat ini maupun yang akan datang.',
        ],
    ],

    /*
    | Level pertama yang dinilai. Level 0 dan 1 tidak memiliki pertanyaan.
    */
    'start_level' => 2,
    'max_level' => 5,

    /*
    | Skala penilaian (rating scale) pencapaian aktivitas (Tabel 2.2).
    | Diurutkan dari batas tertinggi. "min" = batas bawah persentase (inklusif).
    */
    'ratings' => [
        'F' => ['name' => 'Fully Achieved', 'label' => 'Tercapai penuh', 'min' => 85, 'color' => 'green'],
        'L' => ['name' => 'Largely Achieved', 'label' => 'Sebagian besar tercapai', 'min' => 50, 'color' => 'blue'],
        'P' => ['name' => 'Partially Achieved', 'label' => 'Sebagian tercapai', 'min' => 15, 'color' => 'amber'],
        'N' => ['name' => 'Not Achieved', 'label' => 'Tidak tercapai', 'min' => 0, 'color' => 'red'],
    ],

    /*
    | Jumlah angka desimal maturity index, mengikuti skripsi: 17 / 6 = 2,8.
    | Nilai dibulatkan dulu ke jumlah desimal ini, baru dipetakan ke maturity level.
    */
    'maturity_decimals' => 1,

    /*
    | Pembulatan maturity index ke maturity level (Tabel 2.4).
    | "max" = batas atas index (inklusif), contoh: 2,83 -> Level 3.
    */
    'maturity_scale' => [
        ['max' => 0.50, 'level' => 0],
        ['max' => 1.50, 'level' => 1],
        ['max' => 2.50, 'level' => 2],
        ['max' => 3.50, 'level' => 3],
        ['max' => 4.50, 'level' => 4],
        ['max' => 5.00, 'level' => 5],
    ],

    /*
    | File bukti (evidence) yang boleh diunggah asesor.
    */
    'evidence' => [
        'mimes' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'png', 'jpg', 'jpeg'],
        'max_kb' => 5120,
    ],
];
