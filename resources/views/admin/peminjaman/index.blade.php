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

<div class="container pt-4 pb-5">
    <div class="card shadow-sm rounded-4">
        <div class="card-body">

            {{-- Judul --}}
            <h2 class="fw-bold text-dark mb-4 d-flex align-items-center no-print">
                <i class="fas fa-clipboard-list me-2 text-black"></i> Daftar Peminjaman Barang
            </h2>

            {{-- Tombol Cetak --}}
            <div class="mb-3 no-print">
                <button onclick="window.print()" class="btn btn-outline-dark rounded-pill">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
            </div>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success no-print">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger no-print">{{ session('error') }}</div>
            @endif

            {{-- Tabel --}}
            <div id="print-section" class="table-responsive">
                {{-- Header Print --}}
                <div class="text-center mb-4 d-none d-print-block">
                    <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px;">
                    <h2 class="mb-0 mt-2">Daftar Peminjaman Barang</h2>
                    <small>PT. K2NET - Inventory Management System</small>
                    <hr>
                </div>

                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
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
                                <td>
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
                                        <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}"
                                            method="POST" onsubmit="return confirm('Yakin ingin konfirmasi pengembalian?')" class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-dark btn-sm rounded-pill">
                                                <i class="fas fa-check me-1"></i> Konfirmasi
                                            </button>
                                        </form>
                                    @elseif($peminjaman->status == 'dikembalikan')
                                        <form action="{{ route('admin.peminjaman.delete', $peminjaman->id) }}"
                                            method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="d-inline-block">
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
                                <td colspan="7" class="text-center text-muted py-4">Tidak ada data peminjaman.</td>
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
</div>
@endsection
