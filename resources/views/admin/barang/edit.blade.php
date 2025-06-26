@extends('layouts.admin')

@section('content')
<div class="pt-4 pb-5 container">
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">

            <!-- Judul Form -->
            <h2 class="fw-bold text-dark mb-4 d-flex align-items-center">
                <i class="fas fa-pen-to-square me-2 text-black"></i> Edit Barang
            </h2>

            <!-- Form Edit Barang -->
            <form method="POST" action="{{ route('admin.barangs.update', $barang->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang"
                        value="{{ old('nama_barang', $barang->nama_barang) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_barang" class="form-label">Jenis Barang</label>
                    <input type="text" name="jenis_barang" id="jenis_barang"
                        value="{{ old('jenis_barang', $barang->jenis_barang) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok"
                        value="{{ old('stok', $barang->stok) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="seri" class="form-label">Seri</label>
                    <input type="text" name="seri" id="seri"
                        value="{{ old('seri', $barang->seri) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"
                        placeholder="Opsional...">{{ old('keterangan', $barang->keterangan) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
