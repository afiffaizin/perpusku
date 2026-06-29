<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nim' => $this->faker->unique()->numerify('20######'),
            'kelas' => $this->faker->randomElement(['1A', '1B', '2A', '2B', '3A', '3B']),
            'prodi' => 'TRPL',
            'angkatan' => $this->faker->randomElement([2022, 2023, 2024, 2025]),
        ];
    }
}
