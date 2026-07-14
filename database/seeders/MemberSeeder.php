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
                'email' => 'budi.setiawan@example.com',
                'phone_number' => '081234567890',
                'birth_of_date' => '1995-05-12',
                'photo' => 'member_budi.jpg',
            ],
            [
                'fullname' => 'Siti Aminah',
                'email' => 'siti.aminah@example.com',
                'phone_number' => '081234567891',
                'birth_of_date' => '1998-08-24',
                'photo' => 'member_siti.jpg',
            ],
            [
                'fullname' => 'Andi Wijaya',
                'email' => 'andi.wijaya@example.com',
                'phone_number' => '081234567892',
                'birth_of_date' => '2001-01-15',
                'photo' => 'member_andi.jpg',
            ],
            [
                'fullname' => 'Lestari Putri',
                'email' => 'lestari.putri@example.com',
                'phone_number' => '081234567893',
                'birth_of_date' => '1992-11-30',
                'photo' => 'member_lestari.jpg',
            ],
            [
                'fullname' => 'Rizky Pratama',
                'email' => 'rizky.pratama@example.com',
                'phone_number' => '081234567894',
                'birth_of_date' => '1997-03-05',
                'photo' => 'member_rizky.jpg',
            ],
        ];

        foreach ($members as $member) {
            DB::table('members')->updateOrInsert(
                [
                    'fullname' => $member['fullname'],
                    'email' => $member['email'],
                    'phone_number' => $member['phone_number'],
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
