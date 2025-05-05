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
</style>

<div class="container py-5">
    <div class="card shadow-sm rounded-lg p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h1 class="h3 text-dark font-weight-bold">Daftar Barang</h1>
            <div class="d-flex align-items-center">
                <form action="{{ route('admin.barangs') }}" method="GET" class="d-flex align-items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari barang..." class="form-control form-control-sm w-50" aria-label="Cari Barang" style="border-radius: 20px; border: 1px solid #007bff; box-shadow: none; padding-left: 1rem;">
                    <button type="submit" class="ml-2 btn btn-primary" style="border-radius: 20px;">
                        Cari
                    </button>
                </form>
                <a href="{{ route('admin.barangs.create') }}" class="btn btn-success ml-3" style="border-radius: 20px;">
                    <i class="bi bi-plus-circle"></i> Tambah Barang
                </a>
            </div>
        </div>
        <div class="mb-3 no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div id="print-section" class="table-responsive">
            <div class="text-center mb-4 d-none d-print-block">
                <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
                <h2 class="mb-0">Data Barang</h2>
                <small>PT. K2NET - Sistem Inventory</small>
                <hr>
            </div>

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th class="text-left text-dark">NO</th>
                        <th class="text-left text-dark">Nama</th>
                        <th class="text-left text-dark">Jenis</th>
                        <th class="text-center text-dark">Stok</th>
                        <th class="text-left text-dark">Seri</th>
                        <th class="text-left text-dark">Keterangan</th>
                        <th class="text-center text-dark no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td class="align-middle text-dark">{{ $loop->iteration }}</td>
                            <td class="align-middle text-dark">{{ $barang->nama_barang }}</td>
                            <td class="align-middle text-dark">{{ $barang->jenis_barang }}</td>
                            <td class="align-middle text-center text-dark">
                                <span class="badge badge-pill badge-info" style="color: #000;">{{ $barang->stok }}</span>
                            </td>
                            <td class="align-middle text-dark">{{ $barang->seri }}</td>
                            <td class="align-middle text-dark">{{ $barang->keterangan }}</td>
                            <td class="align-middle text-center no-print">
                                <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="{{ route('admin.barangs.delete', $barang->id) }}" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Tidak ada barang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
