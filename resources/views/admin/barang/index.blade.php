@extends('layouts.admin')

@section('content')
<style>
    .page-title { font-weight: 700; font-size: 1.6rem; color: #0f172a; }
    .card-clean { background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .table thead { background-color: #f8fafc; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .table tbody tr:hover { background-color: #f1f5f9; transition: 0.2s; }
    .badge-stock { background-color: #dbeafe; color: #1e40af; font-weight: 600; border-radius: 8px; padding: 0.4rem 0.8rem; }
    
    @media print {
        .no-print { display: none !important; }
        .card-clean { border: none !important; box-shadow: none !important; padding: 0 !important; }
        .table { width: 100% !important; border: 1px solid #000 !important; }
        th, td { border: 1px solid #000 !important; padding: 8px !important; color: black !important; }
        th { background-color: #f2f2f2 !important; -webkit-print-color-adjust: exact; }
    }
</style>

<div class="container pt-3 pb-5">
    {{-- Header: Hilang saat print --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 no-print">
        <div>
            <div class="page-title">Daftar Barang</div>
            <p class="text-muted small mb-0">Kelola dan pantau inventaris barang kantor K2NET</p>
        </div>
        <a href="{{ route('admin.barangs.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Barang
        </a>
    </div>

    {{-- Search & Export Bar: Hilang saat print --}}
    <div class="card-clean mb-4 no-print">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <form action="{{ route('admin.barangs') }}" method="GET" class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm border-end-0" placeholder="Cari nama/jenis barang...">
                    <button class="btn btn-sm btn-outline-secondary border-start-0" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="col-md-8 text-md-end">
                <button onclick="window.print()" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                    <i class="fas fa-print me-1"></i> Print
                </button>
                <a href="{{ route('admin.barangs.export.pdf') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="fas fa-file-pdf me-1"></i> PDF
                </a>
                <a href="{{ route('admin.barangs.export.csv') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                    <i class="fas fa-file-csv me-1"></i> CSV
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3 no-print">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Konten Utama --}}
    <div class="card-clean table-responsive">
        
        {{-- Header Laporan khusus PRINT --}}
        <div class="text-center mb-4 d-none d-print-block">
            <h3 class="mb-1 fw-bold">LAPORAN DATA INVENTARIS</h3>
            <p class="mb-0 text-uppercase" style="font-size: 11px; letter-spacing: 2px;">PT. K2NET - Management System</p>
            <div style="border-bottom: 2px solid #000; margin-top: 15px;"></div>
        </div>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th class="text-center">Stok</th>
                    <th>Seri/Model</th>
                    <th>Keterangan</th>
                    <th class="text-center no-print">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $index => $barang)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $barang->nama_barang }}</td>
                        <td><span class="badge bg-light text-dark border rounded-pill">{{ $barang->jenis_barang }}</span></td>
                        <td class="text-center"><span class="badge-stock">{{ $barang->stok }}</span></td>
                        <td class="text-secondary small">{{ $barang->seri }}</td>
                        <td class="small">{{ $barang->keterangan ?? '-' }}</td>
                        <td class="text-center no-print">
                            <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning rounded-pill me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.barangs.delete', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Data barang tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer Laporan khusus PRINT --}}
        <div class="mt-4 d-none d-print-block">
            <div class="d-flex justify-content-between">
                <small class="text-muted">Dicetak oleh: {{ Auth::user()->name }}</small>
                <small class="text-muted">Tanggal: {{ date('d/m/Y H:i') }}</small>
            </div>
        </div>
    </div>
</div>
@endsection