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

input:focus, button:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}
</style>

<div class="pt-4 pb-5 container">
    <div class="card shadow border-0 rounded-4 p-4">
        <!-- Header Judul & Aksi -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 no-print gap-3">
            <h2 class="fw-bold text-dark d-flex align-items-center mb-0">
                <i class="fas fa-boxes-stacked me-2 text-black"></i> Daftar Barang
            </h2>
            <div class="d-flex flex-wrap gap-2">
                <!-- Form Pencarian -->
                <form action="{{ route('admin.barangs') }}" method="GET" class="input-group shadow-sm" style="max-width: 320px;">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control rounded-start-pill border-end-0"
                        placeholder="Cari nama, jenis, atau seri barang..." aria-label="Cari barang">
                    <button class="btn btn-outline-primary rounded-end-pill border-start-0" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <!-- Tombol Tambah -->
                <a href="{{ route('admin.barangs.create') }}" class="btn btn-success btn-sm rounded-pill">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Barang
                </a>
            </div>
        </div>

        <!-- Tombol Cetak -->
        <div class="mb-3 no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Tabel Data -->
        <div id="print-section" class="table-responsive">
            <!-- Header untuk print -->
            <div class="text-center mb-4 d-none d-print-block">
                <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
                <h2 class="mb-0">Data Barang</h2>
                <small>PT. K2NET - Inventory Management System</small>
                <hr>
            </div>

            <table class="table table-hover align-middle table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>NO</th>
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->jenis_barang }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">{{ $barang->stok }}</span>
                            </td>
                            <td>{{ $barang->seri }}</td>
                            <td>{{ $barang->keterangan }}</td>
                            <td class="text-center no-print">
                                <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="btn btn-warning btn-sm rounded-pill me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Form method DELETE -->
                                <form action="{{ route('admin.barangs.delete', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm rounded-pill">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
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
