@extends('layouts.user')

@section('content')
<div class="pt-3 pb-5"> {{-- Ganti dari py-5 jadi pt-3 biar judul lebih naik --}}
    <div class="container">
        <!-- Judul Halaman -->
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <h2 class="fw-bold text-dark d-flex align-items-center">
                <i class="fas fa-cube me-2 text-black"></i> {{-- Ganti icon & warna --}}
                Daftar Barang
            </h2>
        </div>

        <!-- Form Pencarian -->
        <form action="{{ route('user.barang.index') }}" method="GET" class="mb-4">
            <div class="input-group shadow-sm">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari barang...">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- Card Tabel Barang -->
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                @if($barangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Stok</th>
                                <th>Seri</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $barang)
                                <tr>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->jenis_barang }}</td>
                                    <td class="text-center">{{ $barang->stok }}</td>
                                    <td>{{ $barang->seri }}</td>
                                    <td>{{ $barang->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-box fa-2x mb-2 text-secondary"></i>
                        <p class="mb-0">Tidak ada data barang yang ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
