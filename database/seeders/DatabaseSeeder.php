<?php

use Illuminate\Database\Seeder;
use Database\Seeders\BukuSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PenulisSeeder;
use Database\Seeders\MahasiswaSeeder;
use Database\Seeders\KategoriBukuSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MahasiswaSeeder::class,
            BukuSeeder::class,
        ]);
    }
}
