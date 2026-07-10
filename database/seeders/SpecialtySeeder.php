<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            'Spesialis Anak',
            'Dokter Gigi',
            'Spesialis Jantung dan Pembuluh Darah',
            'Dokter Umum',
            'Spesialis Saraf',
            'Spesialis Penyakit Dalam',
            'Spesialis Obsteri dan Ginekologi',
            'Spesialis THT-KL',
            'Spesialis Mata',
            'Psikiater',
        ];

        foreach ($specialties as $specialty) {
            DB::table('specialties')->updateOrInsert(
                ['name' => $specialty],
                ['name' => $specialty]
            );
        }
    }
}
