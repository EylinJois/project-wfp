<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\Dokter;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokterIds = Dokter::query()->orderBy('id')->limit(2)->pluck('id')->all();

        if (count($dokterIds) < 2) {
            $this->command->warn('Seeding Artikel dibatalkan karena minimal 2 data dokter belum tersedia.');

            return;
        }

        $data = [
            [
                'judul' => 'Artikel 1',
                'tanggal' => '2024-06-01',
                'isi' => 'Isi artikel 1',
                'foto' => 'foto1.jpg',
                'dokter_id' => $dokterIds[0],
            ],
            [
                'judul' => 'Artikel 2',
                'tanggal' => '2024-06-02',
                'isi' => 'Isi artikel 2',
                'foto' => 'foto2.jpg',
                'dokter_id' => $dokterIds[1],
            ],
        ];

        foreach ($data as $artikel) {
            Artikel::create($artikel);
        }
    }
}
