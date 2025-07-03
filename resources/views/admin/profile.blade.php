@extends('layouts.admin')

@section('content')
<style>
    .profile-card {
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .profile-card .icon-box {
        width: 50px;
        height: 50px;
        background: #0d6efd;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.2rem;
    }
    .profile-label {
        font-weight: 600;
        color: #555;
    }
</style>

<div class="pt-4 pb-5 container">
    <div class="card profile-card border-0 rounded-4 p-4">
        <div class="mb-4 d-flex align-items-center gap-3">
            <div class="icon-box">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <h4 class="mb-0">Profil Admin</h4>
                <small class="text-muted">Informasi akun admin yang sedang login</small>
            </div>
        </div>

        @php
            $user = Auth::user();
            $karyawan = \App\Models\Karyawan::where('id_pegawai', $user->id_pegawai)->first();
        @endphp

        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="profile-label">ID Pegawai</label>
                <div class="form-control bg-light">{{ $user->id_pegawai }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="profile-label">Nama Lengkap</label>
                <div class="form-control bg-light">{{ $user->name }}</div>
            </div>

            @if($karyawan)
            <div class="col-md-6 mb-3">
                <label class="profile-label">Tanggal Bergabung</label>
                <div class="form-control bg-light">{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d M Y') }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="profile-label">Jabatan</label>
                <div class="form-control bg-light">{{ $karyawan->jabatan }}</div>
            </div>
            @endif
        </div>

        @if (!$karyawan)
            <div class="alert alert-warning mt-2">
                Data karyawan untuk akun admin belum tersedia. Silakan hubungi pengelola sistem.
            </div>
        @endif
    </div>
</div>
@endsection
