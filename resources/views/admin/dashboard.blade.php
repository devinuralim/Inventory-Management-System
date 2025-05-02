@extends('layouts.admin')

@section('content')
<!-- Dashboard Overview Section -->
<div class="row mb-4">
    <!-- Card for Barang Count -->
    <div class="col-md-4">
        <div class="card text-center shadow-sm rounded">
            <div class="card-body bg-primary text-white">
                <h5 class="card-title">Daftar Barang</h5>
                <h2 class="card-text">{{ $barangCount }}</h2>
            </div>
        </div>
    </div>

    <!-- Card for Karyawan Count -->
    <div class="col-md-4">
        <div class="card text-center shadow-sm rounded">
            <div class="card-body bg-success text-white">
                <h5 class="card-title">Daftar Karyawan</h5>
                <h2 class="card-text">{{ $karyawanCount }}</h2>
            </div>
        </div>
    </div>

    <!-- Card for Peminjaman Count -->
    <div class="col-md-4">
        <div class="card text-center shadow-sm rounded">
            <div class="card-body bg-warning text-white">
                <h5 class="card-title">Daftar Peminjaman</h5>
                <h2 class="card-text">{{ $peminjamanCount }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Latest Barang Section -->
<div class="card mb-4">
    <div class="card-header fw-bold bg-info text-white">
        <i class="fas fa-box"></i> Data Barang Terbaru
    </div>
    <div class="card-body">
        @if ($barangs->isEmpty())
            <div class="alert alert-info" role="alert">
                Belum ada barang yang tersedia.
            </div>
        @else
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Stok</th>
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
                        <td>{{ $barang->stok }}</td>
                        <td>{{ $barang->seri }}</td>
                        <td>{{ $barang->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.barangs') }}" class="btn btn-info">Selengkapnya...</a>
        @endif
    </div>
</div>

@endsection
