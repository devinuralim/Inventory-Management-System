@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }
    .card-glass {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease-in-out;
    }
    .card-glass:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .input-group .form-control:focus {
        border-color: #1d3557;
        box-shadow: 0 0 0 0.2rem rgba(29, 53, 87, 0.25);
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Judul --}}
        <div class="mb-4 text-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-cube me-2 text-black"></i>Daftar Barang
            </h2>
            <p class="text-muted mt-2">Berikut ini adalah daftar barang yang tersedia untuk dipinjam.</p>
        </div>

        {{-- Form Pencarian --}}
        <form action="{{ route('user.barang.index') }}" method="GET" class="mb-4 mx-auto" style="max-width: 500px;">
            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari barang...">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- Tabel Daftar Barang --}}
        <div class="card card-glass border-0 rounded-4 animate__animated animate__fadeInUp shadow-sm">
            <div class="card-body">
                @if($barangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center mb-0">
                        <thead style="background-color: #1d3557; color: white;">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Stok</th>
                                <th>Seri</th>
                                <th>Keterangan</th>
                                <th>Favorit</th>
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
                                    <td>
                                        <form action="{{ route('user.favorit.toggle', $barang->id) }}" method="POST">
                                            @csrf
                                            @php
                                                $isFavorit = auth()->user()->favoritBarang->contains($barang->id);
                                            @endphp
                                            <button type="submit" class="btn btn-sm {{ $isFavorit ? 'btn-warning' : 'btn-outline-secondary' }}">
                                                {!! $isFavorit ? '&#9733;' : '&#9734;' !!}
                                            </button>
                                        </form>
                                    </td>
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
