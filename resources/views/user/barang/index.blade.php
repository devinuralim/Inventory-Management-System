@extends('layouts.user')

@section('content')
<div class="pt-4 pb-5 bg-light min-vh-100">
    <div class="container">

        {{-- Judul --}}
        <div class="mb-4 text-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark d-inline-block border-bottom border-3 border-primary pb-1">
                <i class="fas fa-cube me-2 text-black"></i>Daftar Barang
            </h2>
            <p class="text-muted mt-2">Berikut ini adalah daftar barang yang tersedia untuk dipinjam.</p>
        </div>

        {{-- Form Pencarian --}}
        <form action="{{ route('user.barang.index') }}" method="GET" class="mb-4 mx-auto" style="max-width: 500px;">
            <div class="input-group shadow-sm">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari barang...">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- Tabel Daftar Barang --}}
        <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeInUp">
            <div class="card-body">
                @if($barangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-primary">
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
                                    <td>{{ $barang->stok }}</td>
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
