@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm rounded-lg p-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-dark font-weight-bold">Daftar Barang</h1>

            <!-- Pencarian dan Tambah -->
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

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th class="text-left text-dark">NO</th>
                        <th class="text-left text-dark">Nama</th>
                        <th class="text-left text-dark">Jenis</th>
                        <th class="text-center text-dark">Stok</th>
                        <th class="text-left text-dark">Seri</th>
                        <th class="text-left text-dark">Keterangan</th>
                        <th class="text-center text-dark">Aksi</th>
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
                            <td class="align-middle text-center">
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
