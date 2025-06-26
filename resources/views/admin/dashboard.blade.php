@extends('layouts.admin')

@section('content')

<div class="py-4">
    {{-- Kartu Ringkasan --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow rounded-4 border-0">
                <div class="card-body py-4" style="background: linear-gradient(to right, #bbdefb, #90caf9); color: #0d47a1;">
                    <div class="mb-2">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <h5 class="card-title mb-1">Total Barang</h5>
                    <h2 class="card-text fw-bold">{{ $barangCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow rounded-4 border-0">
                <div class="card-body py-4" style="background: linear-gradient(to right, #c8e6c9, #a5d6a7); color: #1b5e20;">
                    <div class="mb-2">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h5 class="card-title mb-1">Total Karyawan</h5>
                    <h2 class="card-text fw-bold">{{ $karyawanCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow rounded-4 border-0">
                <div class="card-body py-4" style="background: linear-gradient(to right, #fff9c4, #ffe082); color: #f9a825;">
                    <div class="mb-2">
                        <i class="fas fa-arrow-circle-up fa-2x"></i>
                    </div>
                    <h5 class="card-title mb-1">Total Peminjaman</h5>
                    <h2 class="card-text fw-bold">{{ $peminjamanCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Barang --}}
    <div class="card mb-4 shadow rounded-4 border-0">
        <div class="card-header fw-bold fs-6" style="background-color: #b3e5fc; color: #01579b;">
            <i class="fas fa-box"></i> Barang yang tersedia di kantor
        </div>
        <div class="card-body">
            @if ($barangs->isEmpty())
                <div class="alert alert-secondary" role="alert">
                    Belum ada barang yang tersedia.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">No</th>
                                <th class="text-start">Nama Barang</th>
                                <th class="text-start">Jenis</th>
                                <th class="text-center">Stok</th>
                                <th class="text-start">Seri</th>
                                <th class="text-start">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs->take(5) as $barang)
                                <tr class="align-middle">
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
                <div class="alert alert-secondary" role="alert">
                    Belum ada barang yang dipinjam.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">No</th>
                                <th class="text-start">Nama Barang</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-start">Nama Peminjam</th>
                                <th class="text-center">Tanggal Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans->take(5) as $peminjaman)
                                <tr class="align-middle">
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
