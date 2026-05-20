<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Consultation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultation1 = Consultation::first();
        $consultation2 = Consultation::skip(1)->first();

        if (!$consultation1 || !$consultation2) {
            $this->command->warn('Data konsultasi kurang. Jalankan ConsultationSeeder dulu.');
            return;
        }

        $chats = [
            [
                'consultation_id' => $consultation1->id,
                'member_id'     => $consultation1->member_id,
                'doctor_id'     => $consultation1->doctor_id,
                'chat'         => 'Selamat pagi dok, kepala saya terasa sangat pusing sejak kemarin malam.',
                'delivered_at'   => date('Y-m-d H:i:s', strtotime($consultation1->waktu . ' +1 minute')),
            ],
            [
                'consultation_id' => $consultation1->id,
                'member_id'     => $consultation1->member_id,
                'doctor_id'     => $consultation1->doctor_id,
                'chat'         => 'Selamat pagi. Apakah ada gejala lain yang menyertai, seperti mual atau pandangan kabur?',
                'delivered_at'   => date('Y-m-d H:i:s', strtotime($consultation1->waktu . ' +3 minutes')),
            ],
            [
                'consultation_id' => $consultation1->id,
                'member_id'     => $consultation1->member_id,
                'doctor_id'     => $consultation1->doctor_id,
                'chat'         => 'Ada dok, sedikit mual kalau habis makan. Pandangan sih aman.',
                'delivered_at'   => date('Y-m-d H:i:s', strtotime($consultation1->waktu . ' +5 minutes')),
            ],

            [
                'consultation_id' => $consultation2->id,
                'member_id'     => $consultation2->member_id,
                'doctor_id'     => $consultation2->doctor_id,
                'chat'         => 'Halo dokter, permisi. Tangan saya tiba-tiba gatal dan merah.',
                'delivered_at'   => date('Y-m-d H:i:s', strtotime($consultation2->waktu . ' +2 minutes')),
            ],
            [
                'consultation_id' => $consultation2->id,
                'member_id'     => $consultation2->member_id,
                'doctor_id'     => $consultation2->doctor_id,
                'chat'         => 'Halo. Sebelumnya apakah Anda baru saja mengonsumsi makanan laut (seafood)?',
                'delivered_at'   => date('Y-m-d H:i:s', strtotime($consultation2->waktu . ' +4 minutes')),
            ],
        ];

        foreach ($chats as $chat) {
            Chat::create($chat);
        }
    }
}
