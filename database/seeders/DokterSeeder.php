<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ],
            [
                'nama_lengkap' => 'dr. Aditya Nugroho, Sp.KJ',
                'sip' => 'SIP/106/A2/2025',
                'pengalaman' => '1 Tahun',
                'foto' => 'dokter_aditya.jpg',
                'spesialisasi_id' => 10,
                'mulai_praktik' => '13:00:00',
                'selesai_praktik' => '20:00:00',
            ],
            [
                'nama_lengkap' => 'drg. Antonius Budi, Sp.M',
                'sip' => 'SIP/107/B2/2019',
                'pengalaman' => '9 Tahun',
                'foto' => 'dokter_anton.jpg',
                'spesialisasi_id' => 9,
                'mulai_praktik' => '15:00:00',
                'selesai_praktik' => '21:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Lestari Kusuma, Sp.JP',
                'sip' => 'SIP/108/C2/2022',
                'pengalaman' => '5 Tahun',
                'foto' => 'dokter_lestari.jpg',
                'spesialisasi_id' => 3,
                'mulai_praktik' => '08:00:00',
                'selesai_praktik' => '12:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Maya Indah, Sp.PD',
                'sip' => 'SIP/109/D2/2017',
                'pengalaman' => '11 Tahun',
                'foto' => 'dokter_maya.jpg',
                'spesialisasi_id' => 6,
                'mulai_praktik' => '09:00:00',
                'selesai_praktik' => '15:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Reza Fahlevi, Sp.OG',
                'sip' => 'SIP/110/E2/2015',
                'pengalaman' => '14 Tahun',
                'foto' => 'dokter_reza.jpg',
                'spesialisasi_id' => 7,
                'mulai_praktik' => '14:00:00',
                'selesai_praktik' => '20:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Sarah Wijaya, SP.S',
                'sip' => 'SIP/111/A3/2023',
                'pengalaman' => '4 Tahun',
                'foto' => 'dokter_sarah.jpg',
                'spesialisasi_id' => 5,
                'mulai_praktik' => '07:00:00',
                'selesai_praktik' => '14:00:00',
            ],
            [
                'nama_lengkap' => 'drg. Clara Shinta',
                'sip' => 'SIP/112/B3/2024',
                'pengalaman' => '2 Tahun',
                'foto' => 'dokter_clara.jpg',
                'spesialisasi_id' => 2,
                'mulai_praktik' => '10:00:00',
                'selesai_praktik' => '18:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Doni Hermawan, Sp.A',
                'sip' => 'SIP/113/C3/2020',
                'pengalaman' => '7 Tahun',
                'foto' => 'dokter_doni.jpg',
                'spesialisasi_id' => 1,
                'mulai_praktik' => '13:00:00',
                'selesai_praktik' => '19:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Dian Permatasari, Sp.KJ',
                'sip' => 'SIP/114/D3/2014',
                'pengalaman' => '16 Tahun',
                'foto' => 'dokter_dian.jpg',
                'spesialisasi_id' => 10,
                'mulai_praktik' => '08:00:00',
                'selesai_praktik' => '13:00:00',
            ],
            [
                'nama_lengkap' => 'dr. Surya Dharma, Sp.PD',
                'sip' => 'SIP/115/E3/2019',
                'pengalaman' => '10 Tahun',
                'foto' => 'dokter_surya.jpg',
                'spesialisasi_id' => 6,
                'mulai_praktik' => '16:00:00',
                'selesai_praktik' => '22:00:00',
            ],
        ]);
    }
}
