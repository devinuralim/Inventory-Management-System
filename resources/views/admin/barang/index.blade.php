@extends('layouts.admin')

@section('content')

<style>
    /* Styling Modern */
    .page-header { margin-bottom: 2rem; }
    .page-title { font-weight: 700; font-size: 1.6rem; color: #0f172a; letter-spacing: -0.02em; }
    .text-muted { color: #64748b !important; }

    .action-bar {
        background: #ffffff;
        padding: 1rem;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }

    /* Tabel Premium */
    .table-container { 
        background: white; 
        padding: 1.5rem; 
        border-radius: 16px; 
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    
    .table thead { background-color: #f8fafc; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .table thead th { padding: 1rem; border-bottom: 2px solid #e2e8f0; }
    .table tbody tr { transition: background 0.2s; }
    .table tbody tr:hover { background-color: #f1f5f9; }
    
    .badge-stock {
        background-color: #dbeafe;
        color: #1e40af;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.4rem 0.8rem !important;
    }

    /* Print Styles */
    @media print {
        body * { visibility: hidden !important; }
        #print-section, #print-section * { visibility: visible !important; }
        #print-section { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>

<div class="container pt-3 pb-5">

    {{-- Header --}}
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="page-title">Daftar Barang</div>
            <p class="text-muted mb-0">Kelola dan pantau inventaris barang kantor Anda</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('admin.barangs') }}" method="GET" class="input-group" style="max-width: 280px;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control rounded-start-pill border-secondary-subtle" placeholder="Cari barang...">
                <button class="btn btn-outline-secondary rounded-end-pill" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <a href="{{ route('admin.barangs.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> Tambah Barang
            </a>
        </div>
    </div>

    {{-- Action Bar --}}
    <div class="action-bar d-flex flex-wrap gap-2 no-print">
        <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill px-3">
            <i class="fas fa-print me-1"></i> Cetak
        </button>
        <a href="{{ route('admin.barangs.export.pdf') }}" class="btn btn-outline-danger btn-sm rounded-pill px-3">
            <i class="fas fa-file-pdf me-1"></i> PDF
        </a>
        <a href="{{ route('admin.barangs.export.csv') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
            <i class="fas fa-file-csv me-1"></i> CSV
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div id="print-section" class="table-container">
        
        <div class="text-center mb-4 d-none d-print-block">
            <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px;">
            <h4 class="mt-2 mb-0">Data Barang</h4>
            <small>PT. K2NET - Inventory Management System</small>
            <hr>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="text-center">
                    <tr>
                        <th class="text-start">No</th>
                        <th class="text-start">Nama Barang</th>
                        <th class="text-start">Jenis</th>
                        <th>Stok</th>
                        <th>Seri</th>
                        <th class="text-start">Keterangan</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $barang->nama_barang }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $barang->jenis_barang }}</span></td>
                            <td class="text-center"><span class="badge badge-stock">{{ $barang->stok }}</span></td>
                            <td class="text-center text-secondary">{{ $barang->seri }}</td>
                            <td>{{ $barang->keterangan }}</td>
                            <td class="text-center no-print">
                                <a href="{{ route('admin.barangs.edit', $barang->id) }}" 
                                   class="btn btn-sm btn-icon btn-outline-warning rounded-pill me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.barangs.delete', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-icon btn-outline-danger rounded-pill" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-box-open fa-2x mb-3 d-block opacity-50"></i>
                                Tidak ada data barang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection