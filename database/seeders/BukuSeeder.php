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

        KategoriBuku::factory()->count(3)->create();
        Penulis::factory()->count(3)->create();

        // Buat 20 buku dummy
        Buku::factory()->count(20)->create();
    }
}
