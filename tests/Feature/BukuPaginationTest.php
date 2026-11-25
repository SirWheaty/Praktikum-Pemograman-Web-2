<?php

namespace Tests\Feature;

use App\Models\Buku;
use Database\Seeders\BukuJudulAcakSeeder;
use Database\Seeders\BukuTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BukuPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_buku_index_displays_ten_records_per_page_and_pagination_details(): void
    {
        $this->seed(BukuTableSeeder::class);

        $response = $this->get('/buku?page=2');

        $response->assertOk()
            ->assertSee('Contoh Buku Ke-1')
            ->assertSee('Contoh Buku Ke-10')
            ->assertSee('<td>11</td>', false)
            ->assertSee('<td>20</td>', false)
            ->assertSee('Halaman: 2')
            ->assertSee('Jumlah Hasil: 20')
            ->assertSee('Data Per Halaman: 10');
    }

    public function test_buku_index_handles_a_page_beyond_the_last_page(): void
    {
        Buku::create([
            'judul' => 'Buku Tunggal',
            'penulis' => 'Penulis',
            'harga' => 10000,
            'tgl_terbit' => '2026-01-01',
        ]);

        $this->get('/buku?page=99')
            ->assertOk()
            ->assertSee('Halaman: 99')
            ->assertSee('Belum ada data buku.');
    }

    public function test_buku_seeder_adds_twenty_five_books_with_random_titles(): void
    {
        $this->seed(BukuJudulAcakSeeder::class);

        $this->assertDatabaseCount('buku', 25);
        $this->assertSame(25, Buku::query()->distinct()->count('judul'));
    }

    public function test_buku_index_keeps_search_and_page_size_while_paginating(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            Buku::create([
                'judul' => 'Laravel Panduan ' . $i,
                'penulis' => 'Penulis',
                'harga' => 10000,
                'tgl_terbit' => '2026-01-01',
            ]);
        }

        Buku::create([
            'judul' => 'Buku yang tidak cocok',
            'penulis' => 'Penulis',
            'harga' => 10000,
            'tgl_terbit' => '2026-01-01',
        ]);

        $this->get('/buku?search=Laravel&per_page=5&page=2')
            ->assertOk()
            ->assertSee('Laravel Panduan 1')
            ->assertDontSee('Buku yang tidak cocok')
            ->assertSee('value="Laravel"', false)
            ->assertSee('value="5" selected', false)
            ->assertSee('search=Laravel')
            ->assertSee('per_page=5');
    }

    public function test_buku_index_supports_five_ten_and_twenty_five_records_per_page(): void
    {
        $this->seed(BukuTableSeeder::class);

        foreach ([5, 10, 25] as $perPage) {
            $this->get('/buku?per_page=' . $perPage)
                ->assertOk()
                ->assertSee('Data Per Halaman: ' . $perPage);
        }
    }

    public function test_buku_seeder_can_run_more_than_once_without_creating_duplicates(): void
    {
        $this->seed(BukuTableSeeder::class);
        $this->seed(BukuTableSeeder::class);

        $this->assertDatabaseCount('buku', 20);
    }
}
