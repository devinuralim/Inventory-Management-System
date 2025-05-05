@extends('layouts.admin')

@section('content')

<!-- Dashboard Overview Section -->
<div class="py-4">
    <div class="row mb-4">
        <!-- Card for Barang Count -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm rounded">
                <div class="card-body" style="background-color: #e3f2fd; color: #0d47a1;">
                    <div class="mb-2">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <h5 class="card-title">Total Barang</h5>
                    <h2 class="card-text">{{ $barangCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Card for Karyawan Count -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm rounded">
                <div class="card-body" style="background-color: #e8f5e9; color: #1b5e20;">
                    <div class="mb-2">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h5 class="card-title">Total Karyawan</h5>
                    <h2 class="card-text">{{ $karyawanCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Card for Peminjaman Count -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm rounded">
                <div class="card-body" style="background-color: #fff8e1; color: #f9a825;">
                    <div class="mb-2">
                        <i class="fas fa-arrow-circle-up fa-2x"></i>
                    </div>
                    <h5 class="card-title">Total Peminjaman</h5>
                    <h2 class="card-text">{{ $peminjamanCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Barang Section -->
    <div class="card mb-4">
        <div class="card-header fw-bold" style="background-color: #b3e5fc; color: #01579b;">
            <i class="fas fa-box"></i> Data Barang Terbaru
        </div>
        <div class="card-body">
            @if ($barangs->isEmpty())
                <div class="alert alert-secondary" role="alert">
                    Belum ada barang yang tersedia.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
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
                </div>
                <a href="{{ route('admin.barangs') }}" class="btn btn-outline-primary">Selengkapnya...</a>
            @endif
        </div>
    </div>
</div>

@endsection
