@extends('layouts.admin')

@section('content')
<style>
    .form-label {
        font-weight: 600;
        color: #1d3557;
    }

    .card-custom {
        border: none;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        background: #ffffff;
    }

    .btn-custom {
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
    }

    .form-check-label {
        font-size: 0.95rem;
        color: #333;
    }

    @media (max-width: 768px) {
        h4 {
            font-size: 1.25rem;
        }

        .form-control {
            font-size: 0.9rem;
        }

        .btn {
            font-size: 0.9rem;
        }
    }
</style>

<div class="container py-4">
    <div class="card card-custom">

        {{-- Judul --}}
        <h4 class="mb-4 text-dark d-flex align-items-center">
            <i class="fas fa-edit me-2 text-success"></i> Edit Pengumuman
        </h4>

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ups!</strong> Ada kesalahan saat input:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="isi" class="form-label">Isi</label>
                <textarea name="isi" class="form-control" rows="4" required>{{ old('isi', $pengumuman->isi) }}</textarea>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" name="tampilkan" class="form-check-input" id="tampilkan" {{ old('tampilkan', $pengumuman->tampilkan) ? 'checked' : '' }}>
                <label class="form-check-label" for="tampilkan">Tampilkan ke pengguna</label>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-success btn-custom">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary btn-custom">
                    <i class="fas fa-arrow-left me-1"></i> Batal
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
