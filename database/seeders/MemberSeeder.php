<?php

namespace Database\Seeders;

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
                'created_at' => now(),
                'updated_at' => now(),
                'nama_lengkap' => 'Budi Setiawan',
                'tanggal_lahir' => '1995-05-12',
                'foto' => 'member_budi.jpg',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'nama_lengkap' => 'Siti Aminah',
                'tanggal_lahir' => '1998-08-24',
                'foto' => 'member_siti.jpg',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'nama_lengkap' => 'Andi Wijaya',
                'tanggal_lahir' => '2001-01-15',
                'foto' => 'member_andi.jpg',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'nama_lengkap' => 'Lestari Putri',
                'tanggal_lahir' => '1992-11-30',
                'foto' => 'member_lestari.jpg',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'nama_lengkap' => 'Rizky Pratama',
                'tanggal_lahir' => '1997-03-05',
                'foto' => 'member_rizky.jpg',
            ]
        ]);
    }
}
