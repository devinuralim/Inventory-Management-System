@extends('layouts.admin')

@section('content')
<style>
    .form-section {
        background: #f9f9f9;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 12px;
    }

    .btn-submit {
        background-color: #4caf50;
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 30px;
        padding: 10px 24px;
    }

    .btn-submit:hover {
        background-color: #45a049;
    }

    .btn-cancel {
        border-radius: 30px;
        padding: 10px 24px;
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
        }

        h4 {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container py-4">
    <div class="form-section">
        <h4 class="mb-3"><i class="fas fa-bullhorn me-2 text-success"></i> Tambah Pengumuman</h4>

        <form action="{{ route('admin.pengumuman.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul pengumuman">
            </div>

            <div class="mb-3">
                <label for="isi" class="form-label">Isi Pengumuman</label>
                <textarea name="isi" class="form-control" rows="4" required placeholder="Tulis isi pengumuman di sini..."></textarea>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="tampilkan" class="form-check-input" id="tampilkan" checked>
                <label class="form-check-label" for="tampilkan">Tampilkan ke pengguna</label>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary btn-cancel">
                    <i class="fas fa-arrow-left me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
