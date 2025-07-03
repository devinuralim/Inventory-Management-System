@php
    $layout = Auth::user()->role == 'admin' ? 'layouts.admin' : 'layouts.user';
@endphp

@extends($layout)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <h2 class="mb-4 text-center">Profil Saya</h2>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    Informasi Akun
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">ID Pegawai</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->id_pegawai }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->email ?? '-' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->role }}" readonly>
                    </div>

                    <div class="alert alert-info mt-4">
                        Untuk mengubah data akun, silakan hubungi admin.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
