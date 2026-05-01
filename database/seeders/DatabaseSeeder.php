<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Artikel;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed dependencies first (Spesialisasi and Dokter)
        $this->call([
            SpesialisasiSeeder::class,
            DokterSeeder::class,
        ]);

        // Seed fixed demo accounts (Members and Users)
        $this->call([
            MemberSeeder::class,
            UserSeeder::class,
        ]);

        Artikel::factory(10)->create();

        $this->call([
            KonsultasiSeeder::class,
            ChatSeeder::class,
        ]);
    }
}
