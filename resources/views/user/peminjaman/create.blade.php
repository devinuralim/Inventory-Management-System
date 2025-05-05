@extends('layouts.user')

@section('content')
<div class="py-12">
    <div class="container mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Peminjaman Barang</h2>

        <div class="card shadow-sm">
            <div class="card-body text-gray-900">
                @if(session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('user.peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" id="nama_peminjam" name="nama_peminjam" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <select id="nama_barang" name="nama_barang" class="form-select" required>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Barang</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control" required>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Pinjam Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
