<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuJudulAcakSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 25; $i++) {
            Buku::create([
                'judul' => fake()->unique()->sentence(3),
                'penulis' => fake()->name(),
                'harga' => fake()->numberBetween(25000, 250000),
                'tgl_terbit' => fake()->date(),
            ]);
        }
    }
}
