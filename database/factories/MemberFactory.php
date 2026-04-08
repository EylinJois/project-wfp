<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'updated_at' =>fake()->dateTime(now()),
            'nama_lengkap' => fake('id_ID')->name(),
            'tanggal_lahir' => fake()->dateTimeBetween('-60 years', '-17 years')->format('Y-m-d'),
            'foto' => fake()->imageUrl(300, 300, 'person', true),
        ];
    }
}
