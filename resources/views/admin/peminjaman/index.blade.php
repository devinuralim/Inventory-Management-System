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
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Judul Daftar Peminjaman Barang --}}
            <h2 class="text-2xl font-bold mb-4 no-print">Daftar Peminjaman Barang</h2>

            {{-- Tombol Cetak --}}
            <div class="mb-3 no-print">
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>

            {{-- Menampilkan Notifikasi Success --}}
            @if(session('success'))
                <div class="alert alert-success no-print">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Menampilkan Notifikasi Error --}}
            @if(session('error'))
                <div class="alert alert-danger no-print">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Tabel Peminjaman --}}
            <div id="print-section" class="table-responsive">
                {{-- Print Header --}}
                <div class="text-center mb-4 d-none d-print-block">
                    <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
                    <h2 class="mb-0">Daftar Peminjaman Barang</h2>
                    <small>PT. K2NET - Sistem Inventory</small>
                    <hr>
                </div>

                <table class="table table-bordered mt-4">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th class="text-center no-print" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->nama_peminjam }}</td>
                                <td>{{ $peminjaman->nama_barang }}</td>
                                <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                <td>{{ $peminjaman->tanggal_kembali }}</td>
                                <td>
                                    <span class="badge {{ $peminjaman->status === 'dipinjam' ? 'bg-danger' : 'bg-success' }}">
                                        {{ ucfirst($peminjaman->status) }}
                                    </span>
                                </td>
                                <td class="text-center no-print">
                                    @if($peminjaman->status == 'menunggu konfirmasi')
                                        <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengonfirmasi pengembalian barang ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    @elseif($peminjaman->status == 'dikembalikan')
                                        <form action="{{ route('admin.peminjaman.delete', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Total Peminjaman --}}
                <div class="mt-4">
                    <strong>Total Peminjaman:</strong> {{ $total }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
