@extends('layouts.user')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary-blue: #1d3557;
        --highlight: #00b4d8;
    }

    .judul-section {
        border-bottom: 3px solid var(--highlight);
        display: inline-block;
        padding-bottom: 6px;
        color: var(--primary-blue);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Custom Upload Box */
    .upload-area {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .upload-area:hover {
        border-color: var(--primary-blue);
        background: #f1f5f9;
    }

    .upload-area i {
        font-size: 2.5rem;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .preview-image {
        display: none;
        width: 100%;
        max-height: 300px;
        object-fit: contain;
        border-radius: 12px;
        margin-top: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #e2e8f0;
    }

    @media (max-width: 576px) {
        .btn-action { width: 100%; }
        .judul-section { font-size: 1.1rem; }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);">
    <div class="container d-flex flex-column align-items-center">

        {{-- Judul Tanpa Icon --}}
        <div class="text-center mb-4 animate__animated animate__fadeIn">
            <h2 class="judul-section">Bukti Pengembalian</h2>
            <p class="text-muted small mt-2">Upload foto barang sebagai bukti sudah dikembalikan.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 w-100 animate__animated animate__fadeInUp" style="max-width: 550px;">
            <div class="card-body p-4 p-md-5">
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.peminjaman.uploadBukti', $peminjaman->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4 text-center">
                        <span class="badge bg-light text-primary border px-3 py-2 rounded-pill mb-3">
                            Barang: {{ $peminjaman->nama_barang }}
                        </span>
                    </div>

                    {{-- Upload Box --}}
                    <div class="mb-4">
                        <label for="bukti_pengembalian" class="upload-area d-block" id="drop-area">
                            <div id="upload-placeholder">
                                <i class="fas fa-camera"></i>
                                <p class="mb-0 fw-bold text-dark">Klik untuk Ambil Foto</p>
                                <small class="text-muted">Gunakan kamera HP atau pilih file</small>
                            </div>
                            
                            <img id="preview" class="preview-image" alt="Preview">
                            
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
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase" style="color: var(--primary-blue);">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Barang sudah diletakkan di lemari alat..." required></textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 pt-3">
                        <a href="{{ route('user.peminjaman.index') }}" class="btn btn-light rounded-pill px-4 text-muted btn-action">
                            Batal
                        </a>
                        <button type="submit" class="btn text-white rounded-pill px-5 shadow btn-action" style="background-color: var(--primary-blue);">
                            Kirim Bukti <i class="fas fa-check-circle ms-2"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
    function previewFile(input) {
        const file = input.files[0];
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('upload-placeholder');
        const dropArea = document.getElementById('drop-area');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
                dropArea.style.borderStyle = 'solid';
                dropArea.style.borderColor = '#1d3557';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection