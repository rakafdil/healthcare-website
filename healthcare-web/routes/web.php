<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/sistem-pakar', function () {
    return view('sistem-pakar', [
        'steps' => [
            'Pastikan Anda telah daftar dan masuk ke sistem, jika belum Anda dapat mendaftar terlebih dahulu.',
            'Jika sudah, Anda dapat menekan tombol di sebelah untuk melanjutkan pengecekan.',
            'Masukkan informasi Anda yang telah diminta oleh sistem.',
            'Masukkan gejala-gejala yang Anda alami.',
            'Sistem lalu menampilkan kondisi-kondisi yang mungkin terjadi pada Anda.'
        ]
    ]);
});

Route::get('/sistem-pakar/{user_id}', function ($user_id) {
    $history_penyakit = [
        [
            'user_id' => 1,
            'history_penyakit' => [
                'history1' => [
                    'tanggal' => '2023-10-01',
                    'waktu' => '10:00',
                ],
                'history2' => [
                    'tanggal' => '2023-10-02',
                    'waktu' => '11:00',
                ],
                'history3' => [
                    'tanggal' => '2023-10-03',
                    'waktu' => '12:00',
                ],
            ]
        ],
        [
            'user_id' => 2,
            'history_penyakit' => [
                'history1' => [
                    'tanggal' => '2023-10-04',
                    'waktu' => '13:00',
                ],
                'history2' => [
                    'tanggal' => '2023-10-05',
                    'waktu' => '14:00',
                ],
                'history3' => [
                    'tanggal' => '2023-10-06',
                    'waktu' => '15:00',
                ],
            ]
        ]
    ];

    $user_history = Arr::first($history_penyakit, fn($history) => $history['user_id'] == $user_id);

    dd($user_history);

    return view('sistem-pakar');
});

Route::get('/rumah-sakit', function () {
    return view('rumah-sakit');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/masuk', function () {
    return view('masuk');
});
