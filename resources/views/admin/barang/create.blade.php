@extends('layouts.admin')

@section('content')
<div class="pt-4 pb-5 container">
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">

            <h2 class="fw-bold text-dark mb-4 d-flex align-items-center">
                <i class="fas fa-box-open me-2 text-black"></i> Tambah Barang
            </h2>

            <form method="POST" action="{{ route('admin.barangs.save') }}">
                @csrf

                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_barang" class="form-label">Jenis Barang</label>
                    <input type="text" name="jenis_barang" id="jenis_barang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="seri" class="form-label">Seri</label>
                    <input type="text" name="seri" id="seri" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Opsional..."></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
