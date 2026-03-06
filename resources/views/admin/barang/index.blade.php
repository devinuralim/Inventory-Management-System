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
        .table-container { border: none; box-shadow: none; }
    }
</style>

<div class="container pt-3 pb-5">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="page-title">Daftar Barang</div>
            <p class="text-muted small mb-0">Kelola dan pantau inventaris barang kantor Anda</p>
        </div>
        <a href="{{ route('admin.barangs.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus me-1"></i> Tambah Barang
        </a>
    </div>

    {{-- Filter & Action Bar --}}
    <div class="card-clean mb-4 no-print">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <form action="{{ route('admin.barangs') }}" method="GET" class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari barang...">
                    <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="col-md-8 text-md-end">
                <button onclick="window.print()" class="btn btn-sm btn-outline-dark rounded-pill px-3"><i class="fas fa-print me-1"></i></button>
                <a href="{{ route('admin.barangs.export.pdf') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="fas fa-file-pdf me-1"></i></a>
                <a href="{{ route('admin.barangs.export.csv') }}" class="btn btn-sm btn-outline-success rounded-pill px-3"><i class="fas fa-file-csv me-1"></i></a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div id="print-section" class="card-clean table-responsive">
        {{-- Print Header --}}
        <div class="text-center mb-4 d-none d-print-block">
            <h4 class="mb-0">Data Barang</h4>
            <small>PT. K2NET - Inventory Management System</small>
            <hr>
        </div>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th class="text-center">Stok</th>
                    <th>Seri</th>
                    <th>Keterangan</th>
                    <th class="text-center no-print">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $barang->nama_barang }}</td>
                        <td><span class="badge bg-light text-dark border rounded-pill">{{ $barang->jenis_barang }}</span></td>
                        <td class="text-center"><span class="badge-stock">{{ $barang->stok }}</span></td>
                        <td class="text-secondary">{{ $barang->seri }}</td>
                        <td>{{ $barang->keterangan }}</td>
                        <td class="text-center no-print">
                            <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning rounded-pill me-1" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.barangs.delete', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-2x mb-3 d-block opacity-50"></i>
                            Tidak ada data barang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection