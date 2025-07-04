@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }

    .profile-card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        transition: 0.3s ease-in-out;
        padding: 1.5rem;
    }

    .profile-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .profile-label {
        font-weight: 600;
        color: #1d3557;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }

    .form-control[readonly], .form-control.bg-light {
        background-color: #f8f9fa;
        border: 1px solid #e2e6ea;
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.95rem;
        color: #333;
    }

    @media (max-width: 768px) {
        .profile-card {
            padding: 1rem;
        }

        .profile-label {
            font-size: 0.9rem;
        }

        .form-control.bg-light {
            font-size: 0.9rem;
            padding: 8px 10px;
        }

        .btn.rounded-circle {
            width: 38px;
            height: 38px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn.rounded-circle i {
            font-size: 1rem;
        }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Tombol Kembali di pojok kiri atas, icon saja --}}
        <div class="text-start mb-3">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-circle shadow-sm" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        {{-- Judul --}}
        <div class="text-center mb-4 animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-user-circle me-2 text-black"></i>Profil Saya
            </h2>
            <p class="text-muted">Informasi karyawan yang sedang login</p>
        </div>

        {{-- Kartu Profil --}}
        <div class="card profile-card border-0 animate__animated animate__fadeInUp">
            @php
                $karyawan = \App\Models\Karyawan::where('id_pegawai', Auth::user()->id_pegawai)->first();
            @endphp

            @if ($karyawan)
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="profile-label">ID Pegawai</label>
                        <div class="form-control bg-light" readonly>{{ $karyawan->id_pegawai }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="profile-label">Nama Lengkap</label>
                        <div class="form-control bg-light" readonly>{{ $karyawan->nama_lengkap }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="profile-label">Tanggal Bergabung</label>
                        <div class="form-control bg-light" readonly>
                            {{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="profile-label">Jabatan</label>
                        <div class="form-control bg-light" readonly>{{ $karyawan->jabatan }}</div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Data karyawan belum tersedia. Silakan hubungi admin.
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
