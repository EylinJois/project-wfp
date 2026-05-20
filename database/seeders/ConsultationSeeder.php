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

        DB::table('consultations')->insert([
            [
                'time' => date('Y-m-d 10:00:00', strtotime('-2 days')),
                'status' => 'Chat',
                'consultation_type' => 'done',
                'notes' => 'Pasien mengeluh pusing dan mual sejak pagi. Disarankan istirahat cukup.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'doctor_id' => $doctorIds[array_rand($doctorIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'time' => date('Y-m-d 14:30:00', strtotime('-1 days')),
                'status' => 'Chat',
                'consultation_type' => 'done',
                'notes' => 'Konsultasi pasca operasi. Luka mengering dengan baik, lanjut obat jalan.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'doctor_id' => $doctorIds[array_rand($doctorIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'time' => date('Y-m-d H:i:s', strtotime('+2 hours')),
                'status' => 'Video',
                'consultation_type' => 'done',
                'notes' => 'Keluhan gatal-gatal di area lengan setelah makan seafood.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'doctor_id' => $doctorIds[array_rand($doctorIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'time' => date('Y-m-d 09:00:00', strtotime('-5 days')),
                'status' => 'Chat',
                'consultation_type' => 'none',
                'notes' => 'Pasien tidak hadir pada jam yang ditentukan.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'doctor_id' => $doctorIds[array_rand($doctorIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'time' => date('Y-m-d 19:00:00', strtotime('-3 days')),
                'status' => 'video',
                'consultation_type' => 'ongoing',
                'notes' => 'Anak demam 38 derajat. Diberikan resep paracetamol cair.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'doctor_id' => $doctorIds[array_rand($doctorIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

    }
}
