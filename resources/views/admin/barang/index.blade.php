@extends('layouts.admin')

@section('content')

<style>
@media print {
    body * {
        visibility: hidden !important;
    }

    #print-section, #print-section * {
        visibility: visible !important;
    }

    #print-section {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }
}

/* Responsif tambahan */
@media (max-width: 768px) {
    .table th,
    .table td {
        font-size: 0.85rem;
        padding: 0.5rem;
    }

    .input-group input {
        font-size: 0.85rem;
    }

    .btn {
        font-size: 0.85rem;
        padding: 6px 12px;
    }

    .btn i {
        font-size: 0.85rem;
    }

    h2 {
        font-size: 1.2rem;
    }
}
</style>

<div class="container pt-4 pb-5">
    <div class="card shadow-sm border-0 rounded-4 p-4">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <h2 class="fw-bold text-dark d-flex align-items-center mb-0">
                <i class="fas fa-boxes-stacked me-2 text-dark"></i> Daftar Barang
            </h2>
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 justify-content-start justify-content-md-end">
                <form action="{{ route('admin.barangs') }}" method="GET" class="input-group shadow-sm" style="max-width: 300px;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-start-pill border-end-0" placeholder="Cari nama, jenis, seri...">
                    <button class="btn btn-outline-primary rounded-end-pill border-start-0" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('admin.barangs.create') }}" class="btn btn-success rounded-pill">
                    <i class="fas fa-plus me-1"></i> Tambah
                </a>
            </div>
        </div>

        {{-- Tombol Export & Cetak --}}
        <div class="mb-3 d-flex flex-wrap gap-2 no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="{{ route('admin.barangs.export.pdf') }}" class="btn btn-danger rounded-pill">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('admin.barangs.export.csv') }}" class="btn btn-outline-success rounded-pill">
                <i class="fas fa-file-csv"></i> CSV
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Table Section --}}
        <div id="print-section" class="table-responsive">
            <div class="text-center mb-4 d-none d-print-block">
                <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px;">
                <h2 class="mb-0">Data Barang</h2>
                <small>PT. K2NET - Inventory Management System</small>
                <hr>
            </div>

            <table class="table table-hover align-middle table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Stok</th>
                        <th>Seri</th>
                        <th>Keterangan</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->jenis_barang }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">{{ $barang->stok }}</span>
                            </td>
                            <td>{{ $barang->seri }}</td>
                            <td>{{ $barang->keterangan }}</td>
                            <td class="text-center no-print">
                                <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="btn btn-sm btn-warning rounded-pill me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.barangs.delete', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-pill">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-2x mb-2 text-secondary"></i><br>
                                Tidak ada barang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
