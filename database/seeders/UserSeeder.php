<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates fixed demo accounts for testing:
     * - Admin: is_admin
     * - Margason: Member role (member_id = 1)
     * - Megan: Member role (member_id = 2)
     * - Elly: Dokter role (dokter_id = 1)
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'email' => 'admin@wfp.com',
                'nomor_telepon' => '085200000001',
                'is_admin' => true,
                'member_id' => null,
                'dokter_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'margason',
                'password' => Hash::make('password123'),
                'email' => 'margason@wfp.com',
                'nomor_telepon' => '085200000002',
                'is_admin' => false,
                'member_id' => 1, // Links to first member from MemberSeeder
                'dokter_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'megan',
                'password' => Hash::make('password123'),
                'email' => 'megan@wfp.com',
                'nomor_telepon' => '085200000003',
                'is_admin' => false,
                'member_id' => 2, // Links to second member from MemberSeeder
                'dokter_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'elly',
                'password' => Hash::make('password123'),
                'email' => 'elly@wfp.com',
                'nomor_telepon' => '085200000004',
                'is_admin' => false,
                'member_id' => null,
                'dokter_id' => 1, // Links to first dokter from DokterSeeder
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
