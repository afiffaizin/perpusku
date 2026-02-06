<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KategoriBuku;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriBuku>
 */
class KategoriBukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kategori' => $this->faker->unique()->randomElement([
                'Pemrograman',
                'Database',
                'Jaringan',
                'Web',
                'Mobile'
            ]),
        ];
    }
}
