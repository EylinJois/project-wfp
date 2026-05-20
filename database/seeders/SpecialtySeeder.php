<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('specialties')->insert([
            ['name' => 'Spesialis Anak'],
            ['name' => 'Dokter Gigi'],
            ['name' => 'Spesialis Jantung dan Pembuluh Darah'],
            ['name' => 'Dokter Umum'],
            ['name' => 'Spesialis Saraf'],
            ['name' => 'Spesialis Penyakit Dalam'],
            ['name' => 'Spesialis Obsteri dan Ginekologi'],
            ['name' => 'Spesialis THT-KL'],
            ['name' => 'Spesialis Mata'],
            ['name' => 'Psikiater'],
        ]);
    }
}
