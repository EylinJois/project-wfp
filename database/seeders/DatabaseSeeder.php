<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Artikel;
use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Member::factory(10)->create()->each(function ($member) {
            User::factory()->create([
                'member_id' => $member->id,
            ]);
        });

        $this->call([
            SpesialisasiSeeder::class,
            DokterSeeder::class,
        ]);

        Artikel::factory(10)->create();

        $this->call([
            KonsultasiSeeder::class,
            ChatSeeder::class,
        ]);

    }
}
