<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Penulis;
use App\Models\KategoriBuku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil kategori & penulis random
        $kategori = KategoriBuku::inRandomOrder()->first();
        $penulis  = Penulis::inRandomOrder()->first();

        // Daftar gambar lokal
        $gambar = [
            '1.jpg',
            '2.jpg',
            '3.jpg',
            '4.jpg',
            '5.jpg',
            '6.jpg',
            '7.jpg',
            '8.jpg',
        ];

        return [
            'judul' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'kategori_id' => $kategori->id,
            'penulis_id' => $penulis->id,
            'bahasa' => $this->faker->randomElement(['Indonesia', 'Inggris']),
            'jumlah_halaman' => $this->faker->numberBetween(100, 500),
            'stok' => $this->faker->numberBetween(1, 20),
            'sampul' => $this->faker->randomElement($gambar),
        ];
    }
}
