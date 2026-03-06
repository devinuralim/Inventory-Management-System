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

    /* Glassmorphism Effect */
    .card-glass {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .form-label {
        color: var(--primary-blue);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(29, 53, 87, 0.1);
    }

    /* Barang Group Styling */
    .barang-group {
        background: #f8fafc;
        padding: 15px;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
    }

    .btn-remove {
        background-color: #fee2e2;
        color: #dc2626;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        transition: 0.2s;
    }

    .btn-remove:hover {
        background-color: #dc2626;
        color: white;
    }

    @media (max-width: 576px) {
        .judul-section { font-size: 1.2rem; }
        .btn-submit { width: 100%; }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);">
    <div class="container">

        {{-- Action Bar --}}
        <div class="mb-4">
            <a href="{{ route('user.peminjaman.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>

        {{-- Judul Tanpa Icon --}}
        <div class="text-center mb-5 animate__animated animate__fadeIn">
            <h2 class="judul-section">Peminjaman Barang</h2>
            <p class="text-muted small mt-2">Silakan isi detail barang yang ingin Anda pinjam.</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 w-100 w-md-75 mx-auto mb-4 animate__animated animate__shakeX">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-glass animate__animated animate__fadeInUp">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('user.peminjaman.store') }}" method="POST">
                            @csrf

                            <div id="barang-wrapper">
                                <div class="barang-group mb-3 animate__animated animate__fadeIn">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-7">
                                            <label class="form-label fw-bold">Nama Barang</label>
                                            <select name="nama_barang[]" class="form-select" required>
                                                <option value="" disabled selected>-- Pilih Barang --</option>
                                                @foreach ($barangs as $barang)
                                                    <option value="{{ $barang->nama_barang }}">{{ $barang->nama_barang }} (Stok: {{ $barang->stok }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Jumlah</label>
                                            <input type="number" name="jumlah[]" class="form-control" min="1" placeholder="0" required>
                                        </div>

                                        <div class="col-md-2 text-end">
                                            <button type="button" class="btn-remove remove-barang d-none">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 mt-2">
                                <button type="button" id="add-barang" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="fas fa-plus-circle me-1"></i> Tambah Barang Lain
                                </button>
                                <hr class="my-4 opacity-25">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Tanggal Peminjaman</label>
                                <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                                <small class="text-muted mt-1 d-block">Tanggal saat Anda mengambil barang.</small>
                            </div>

                            <div class="d-flex flex-column flex-md-row justify-content-end gap-3 mt-5">
                                <button type="reset" class="btn btn-light rounded-pill px-4 text-muted">Reset</button>
                                <button type="submit" class="btn text-white rounded-pill px-5 shadow btn-submit" style="background-color: var(--primary-blue);">
                                    Ajukan Peminjaman <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
                
                <p class="text-center text-muted small mt-4">
                    <i class="fas fa-info-circle me-1"></i> Peminjaman akan diproses oleh admin untuk persetujuan.
                </p>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const addBtn = document.getElementById('add-barang');
    const wrapper = document.getElementById('barang-wrapper');
    const maxFields = 5;

    addBtn.addEventListener('click', function () {
        const barangGroups = wrapper.querySelectorAll('.barang-group');
        if (barangGroups.length < maxFields) {
            const first = barangGroups[0];
            const clone = first.cloneNode(true);

            // Bersihkan input dan tampilkan tombol hapus
            clone.querySelectorAll('input, select').forEach(el => el.value = '');
            clone.querySelector('.remove-barang').classList.remove('d-none');
            
            // Tambah animasi saat muncul
            clone.classList.add('animate__animated', 'animate__slideInDown');

            wrapper.appendChild(clone);
        } else {
            alert('Maksimal peminjaman adalah 5 jenis barang sekaligus.');
        }
    });

    wrapper.addEventListener('click', function (e) {
        if (e.target.closest('.remove-barang')) {
            const group = e.target.closest('.barang-group');
            group.classList.remove('animate__slideInDown');
            group.classList.add('animate__fadeOut');
            setTimeout(() => group.remove(), 400);
        }
    });
});
</script>
@endsection