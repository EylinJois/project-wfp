<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'fullname' => 'dr. Kevin Pratama',
                'email' => 'kevin.pratama@example.com',
                'phone_number' => '081234567890',
                'sip' => 'SIP/101/A1/2024',
                'experience' => '3 Tahun',
                'photo' => 'dokter_kevin.png',
                'specialty_id' => 4,
                'start_time' => '08:00:00',
                'end_time' => '15:00:00',
            ],
            [
                'fullname' => 'drg. Rina Melati',
                'email' => 'rina.melati@example.com',
                'phone_number' => '081234567891',
                'sip' => 'SIP/102/B1/2021',
                'experience' => '6 Tahun',
                'photo' => 'dokter_rina.png',
                'specialty_id' => 2,
                'start_time' => '09:00:00',
                'end_time' => '16:00:00',
            ],
            [
                'fullname' => 'dr. Hendra Saputra, Sp.A',
                'email' => 'hendra.saputra@example.com',
                'phone_number' => '081234567892',
                'sip' => 'SIP/103/C1/2018',
                'experience' => '12 Tahun',
                'photo' => 'dokter_hendra.png',
                'specialty_id' => 1,
                'start_time' => '10:00:00',
                'end_time' => '14:00:00',
            ],
            [
                'fullname' => 'dr. Gita Saraswati, Sp.S',
                'email' => 'gita.saraswati@example.com',
                'phone_number' => '081234567893',
                'sip' => 'SIP/104/D1/2020',
                'experience' => '8 Tahun',
                'photo' => 'dokter_gita.jpg',
                'specialty_id' => 5,
                'start_time' => '16:00:00',
                'end_time' => '21:00:00',
            ],
            [
                'fullname' => 'dr. Ahmad Fauzi, Sp.PD',
                'email' => 'ahmad.fauzi@example.com',
                'phone_number' => '081234567894',
                'sip' => 'SIP/105/E1/2016',
                'experience' => '15 Tahun',
                'photo' => 'dokter_ahmad.jpg',
                'specialty_id' => 6,
                'start_time' => '08:00:00',
                'end_time' => '13:00:00',
            ],
        ];

        foreach ($doctors as $doctor) {
            DB::table('doctors')->updateOrInsert(
                [
                    'sip' => $doctor['sip'],
                    'email' => $doctor['email'],
                    'phone_number' => $doctor['phone_number'],
                ],
                array_merge($doctor, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
