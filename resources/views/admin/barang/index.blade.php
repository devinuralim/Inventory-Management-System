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

.page-title {
    font-weight: 600;
    font-size: 1.4rem;
}

.action-bar {
    background: #f8f9fa;
    padding: 12px 16px;
    border-radius: 12px;
}

.table thead {
    background-color: #f1f3f5;
}

.badge-stock {
    background-color: #e9f5ff;
    color: #0d6efd;
    font-weight: 500;
}

@media (max-width: 768px) {
    .table th,
    .table td {
        font-size: 0.85rem;
    }
}
</style>

<div class="container pt-2 pb-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <div class="page-title">
                Daftar Barang
            </div>
            <small class="text-muted">Kelola data barang kantor di sini</small>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('admin.barangs') }}" method="GET" class="input-group" style="max-width: 280px;">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       class="form-control rounded-start-pill" 
                       placeholder="Cari barang...">
                <button class="btn btn-outline-secondary rounded-end-pill" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <a href="{{ route('admin.barangs.create') }}" 
               class="btn btn-primary rounded-pill">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>
        </div>
    </div>

    {{-- Action Bar --}}
    <div class="action-bar mb-3 d-flex flex-wrap gap-2 no-print">
        <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill">
            <i class="fas fa-print me-1"></i> Cetak
        </button>

        <a href="{{ route('admin.barangs.export.pdf') }}" 
           class="btn btn-outline-danger btn-sm rounded-pill">
            <i class="fas fa-file-pdf me-1"></i> PDF
        </a>

        <a href="{{ route('admin.barangs.export.csv') }}" 
           class="btn btn-outline-success btn-sm rounded-pill">
            <i class="fas fa-file-csv me-1"></i> CSV
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div id="print-section" class="table-responsive bg-white p-3 rounded-3 shadow-sm">
        
        <div class="text-center mb-4 d-none d-print-block">
            <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px;">
            <h4 class="mt-2 mb-0">Data Barang</h4>
            <small>PT. K2NET - Inventory Management System</small>
            <hr>
        </div>

        <table class="table align-middle">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Stok</th>
                    <th class="text-center">Seri</th>
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
                            <span class="badge badge-stock px-3 py-2">
                                {{ $barang->stok }}
                            </span>
                        </td>

                        <td class="text-center">
                            {{ $barang->seri }}
                        </td>

                        <td>{{ $barang->keterangan }}</td>

                        <td class="text-center no-print">
                            <a href="{{ route('admin.barangs.edit', $barang->id) }}" 
                               class="btn btn-sm btn-outline-warning rounded-pill me-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.barangs.delete', $barang->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada barang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
