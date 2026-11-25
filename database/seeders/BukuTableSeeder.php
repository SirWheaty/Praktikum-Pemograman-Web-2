<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuTableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Buku::updateOrCreate(
                ['judul' => 'Contoh Buku Ke-' . $i],
                [
                    'penulis' => 'Penulis Contoh ' . $i,
                    'harga' => 50000 + ($i * 5000),
                    'tgl_terbit' => now()->subDays($i)->toDateString(),
                ],
            );
        }
    }
}
