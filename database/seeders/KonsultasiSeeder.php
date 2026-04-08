<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Konsultasi;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonsultasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberIds = Member::pluck('id')->toArray();
        $dokterIds = Dokter::pluck('id')->toArray();

        if (empty($memberIds) || empty($dokterIds)) {
            $this->command->warn('Seeding Konsultasi dibatalkan karena tabel member atau dokter kosong.');
            return;
        }

        DB::table('konsultasi')->insert([
            [
                'waktu' => date('Y-m-d 10:00:00', strtotime('-2 days')),
                'status' => 'Chat',
                'jenis_konsultasi' => 'selesai',
                'catatan' => 'Pasien mengeluh pusing dan mual sejak pagi. Disarankan istirahat cukup.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'dokter_id' => $dokterIds[array_rand($dokterIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'waktu' => date('Y-m-d 14:30:00', strtotime('-1 days')),
                'status' => 'Chat',
                'jenis_konsultasi' => 'selesai',
                'catatan' => 'Konsultasi pasca operasi. Luka mengering dengan baik, lanjut obat jalan.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'dokter_id' => $dokterIds[array_rand($dokterIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'waktu' => date('Y-m-d H:i:s', strtotime('+2 hours')),
                'status' => 'Video',
                'jenis_konsultasi' => 'selesai',
                'catatan' => 'Keluhan gatal-gatal di area lengan setelah makan seafood.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'dokter_id' => $dokterIds[array_rand($dokterIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'waktu' => date('Y-m-d 09:00:00', strtotime('-5 days')),
                'status' => 'Chat',
                'jenis_konsultasi' => 'kosong',
                'catatan' => 'Pasien tidak hadir pada jam yang ditentukan.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'dokter_id' => $dokterIds[array_rand($dokterIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'waktu' => date('Y-m-d 19:00:00', strtotime('-3 days')),
                'status' => 'video',
                'jenis_konsultasi' => 'sedang berlangsung',
                'catatan' => 'Anak demam 38 derajat. Diberikan resep paracetamol cair.',
                'member_id' => $memberIds[array_rand($memberIds)],
                'dokter_id' => $dokterIds[array_rand($dokterIds)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

    }
}
