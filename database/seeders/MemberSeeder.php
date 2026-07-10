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
        $members = [
            [
                'fullname' => 'Budi Setiawan',
                'birth_of_date' => '1995-05-12',
                'photo' => 'member_budi.jpg',
            ],
            [
                'fullname' => 'Siti Aminah',
                'birth_of_date' => '1998-08-24',
                'photo' => 'member_siti.jpg',
            ],
            [
                'fullname' => 'Andi Wijaya',
                'birth_of_date' => '2001-01-15',
                'photo' => 'member_andi.jpg',
            ],
            [
                'fullname' => 'Lestari Putri',
                'birth_of_date' => '1992-11-30',
                'photo' => 'member_lestari.jpg',
            ],
            [
                'fullname' => 'Rizky Pratama',
                'birth_of_date' => '1997-03-05',
                'photo' => 'member_rizky.jpg',
            ],
        ];

        foreach ($members as $member) {
            DB::table('members')->updateOrInsert(
                [
                    'fullname' => $member['fullname'],
                    'birth_of_date' => $member['birth_of_date'],
                ],
                [
                    'photo' => $member['photo'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
