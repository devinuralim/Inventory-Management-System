@extends('layouts.user')

@section('content')
<div class="pt-3 pb-5">
    <div class="container">
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <h2 class="fw-bold text-dark d-flex align-items-center">
                <i class="fas fa-cart-arrow-down me-2 text-black"></i>
                Peminjaman Barang
            </h2>
        </div>

        @if(session('error'))
            <div class="alert alert-danger shadow-sm">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <form action="{{ route('user.peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <select id="nama_barang" name="nama_barang" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Barang --</option>
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

                    <div class="mb-3 d-none">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control" value="0000-00-00">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Pinjam Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
