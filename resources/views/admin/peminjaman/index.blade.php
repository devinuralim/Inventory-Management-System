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

    .no-print,
    .no-print-column {
        display: none !important;
    }
}
</style>

<div class="pt-4 pb-5 container">
    <div class="card shadow border-0 rounded-4 p-4">
        {{-- Judul dan Tombol --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 no-print gap-3">
            <h2 class="fw-bold text-dark d-flex align-items-center mb-0">
                <i class="fas fa-clipboard-list me-2 text-black"></i> Daftar Peminjaman
            </h2>
            <div class="d-flex flex-wrap gap-2 justify-content-end">
                <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="input-group shadow-sm" style="max-width: 260px;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-start-pill border-end-0" placeholder="Cari nama/barang...">
                    <button class="btn btn-outline-primary rounded-end-pill border-start-0" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('admin.peminjaman.export.pdf') }}" class="btn btn-danger btn-sm rounded-pill">
                    <i class="fas fa-file-pdf me-1"></i> PDF
                </a>
                <a href="{{ route('admin.peminjaman.export.csv') }}" class="btn btn-success btn-sm rounded-pill">
                    <i class="fas fa-file-csv me-1"></i> CSV
                </a>
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger shadow-sm">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- Tabel --}}
        <div id="print-section" class="table-responsive">
            <div class="text-center mb-4 d-none d-print-block">
                <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
                <h2 class="mb-0">Daftar Peminjaman Barang</h2>
                <small>PT. K2NET - Inventory Management System</small>
                <hr>
            </div>

            <table class="table table-hover align-middle table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th class="d-none no-print-column">Tanggal Kembali</th>
                        <th>Status</th>
                        <th class="text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->nama_peminjam }}</td>
                            <td>{{ $peminjaman->nama_barang }}</td>
                            <td>{{ $peminjaman->jumlah }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td class="d-none no-print-column">{{ $peminjaman->tanggal_kembali }}</td>
                            <td class="text-center">
                                @if ($peminjaman->status == 'dipinjam')
                                    <span class="badge bg-danger">Dipinjam</span>
                                @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="text-center no-print">
                                @if($peminjaman->status == 'menunggu konfirmasi')
                                    <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin konfirmasi pengembalian?')" class="d-inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-dark btn-sm rounded-pill">
                                            <i class="fas fa-check me-1"></i> Konfirmasi
                                        </button>
                                    </form>
                                @elseif($peminjaman->status == 'dikembalikan')
                                    <form action="{{ route('admin.peminjaman.delete', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-pill">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-2x mb-2 text-secondary"></i><br>
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Total --}}
            <div class="mt-4">
                <strong>Total Peminjaman:</strong> {{ $total }}
            </div>
        </div>
    </div>
</div>
@endsection
