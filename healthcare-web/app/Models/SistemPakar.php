<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SistemPakar extends Model
{
    public $steps = [
        '1. Pastikan Anda telah daftar dan masuk ke sistem, jika belum Anda dapat mendaftar terlebih dahulu.',
        '2. Jika sudah, Anda dapat menekan tombol di sebelah untuk melanjutkan pengecekan.',
        '3. Masukkan informasi Anda yang telah diminta oleh sistem.',
        '4. Masukkan gejala-gejala yang Anda alami.',
        '5. Sistem lalu menampilkan kondisi-kondisi yang mungkin terjadi pada Anda.'
    ];

    public static function history(): array
    {
        return [

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
    }

    public static function steps(): array
    {
        return [
            'steps' => (new self())->steps,
        ];
    }

    public static function getHistory(int $user_id): array
    {
        $history = Arr::first(static::history(), fn($history) => $history['user_id'] == $user_id);
        if (!$history) {
            abort(404);
        }
        return $history;
    }
}
