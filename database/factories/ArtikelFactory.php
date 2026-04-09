<?php

namespace Database\Factories;

use App\Models\Dokter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArtikelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake('id_ID')->sentence(7),
            'tanggal' => fake()->date(),
            'isi' => fake('id_ID')->paragraphs(7,true),
            'foto' => fake()->imageUrl(800, 400, 'health', true),
            'dokter_id' => Dokter::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
