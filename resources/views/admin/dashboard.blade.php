@extends('layouts.admin')

@push('styles')
<style>
    /* Statistik Card Hover */
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .stat-card .stat-icon {
            font-size: 1.5rem;
        }

        .stat-card h5 {
            font-size: 0.95rem;
        }

        .stat-card h2 {
            font-size: 1.3rem;
        }
    }
</style>
@endpush

@section('content')
<div class="py-4">

    {{-- Statistik Ringkasan --}}
    <div class="row mb-4">
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="card stat-card text-center shadow rounded-4 border-0">
                <div class="card-body py-4" style="background: linear-gradient(to right, #e3f2fd, #90caf9); color: #0d47a1;">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h5 class="card-title">Total Barang</h5>
                    <h2 class="fw-bold">{{ $barangCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="card stat-card text-center shadow rounded-4 border-0">
                <div class="card-body py-4" style="background: linear-gradient(to right, #e8f5e9, #a5d6a7); color: #1b5e20;">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="card-title">Total Karyawan</h5>
                    <h2 class="fw-bold">{{ $karyawanCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card stat-card text-center shadow rounded-4 border-0">
                <div class="card-body py-4" style="background: linear-gradient(to right, #fff9c4, #ffe082); color: #f9a825;">
                    <div class="stat-icon">
                        <i class="fas fa-arrow-circle-up"></i>
                    </div>
                    <h5 class="card-title">Total Peminjaman</h5>
                    <h2 class="fw-bold">{{ $peminjamanCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Barang Terbanyak Dipinjam --}}
    @if ($barangTerbanyak)
        <div class="alert alert-info shadow-sm rounded-4 border-0">
            <strong><i class="fas fa-crown me-1"></i> Barang paling banyak dipinjam:</strong>
            {{ $barangTerbanyak->nama_barang }} ({{ $barangTerbanyak->total }} kali)
        </div>
    @endif

    {{-- Notifikasi --}}
    @if(isset($notifikasiCount) && $notifikasiCount > 0)
        <div class="alert alert-danger shadow-sm rounded-4 border-0">
            <strong><i class="fas fa-bell me-1"></i> Notifikasi:</strong>
            Ada <strong>{{ $notifikasiCount }}</strong> peminjaman yang menunggu konfirmasi.
            <a href="{{ route('admin.peminjaman.index') }}" class="ms-2 text-decoration-underline">Lihat Detail</a>
        </div>
    @endif

    {{-- Tabel Barang --}}
    <div class="card mb-4 shadow rounded-4 border-0">
        <div class="card-header fw-bold fs-6" style="background-color: #b3e5fc; color: #01579b;">
            <i class="fas fa-box"></i> Barang yang tersedia di kantor
        </div>
        <div class="card-body">
            @if ($barangs->isEmpty())
                <div class="alert alert-secondary">Belum ada barang yang tersedia.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th class="text-center">Stok</th>
                                <th>Seri</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs->take(5) as $barang)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->jenis_barang }}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill text-bg-primary px-3 py-2">
                                            {{ $barang->stok }}
                                        </span>
                                    </td>
                                    <td>{{ $barang->seri }}</td>
                                    <td>{{ $barang->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.barangs') }}" class="btn btn-outline-primary mt-2">Selengkapnya...</a>
            @endif
        </div>
    </div>

    {{-- Tabel Peminjaman --}}
    <div class="card mb-4 shadow rounded-4 border-0">
        <div class="card-header fw-bold fs-6" style="background-color: #ffecb3; color: #ff6f00;">
            <i class="fas fa-arrow-circle-up"></i> Barang yang dipinjam karyawan
        </div>
        <div class="card-body">
            @if ($peminjamans->isEmpty())
                <div class="alert alert-secondary">Belum ada barang yang dipinjam.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th class="text-center">Jumlah</th>
                                <th>Nama Peminjam</th>
                                <th class="text-center">Tanggal Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $peminjaman->nama_barang }}</td>
                                    <td class="text-center">{{ $peminjaman->jumlah }}</td>
                                    <td>{{ $peminjaman->nama_peminjam }}</td>
                                    <td class="text-center">{{ $peminjaman->tanggal_pinjam }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-warning mt-2">Selengkapnya...</a>
            @endif
        </div>
    </div>
</div>
@endsection
