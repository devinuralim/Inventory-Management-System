@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }

    .card-glass {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease-in-out;
    }

    .card-glass:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    /* Responsive adjustment */
    @media (max-width: 576px) {
        .judul-section {
            font-size: 1.4rem;
        }

        .btn {
            width: 100%;
        }

        .text-end {
            text-align: center !important;
        }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Judul --}}
        <div class="text-center mb-4 animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-cart-arrow-down me-2 text-black"></i>Peminjaman Barang
            </h2>
            <p class="text-muted mt-1">Isi formulir di bawah untuk meminjam barang kantor.</p>
        </div>

        {{-- Error --}}
        @if(session('error'))
            <div class="alert alert-danger shadow-sm text-center w-75 mx-auto animate__animated animate__fadeIn">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <div class="card card-glass border-0 rounded-4 animate__animated animate__fadeInUp shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('user.peminjaman.store') }}" method="POST">
                    @csrf

                    <div id="barang-wrapper">
                        <div class="row g-3 align-items-end barang-group mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Barang</label>
                                <select name="nama_barang[]" class="form-select shadow-sm" required>
                                    <option value="" disabled selected>-- Pilih Barang --</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Jumlah</label>
                                <input type="number" name="jumlah[]" class="form-control shadow-sm" min="1" required>
                            </div>
                            <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-danger remove-barang d-none">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Tambah --}}
                    <div class="mb-3 text-end text-md-end">
                        <button type="button" id="add-barang" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Barang
                        </button>
                    </div>

                    {{-- Tanggal Pinjam --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control shadow-sm" required>
                    </div>

                    <input type="hidden" name="tanggal_kembali" value="0000-00-00">

                    {{-- Tombol Submit dan Kembali --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                        <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary shadow-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn text-white shadow-sm" style="background-color: #1d3557;">
                            <i class="fas fa-paper-plane me-1"></i> Pinjam Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- Script --}}
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

                clone.querySelectorAll('input, select').forEach(el => el.value = '');
                clone.querySelector('.remove-barang').classList.remove('d-none');

                wrapper.appendChild(clone);
            }
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.closest('.remove-barang')) {
                e.target.closest('.barang-group').remove();
            }
        });
    });
</script>
@endsection
