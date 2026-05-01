<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('member')->insert([
            [
                'nama_lengkap' => 'Margason Demo Member',
                'tanggal_lahir' => '1990-05-15',
                'foto' => 'member_margason.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Megan Demo Member',
                'tanggal_lahir' => '1992-08-22',
                'foto' => 'member_megan.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
