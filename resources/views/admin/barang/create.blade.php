@extends('layouts.admin')

@section('content')

<style>
@media (max-width: 768px) {
    h2 {
        font-size: 1.25rem;
    }

    .form-label {
        font-size: 0.9rem;
    }

    .form-control {
        font-size: 0.9rem;
        padding: 8px 10px;
    }

    .btn {
        font-size: 0.9rem;
        padding: 8px 16px;
    }

    .btn i {
        font-size: 0.9rem;
    }

    .card-body {
        padding: 1.5rem 1rem;
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

.btn-primary {
    transition: all 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #0d47a1 !important;
    transform: scale(1.02);
}
</style>

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

                <div class="d-flex justify-content-between btn-group-flex mt-4">
                    <a href="{{ route('admin.barangs') }}" class="btn btn-secondary rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
