<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // Tentukan nama tabel secara eksplisit jika nama tabel di DB adalah 'buku' (singkapan/bahasa Indonesia)
    protected $table = 'buku';

    // Atur primary key jika tidak standar/bukan 'id'
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi
    protected $fillable = ['judul', 'penulis', 'harga', 'tgl_terbit'];
}