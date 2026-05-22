<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [

            // ========================================= TEST =======================================

            [
                'username' => 'admin', // ============================== ADMIN ======================
                'password' => Hash::make('pwa'),
                'email' => 'admin@wfp.com',
                'phone_number' => '111100000001',
                'is_admin' => 1, 
                'member_id' => null,
                'doctor_id' => null,
            ],
            [
                'username' => 'member', // ============================== MEMBER ====================
                'password' => Hash::make('pwm'),
                'email' => 'member@wfp.com',
                'phone_number' => '222200000001',
                'is_admin' => 0, 
                'member_id' => 1,
                'doctor_id' => null,
            ],
            [
                'username' => 'dokter', // ============================== DOKTER ====================
                'password' => Hash::make('pwd'),
                'email' => 'dokter@wfp.com',
                'phone_number' => '333300000001',
                'is_admin' => 0,
                'member_id' => null,
                'doctor_id' => 1,
            ],

            // ======================================== DUMMY =======================================

            [
                'username' => 'member2', // ============================== MEMBER ===================
                'password' =>  Hash::make('pmember2'),
                'email' => 'member2@wfp.com',
                'phone_number' => '222200000002',
                'is_admin' => 0,
                'member_id' => 2,
                'doctor_id' => null,
            ],
            [
                'username' => 'member3', // ============================== MEMBER ===================
                'password' => Hash::make('pmember3'),
                'email' => 'member3@wfp.com',
                'phone_number' => '222200000003',
                'is_admin' => 0,
                'member_id' => 3,
                'doctor_id' => null,
            ],
            [
                'username' => 'member4', // ============================== MEMBER ===================
                'password' => Hash::make('pmember4'),
                'email' => 'member4@wfp.com',
                'phone_number' => '222200000004',
                'is_admin' => 0,
                'member_id' => 4,
                'doctor_id' => null,
            ],
            [
                'username' => 'member5', // ============================== MEMBER ===================
                'password' => Hash::make('pmember5'),
                'email' => 'member5@wfp.com',
                'phone_number' => '222200000005',
                'is_admin' => 0,
                'member_id' => 5,
                'doctor_id' => null,
            ],
            [
                'username' => 'dokter2', // ============================== DOKTER ===================
                'password' => Hash::make('pdokter2'),
                'email' => 'dokter2@wfp.com',
                'phone_number' => '333300000002',
                'is_admin' => 0,
                'member_id' => null,
                'doctor_id' => 2,
            ],
            [
                'username' => 'dokter3', // ============================== DOKTER ===================
                'password' => Hash::make('pdokter3'),
                'email' => 'dokter3@wfp.com',
                'phone_number' => '333300000003',
                'is_admin' => 0,
                'member_id' => null,
                'doctor_id' => 3,
            ],
            [
                'username' => 'dokter4', // ============================== DOKTER ===================
                'password' => Hash::make('pdokter4'),
                'email' => 'dokter4@wfp.com',
                'phone_number' => '333300000004',
                'is_admin' => 0,
                'member_id' => null,
                'doctor_id' => 4,
            ],
            [
                'username' => 'dokter5', // ============================== DOKTER ===================
                'password' => Hash::make('pdokter5'),
                'email' => 'dokter5@wfp.com',
                'phone_number' => '333300000005',
                'is_admin' => 0,
                'member_id' => null,
                'doctor_id' => 5,
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
