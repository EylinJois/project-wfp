<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Konsultasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $konsultasi1 = Konsultasi::first();
        $konsultasi2 = Konsultasi::skip(1)->first();

        if (!$konsultasi1 || !$konsultasi2) {
            $this->command->warn('Data konsultasi kurang. Jalankan KonsultasiSeeder dulu.');
            return;
        }

        $data = [
            [
                'konsultasi_id' => $konsultasi1->id,
                'member_id'     => $konsultasi1->member_id,
                'dokter_id'     => $konsultasi1->dokter_id,
                'pesan'         => 'Selamat pagi dok, kepala saya terasa sangat pusing sejak kemarin malam.',
                'waktu_kirim'   => date('Y-m-d H:i:s', strtotime($konsultasi1->waktu . ' +1 minute')),
            ],
            [
                'konsultasi_id' => $konsultasi1->id,
                'member_id'     => $konsultasi1->member_id,
                'dokter_id'     => $konsultasi1->dokter_id,
                'pesan'         => 'Selamat pagi. Apakah ada gejala lain yang menyertai, seperti mual atau pandangan kabur?',
                'waktu_kirim'   => date('Y-m-d H:i:s', strtotime($konsultasi1->waktu . ' +3 minutes')),
            ],
            [
                'konsultasi_id' => $konsultasi1->id,
                'member_id'     => $konsultasi1->member_id,
                'dokter_id'     => $konsultasi1->dokter_id,
                'pesan'         => 'Ada dok, sedikit mual kalau habis makan. Pandangan sih aman.',
                'waktu_kirim'   => date('Y-m-d H:i:s', strtotime($konsultasi1->waktu . ' +5 minutes')),
            ],

            [
                'konsultasi_id' => $konsultasi2->id,
                'member_id'     => $konsultasi2->member_id,
                'dokter_id'     => $konsultasi2->dokter_id,
                'pesan'         => 'Halo dokter, permisi. Tangan saya tiba-tiba gatal dan merah.',
                'waktu_kirim'   => date('Y-m-d H:i:s', strtotime($konsultasi2->waktu . ' +2 minutes')),
            ],
            [
                'konsultasi_id' => $konsultasi2->id,
                'member_id'     => $konsultasi2->member_id,
                'dokter_id'     => $konsultasi2->dokter_id,
                'pesan'         => 'Halo. Sebelumnya apakah Anda baru saja mengonsumsi makanan laut (seafood)?',
                'waktu_kirim'   => date('Y-m-d H:i:s', strtotime($konsultasi2->waktu . ' +4 minutes')),
            ],
        ];

        foreach ($data as $chat) {
            Chat::create($chat);
        }
    }
}
