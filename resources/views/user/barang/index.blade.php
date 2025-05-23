@extends('layouts.user')

@section('content')
<div class="py-12">
    <div class="container mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Barang</h2>

        <!-- Form Pencarian -->
        <form action="{{ route('user.barang.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari barang...">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-left">Nama Barang</th>
                            <th class="text-left">Jenis Barang</th>
                            <th class="text-center">Stok</th>
                            <th class="text-left">Seri</th>
                            <th class="text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $barang)
                            <tr>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->jenis_barang }}</td>
                                <td class="text-center">{{ $barang->stok }}</td>
                                <td>{{ $barang->seri }}</td>
                                <td>{{ $barang->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500">Tidak ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
