<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SpecialtySeeder::class,
            MemberSeeder::class,
            DoctorSeeder::class,
            UserSeeder::class,
            ArticleSeeder::class,
        ]);

        Article::factory(10)->create();

        $this->call([
            ConsultationSeeder::class,
            ChatSeeder::class,
        ]);

    }
}
