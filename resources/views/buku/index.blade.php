<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <!-- Bootstrap CSS (Opsional untuk tampilan rapi) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Data Buku</h2>

        <form method="GET" action="{{ url('/buku') }}" class="row g-3 mb-4">
            <div class="col-md-7">
                <label for="search" class="form-label">Cari judul</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Masukkan judul buku"
                >
            </div>
            <div class="col-md-3">
                <label for="per_page" class="form-label">Data per halaman</label>
                <select id="per_page" name="per_page" class="form-select">
                    @foreach([5, 10, 25] as $option)
                    <option value="{{ $option }}" @selected($perPage === $option)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Terapkan</button>
            </div>
        </form>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Tgl. Terbit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_buku as $buku)
                <tr>
                    <td>{{ $data_buku->firstItem() + $loop->iteration - 1 }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ "Rp. ".number_format($buku->harga, 0, ',', '.') }}</td>
                    <td>{{ $buku->tgl_terbit }}</td>
                </tr>
                @endforeach
                @if($data_buku->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">Belum ada data buku.</td>
                </tr>
                @endif
            </tbody>
            <!-- Bagian Footer Tabel sesuai Tugas Praktikum -->
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Jumlah Total Buku</strong></td>
                    <td colspan="2"><strong>{{ $jumlah_buku }} Buku</strong></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total Harga Seluruh Buku</strong></td>
                    <td colspan="2"><strong>{{ "Rp. ".number_format($total_harga, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="small text-muted mb-2">
            Halaman: {{ $data_buku->currentPage() }}<br>
            Jumlah Hasil: {{ $data_buku->total() }}<br>
            Data Per Halaman: {{ $data_buku->perPage() }}
        </div>
        {{ $data_buku->links() }}
    </div>
</body>
</html>