@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-box text-center bg-light p-4 shadow-sm rounded">
            <h5>Daftar Barang</h5>
            <h2>{{ $barangCount }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box text-center bg-light p-4 shadow-sm rounded">
            <h5>Daftar Karyawan</h5>
            <h2>{{ $karyawanCount }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box text-center bg-light p-4 shadow-sm rounded">
            <h5>Daftar Peminjaman</h5>
            <h2>{{ $peminjamanCount }}</h2>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header fw-bold">📦 Data Barang Terbaru</div>
    <div class="card-body">
        @if ($barangs->isEmpty())
            <p class="text-muted">Belum ada barang yang tersedia.</p>
        @else
        <table class="table table-bordered table-hover">
            <thead class="table-secondary">
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
        <a href="{{ route('admin.barangs') }}">Selengkapnya...</a>
        @endif
    </div>
</div>
@endsection
