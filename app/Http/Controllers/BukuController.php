<?php

namespace App\Http\Controllers;

use App\Models\Buku; // Mengimpor Model Buku
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'per_page' => ['nullable', 'integer', 'in:5,10,25'],
        ]);

        $search = $filters['search'] ?? '';
        $perPage = (int) ($filters['per_page'] ?? 10);

        $data_buku = Buku::query()
            ->when($search !== '', fn ($query) => $query->where('judul', 'like', '%' . $search . '%'))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $jumlah_buku = Buku::count();
        $total_harga = Buku::sum('harga');

        return view('buku.index', compact('data_buku', 'jumlah_buku', 'total_harga', 'search', 'perPage'));
    }
}