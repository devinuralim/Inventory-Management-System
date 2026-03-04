@extends('layouts.admin')

@section('content')

<style>
.page-title {
    font-weight: 600;
    font-size: 1.4rem;
}

.form-wrapper {
    background: #ffffff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.form-label {
    font-weight: 500;
}

.form-control {
    border-radius: 12px;
}

.btn-primary {
    background-color: #0d6efd;
    border: none;
    transition: all 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #0b5ed7;
}

@media (max-width: 768px) {
    .form-wrapper {
        padding: 18px;
    }

    .btn-group-flex {
        flex-direction: column;
        gap: 10px;
    }

    .btn-group-flex a,
    .btn-group-flex button {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="container pt-2 pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <div class="page-title">
            Edit Barang
        </div>
        <small class="text-muted">Perbarui data barang yang sudah ada</small>
    </div>

    {{-- Form --}}
    <div class="form-wrapper">

        <form method="POST" action="{{ route('admin.barangs.update', $barang->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang"
                    value="{{ old('nama_barang', $barang->nama_barang) }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="jenis_barang" class="form-label">Jenis Barang</label>
                <input type="text" name="jenis_barang" id="jenis_barang"
                    value="{{ old('jenis_barang', $barang->jenis_barang) }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" id="stok"
                    value="{{ old('stok', $barang->stok) }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="seri" class="form-label">Seri</label>
                <input type="text" name="seri" id="seri"
                    value="{{ old('seri', $barang->seri) }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan"
                    class="form-control" rows="3"
                    placeholder="Opsional...">{{ old('keterangan', $barang->keterangan) }}</textarea>
            </div>

            <div class="d-flex justify-content-between btn-group-flex mt-4">
                <a href="{{ route('admin.barangs') }}" class="btn btn-outline-secondary rounded-pill">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    Update
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
