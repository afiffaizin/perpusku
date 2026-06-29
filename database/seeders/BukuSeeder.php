<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Penulis;
use App\Models\KategoriBuku;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        KategoriBuku::factory()->count(5)->create();
        Penulis::factory()->count(10)->create();

        // Buat 50 buku dummy
        Buku::factory()->count(50)->create();
    }
}
