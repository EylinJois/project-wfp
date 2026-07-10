<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultations = Consultation::where('status', 'done')
            ->orderBy('time')
            ->take(2)
            ->get();

        if ($consultations->count() < 2) {
            $this->command->warn('Data konsultasi done kurang. Jalankan ConsultationSeeder dulu.');
            return;
        }

        $messages = [
            [
                'consultation' => $consultations[0],
                'sender_role' => 'member',
                'chat' => 'Selamat pagi dok, kepala saya terasa sangat pusing sejak kemarin malam.',
                'minutes' => 1,
            ],
            [
                'consultation' => $consultations[0],
                'sender_role' => 'doctor',
                'chat' => 'Selamat pagi. Apakah ada gejala lain yang menyertai, seperti mual atau pandangan kabur?',
                'minutes' => 3,
            ],
            [
                'consultation' => $consultations[0],
                'sender_role' => 'member',
                'chat' => 'Ada dok, sedikit mual kalau habis makan. Pandangan sih aman.',
                'minutes' => 5,
            ],
            [
                'consultation' => $consultations[1],
                'sender_role' => 'member',
                'chat' => 'Halo dokter, permisi. Tangan saya tiba-tiba gatal dan merah.',
                'minutes' => 2,
            ],
            [
                'consultation' => $consultations[1],
                'sender_role' => 'doctor',
                'chat' => 'Halo. Sebelumnya apakah Anda baru saja mengonsumsi makanan laut (seafood)?',
                'minutes' => 4,
            ],
        ];

        foreach ($messages as $message) {
            Chat::updateOrCreate(
                [
                    'consultation_id' => $message['consultation']->id,
                    'chat' => $message['chat'],
                ],
                [
                    'member_id' => $message['consultation']->member_id,
                    'doctor_id' => $message['consultation']->doctor_id,
                    'sender_role' => $message['sender_role'],
                    'delivered_at' => Carbon::parse($message['consultation']->time)->addMinutes($message['minutes']),
                ]
            );
        }
    }
}
