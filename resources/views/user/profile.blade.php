{{-- resources/views/user/profile.blade.php --}}
@extends('layouts.user')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <h2 class="mb-4 text-center">Profil Saya</h2>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- INFORMASI PROFIL --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">Informasi Profil</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>

            {{-- GANTI PASSWORD --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark fw-bold">Ganti Password</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Lama</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning text-dark">
                            <i class="bi bi-key"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- HAPUS AKUN --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white fw-bold">Hapus Akun</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.profile.destroy') }}">
                        @csrf
                        @method('DELETE')

                        <p class="mb-3">Apakah kamu yakin ingin menghapus akun ini? Tindakan ini tidak bisa dibatalkan.</p>

                        <div class="mb-3">
                            <label for="password_delete" class="form-label">Masukkan Password untuk Konfirmasi</label>
                            <input type="password" name="password" id="password_delete" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus Akun
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
