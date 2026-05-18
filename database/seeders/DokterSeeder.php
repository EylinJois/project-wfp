<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dokter')->insert([
            [
                'nama_lengkap' => 'dr. Kevin Pratama',
                'sip' => 'SIP/101/A1/2024',
                'pengalaman' => '3 Tahun',
                'foto' => 'dokter_kevin.png',
                'spesialisasi_id' => 4, // Asumsi: Dokter Umum
                'mulai_praktik' => '08:00:00',
                'selesai_praktik' => '15:00:00',
            ],
            [
                'nama_lengkap' => 'drg. Rina Melati',
                'sip' => 'SIP/102/B1/2021',
                'pengalaman' => '6 Tahun',
                'foto' => 'dokter_rina.png',
                'spesialisasi_id' => 2,
                'mulai_praktik' => '09:00:00',
                'selesai_praktik' => '16:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Hendra Saputra, Sp.A',
                'sip' => 'SIP/103/C1/2018',
                'pengalaman' => '12 Tahun',
                'foto' => 'dokter_hendra.png',
                'spesialisasi_id' => 1,
                'mulai_praktik' => '10:00:00',
                'selesai_praktik' => '14:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Gita Saraswati, Sp.S',
                'sip' => 'SIP/104/D1/2020',
                'pengalaman' => '8 Tahun',
                'foto' => 'dokter_gita.jpg',
                'spesialisasi_id' => 5,
                'mulai_praktik' => '16:00:00',
                'selesai_praktik' => '21:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Ahmad Fauzi, Sp.PD',
                'sip' => 'SIP/105/E1/2016',
                'pengalaman' => '15 Tahun',
                'foto' => 'dokter_ahmad.jpg',
                'spesialisasi_id' => 6,
                'mulai_praktik' => '08:00:00',
                'selesai_praktik' => '13:00:00',
            ]
        ]);
    }
}
