<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            // ========================= ADMIN =========================
            [
                'username' => 'admin',
                'password' => Hash::make('pwa'),
                'role' => 'admin',
                'member_id' => null,
                'doctor_id' => null,
            ],

            // ========================= MEMBER ========================
            [
                'username' => 'member',
                'password' => Hash::make('pwm'),
                'role' => 'member',
                'member_id' => 1,
                'doctor_id' => null,
            ],
            [
                'username' => 'member2',
                'password' => Hash::make('pmember2'),
                'role' => 'member',
                'member_id' => 2,
                'doctor_id' => null,
            ],
            [
                'username' => 'member3',
                'password' => Hash::make('pmember3'),
                'role' => 'member',
                'member_id' => 3,
                'doctor_id' => null,
            ],
            [
                'username' => 'member4',
                'password' => Hash::make('pmember4'),
                'role' => 'member',
                'member_id' => 4,
                'doctor_id' => null,
            ],
            [
                'username' => 'member5',
                'password' => Hash::make('pmember5'),
                'role' => 'member',
                'member_id' => 5,
                'doctor_id' => null,
            ],

            // ========================= DOCTOR ========================
            [
                'username' => 'dokter',
                'password' => Hash::make('pwd'),
                'role' => 'doctor',
                'doctor_id' => 1,
                'member_id' => null,
            ],
            [
                'username' => 'dokter2',
                'password' => Hash::make('pdokter2'),
                'role' => 'doctor',
                'doctor_id' => 2,
                'member_id' => null,
            ],
            [
                'username' => 'dokter3',
                'password' => Hash::make('pdokter3'),
                'role' => 'doctor',
                'doctor_id' => 3,
                'member_id' => null,
            ],
            [
                'username' => 'dokter4',
                'password' => Hash::make('pdokter4'),
                'role' => 'doctor',
                'doctor_id' => 4,
                'member_id' => null,
            ],
            [
                'username' => 'dokter5',
                'password' => Hash::make('pdokter5'),
                'role' => 'doctor',
                'doctor_id' => 5,
                'member_id' => null,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'member_id' => $user['member_id'],
                    'doctor_id' => $user['doctor_id'],
                ]
            );
        }
    }
}
