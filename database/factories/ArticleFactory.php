<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake('id_ID')->sentence(7),
            'date' => fake()->date(),
            'content' => fake('id_ID')->paragraphs(7, true),
            'photo' => fake()->imageUrl(800, 400, 'health', true),
            'doctor_id' => Doctor::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
