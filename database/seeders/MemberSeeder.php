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
        DB::table('members')->insert([
            [
                'created_at' => now(),
                'updated_at' => now(),
                'fullname' => 'Budi Setiawan',
                'birth_of_date' => '1995-05-12',
                'photo' => 'member_budi.jpg',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'fullname' => 'Siti Aminah',
                'birth_of_date' => '1998-08-24',
                'photo' => 'member_siti.jpg',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'fullname' => 'Andi Wijaya',
                'birth_of_date' => '2001-01-15',
                'photo' => 'member_andi.jpg',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'fullname' => 'Lestari Putri',
                'birth_of_date' => '1992-11-30',
                'photo' => 'member_lestari.jpg',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'fullname' => 'Rizky Pratama',
                'birth_of_date' => '1997-03-05',
                'photo' => 'member_rizky.jpg',
            ]
        ]);
    }
}
