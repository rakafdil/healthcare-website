<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SistemPakar extends Model
{
    protected $table = 'sistem_pakar';

    public static function history(): array
    {
        return [

            [
                'user_id' => 1,
                'history_penyakit' => [
                    '1' => [
                        'tanggal' => '2023-10-01',
                        'waktu' => '10:00',
                    ],
                    '2' => [
                        'tanggal' => '2023-10-02',
                        'waktu' => '11:00',
                    ],
                    '3' => [
                        'tanggal' => '2023-10-03',
                        'waktu' => '12:00',
                    ],
                ]
            ],
            [
                'user_id' => 2,
                'history_penyakit' => [
                    '1' => [
                        'tanggal' => '2023-10-04',
                        'waktu' => '13:00',
                    ],
                    '2' => [
                        'tanggal' => '2023-10-05',
                        'waktu' => '14:00',
                    ],
                    '3' => [
                        'tanggal' => '2023-10-06',
                        'waktu' => '15:00',
                    ],
                ]
            ]

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
