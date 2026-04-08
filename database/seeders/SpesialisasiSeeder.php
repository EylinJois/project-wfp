<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpesialisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('spesialisasi')->insert([
            ['nama' => 'Spesialis Anak'],
            ['nama' => 'Dokter Gigi'],
            ['nama' => 'Spesialis Jantung dan Pembuluh Darah'],
            ['nama' => 'Dokter Umum'],
            ['nama' => 'Spesialis Saraf'],
            ['nama' => 'Spesialis Penyakit Dalam'],
            ['nama' => 'Spesialis Obsteri dan Ginekologi'],
            ['nama' => 'Spesialis THT-KL'],
            ['nama' => 'Spesialis Mata'],
            ['nama' => 'Psikiater'],
        ]);
    }
}
