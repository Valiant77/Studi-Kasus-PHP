<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kuota = fake()->numberBetween(150, 800);
        return [
            'nama' => 'SMK ' . fake()->company(),
            'alamat' => fake()->address(),
            'kuota' => $kuota,
            'terisi' => 0
        ];
    }
}
