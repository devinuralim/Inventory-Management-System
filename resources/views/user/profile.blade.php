@extends('layouts.user')

@section('content')
<style>
    .profile-card {
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        animation: fadeInDown 0.8s ease;
        background-color: #ffffff;
    }
    .icon-box {
        width: 60px;
        height: 60px;
        background: #1d3557;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.4rem;
    }
    .profile-label {
        font-weight: 600;
        color: #444;
        margin-bottom: 6px;
    }
    .form-control[readonly], .form-control.bg-light {
        background-color: #f8f9fa;
        border: 1px solid #e2e6ea;
        box-shadow: none;
    }
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="pt-4 pb-5 bg-light min-vh-100">
    <div class="container">

        {{-- Judul --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark border-bottom border-primary border-3 d-inline-block pb-1">
                <i class="fas fa-user-circle me-2 text-black"></i>Profil Saya
            </h2>
            <p class="text-muted">Informasi karyawan yang sedang login</p>
        </div>

        <div class="card profile-card border-0 p-4">
            @php
                $karyawan = \App\Models\Karyawan::where('id_pegawai', Auth::user()->id_pegawai)->first();
            @endphp

            @if ($karyawan)
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="profile-label">ID Pegawai</label>
                        <div class="form-control bg-light" readonly>{{ $karyawan->id_pegawai }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="profile-label">Nama Lengkap</label>
                        <div class="form-control bg-light" readonly>{{ $karyawan->nama_lengkap }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="profile-label">Tanggal Bergabung</label>
                        <div class="form-control bg-light" readonly>
                            {{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="profile-label">Jabatan</label>
                        <div class="form-control bg-light" readonly>{{ $karyawan->jabatan }}</div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Data karyawan belum tersedia. Silakan hubungi admin.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
