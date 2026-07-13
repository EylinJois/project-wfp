<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberIds = Member::pluck('id')->toArray();
        $doctorIds = Doctor::pluck('id')->toArray();

        if (empty($memberIds) || empty($doctorIds)) {
            $this->command->warn('Seeding Consultation dibatalkan karena tabel member atau doctor kosong.');

            return;
        }

        $consultations = [
            [
                'time' => date('Y-m-d 10:00:00', strtotime('-2 days')),
                'status' => 'done',
                'consultation_type' => 'general consultation',
                'notes' => 'Pasien mengeluh pusing dan mual sejak pagi. Disarankan istirahat cukup.',
                'member_id' => $memberIds[0],
                'doctor_id' => $doctorIds[0],
            ],
            [
                'time' => date('Y-m-d 14:30:00', strtotime('-1 days')),
                'status' => 'done',
                'consultation_type' => 'specialist consultation',
                'notes' => 'Konsultasi pasca operasi. Luka mengering dengan baik, lanjut obat jalan.',
                'member_id' => $memberIds[1],
                'doctor_id' => $doctorIds[1],
            ],
            [
                'time' => date('Y-m-d 09:00:00', strtotime('-5 days')),
                'status' => 'done',
                'consultation_type' => 'general consultation',
                'notes' => 'Keluhan gatal-gatal di area lengan setelah makan seafood.',
                'member_id' => $memberIds[2],
                'doctor_id' => $doctorIds[2],
            ],
            [
                'time' => date('Y-m-d 09:00:00', strtotime('+2 days')),
                'status' => 'pending',
                'consultation_type' => 'general consultation',
                'notes' => 'Pasien tidak hadir pada jam yang ditentukan.',
                'member_id' => $memberIds[3],
                'doctor_id' => $doctorIds[3],
            ],
            [
                'time' => date('Y-m-d 19:00:00', strtotime('-3 days')),
                'status' => 'ongoing',
                'consultation_type' => 'specialist consultation',
                'notes' => 'Anak demam 38 derajat. Diberikan resep paracetamol cair.',
                'member_id' => $memberIds[4],
                'doctor_id' => $doctorIds[4],
            ],
        ];

        foreach ($consultations as $consultation) {
            DB::table('consultations')->updateOrInsert(
                ['notes' => $consultation['notes']],
                array_merge($consultation, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

    }
}
