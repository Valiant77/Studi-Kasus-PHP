<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => fake()->unique()->numerify('##########'),
            'nama' => fake()->name(),
            'kelas' => fake()->randomElement(['X', 'XI', "XII"]),
            'jurusan' => fake()->randomElement(['RPL', 'TKJ', 'TO', 'TM', 'TL', 'DKV', 'KL', 'AKL', 'MPLB', 'PS']),
            'sekolah_id' => School::factory(),
            'tgl_masuk' => fake()->date(),
            'jenis_kelamin' => fake()->randomElement(['laki-laki', 'perempuan'])
        ];
    }
}
