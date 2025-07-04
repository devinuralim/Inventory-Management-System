@extends('layouts.user')

@section('content')
<style>
    .custom-file-label {
        border: 2px dashed #ccc;
        padding: 0.8rem;
        text-align: center;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        font-size: 0.9rem;
    }

    .custom-file-label:hover {
        background-color: #e0e0e0;
    }

    .custom-file-label i {
        font-size: 1.5rem;
        color: #1d3557;
        margin-bottom: 0.3rem;
    }

    .preview-image {
        display: none;
        margin-top: 1rem;
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 576px) {
        .custom-file-label {
            font-size: 0.85rem;
            padding: 0.7rem;
        }

        .custom-file-label i {
            font-size: 1.3rem;
        }
    }
</style>

<div class="container pt-3 pb-5 d-flex flex-column justify-content-start align-items-center" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff); min-height: 85vh;">
    <div class="card shadow border-0 rounded-4 p-4 w-100" style="max-width: 500px;">
        <h4 class="text-center mb-3 fw-bold text-dark">
            <i class="fas fa-upload me-2"></i>Upload Bukti Pengembalian
        </h4>

        {{-- Alert jika ada error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form upload --}}
        <form action="{{ route('user.peminjaman.uploadBukti', $peminjaman->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Upload gambar --}}
            <div class="mb-3">
                <label for="bukti_pengembalian" class="custom-file-label d-block">
                    <i class="fas fa-camera mb-1"></i><br>
                    <span id="file-label-text">Klik untuk ambil/pilih gambar</span>
                    <input 
                        type="file" 
                        name="bukti_pengembalian" 
                        id="bukti_pengembalian" 
                        class="d-none" 
                        accept="image/*" 
                        capture="environment" 
                        required 
                        onchange="previewFile(this)"
                    >
                </label>
                <small class="text-muted d-block mt-1">Format: jpg/jpeg/png | Maks: 2MB</small>
                <img id="preview" class="preview-image mt-2" alt="Preview Gambar">
            </div>

            {{-- Keterangan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Keterangan Pengembalian</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Sudah dikembalikan ke meja admin..." required></textarea>
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('user.peminjaman.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn text-white" style="background-color: #1d3557;">
                    <i class="fas fa-paper-plane me-1"></i> Upload
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewFile(input) {
        const file = input.files[0];
        const preview = document.getElementById('preview');
        const label = document.getElementById('file-label-text');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
            label.innerText = file.name;
        }
    }
</script>
@endsection
