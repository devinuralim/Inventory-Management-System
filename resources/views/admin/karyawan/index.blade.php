@extends('layouts.admin')

@section('content')
<style>
@media print {
    body * {
        visibility: hidden !important;
    }

    #print-section, #print-section * {
        visibility: visible !important;
    }

    #print-section {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }
}

@media (max-width: 768px) {
    h2 {
        font-size: 1.3rem;
    }

    .form-control, .btn {
        font-size: 0.9rem;
    }

    .table th, .table td {
        font-size: 0.85rem;
        padding: 6px;
    }

    .input-group input {
        font-size: 0.85rem;
    }

    .btn i {
        font-size: 0.85rem;
    }

    .card-body {
        padding: 1.5rem 1rem;
    }
}
</style>

<div class="container pt-4 pb-5">
    <div class="card shadow-sm border-0 rounded-4 p-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <h2 class="fw-bold text-dark d-flex align-items-center mb-0">
                <i class="fas fa-users me-2 text-dark"></i> Daftar Karyawan
            </h2>
            <div class="d-flex flex-wrap gap-2">
                {{-- Form Search --}}
                <form action="{{ route('admin.karyawans.index') }}" method="GET" class="input-group shadow-sm" style="max-width: 300px;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-start-pill border-end-0" placeholder="Cari nama, ID, jabatan...">
                    <button class="btn btn-outline-primary rounded-end-pill border-start-0" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('admin.karyawans.create') }}" class="btn btn-success rounded-pill">
                    <i class="fas fa-user-plus me-1"></i> Buat Akun
                </a>
            </div>
        </div>

        {{-- Tombol Export & Cetak --}}
        <div class="mb-3 d-flex flex-wrap gap-2 no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="{{ route('admin.karyawans.export.pdf') }}" class="btn btn-danger rounded-pill">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('admin.karyawans.export.csv') }}" class="btn btn-outline-success rounded-pill">
                <i class="fas fa-file-excel"></i> CSV
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div id="print-section" class="table-responsive">
            <div class="text-center mb-4 d-none d-print-block">
                <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px;">
                <h2 class="mb-0">Data Karyawan</h2>
                <small>PT. K2NET - Inventory Management System</small>
                <hr>
            </div>

            <table class="table table-hover align-middle table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>ID Pegawai</th>
                        <th>Nama</th>
                        <th>Tanggal Bergabung</th>
                        <th>Jabatan</th>
                        <th>Password</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyawans as $index => $karyawan)
                        @php
                            $user = \App\Models\User::where('id_pegawai', $karyawan->id_pegawai)->first();
                        @endphp
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $karyawan->id_pegawai }}</td>
                            <td>{{ $karyawan->nama_lengkap }}</td>
                            <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d M Y') }}</td>
                            <td>{{ $karyawan->jabatan }}</td>
                            <td>
                                @if($user && $user->password_plain)
                                    <div class="input-group input-group-sm">
                                        <input type="password" class="form-control password-input" value="{{ $user->password_plain }}" readonly>
                                        <button type="button" class="btn btn-outline-secondary toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </td>
                            <td class="text-center no-print">
                                <a href="{{ route('admin.karyawans.edit', $karyawan->id_pegawai) }}" class="btn btn-warning btn-sm rounded-pill me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.karyawans.delete', $karyawan->id_pegawai) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm rounded-pill">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-user-times fa-2x mb-2 text-secondary"></i><br>
                                Tidak ada karyawan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.toggle-password').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = btn.closest('.input-group').querySelector('.password-input');
                if (input.type === "password") {
                    input.type = "text";
                    btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    input.type = "password";
                    btn.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    });
</script>
@endsection
