@extends('layouts.admin')

@section('content')
<style>
    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .icon-box {
        width: 60px;
        height: 60px;
        background: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        font-size: 1.5rem;
    }
    .profile-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .data-value {
        padding: 0.75rem 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-weight: 500;
        color: #0f172a;
    }
</style>

<div class="pt-4 pb-5 container">
    <div class="card profile-card border-0 p-4 p-md-5">
        <div class="mb-5 d-flex align-items-center gap-4">
            <div class="icon-box shadow-sm">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-1">Profil Admin</h3>
                <p class="text-muted mb-0">Informasi detail akun administrator</p>
            </div>
        </div>

        @php
            $user = Auth::user();
            $karyawan = \App\Models\Karyawan::where('id_pegawai', $user->id_pegawai)->first();
        @endphp

        <div class="row g-4">
            <div class="col-md-6">
                <div class="profile-label">ID Pegawai</div>
                <div class="data-value">{{ $user->id_pegawai }}</div>
            </div>
            <div class="col-md-6">
                <div class="profile-label">Nama Lengkap</div>
                <div class="data-value">{{ $user->name }}</div>
            </div>

            @if($karyawan)
            <div class="col-md-6">
                <div class="profile-label">Tanggal Bergabung</div>
                <div class="data-value">{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d F Y') }}</div>
            </div>
            <div class="col-md-6">
                <div class="profile-label">Jabatan</div>
                <div class="data-value">{{ $karyawan->jabatan }}</div>
            </div>
            @endif
        </div>

        @if (!$karyawan)
            <div class="alert alert-warning border-0 rounded-4 mt-4 d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3"></i> 
                Data karyawan untuk akun admin belum tersedia. Silakan hubungi pengelola sistem.
            </div>
        @endif
    </div>
</div>
@endsection