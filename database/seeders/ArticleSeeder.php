<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctorIds = Doctor::query()->orderBy('id')->limit(2)->pluck('id')->all();

        if (count($doctorIds) < 2) {
            $this->command->warn('Seeding Artikel dibatalkan karena minimal 2 data dokter belum tersedia.');

            return;
        }

        $articles = [
            [
                'title' => 'Artikel 1',
                'date' => '2024-06-01',
                'content' => 'Isi artikel 1',
                'photo' => 'foto1.jpg',
                'doctor_id' => $doctorIds[0],
            ],
            [
                'title' => 'Artikel 2',
                'date' => '2024-06-02',
                'content' => 'Isi artikel 2',
                'photo' => 'foto2.jpg',
                'doctor_id' => $doctorIds[1],
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
