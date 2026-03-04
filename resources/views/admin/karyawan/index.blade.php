@extends('layouts.admin')

@section('content')

<style>
.page-title {
    font-weight: 600;
    font-size: 1.4rem;
}

.card-clean {
    background: #ffffff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.table thead {
    background-color: #f8f9fa;
}

.btn-primary {
    background-color: #0d6efd;
    border: none;
}

.btn-primary:hover {
    background-color: #0b5ed7;
}

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
    .btn-group-flex {
        flex-direction: column;
        gap: 10px;
    }

    .btn-group-flex a,
    .btn-group-flex button,
    .btn-group-flex form {
        width: 100%;
    }
}
</style>

<div class="container pt-2 pb-4">

    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="page-title">Daftar Karyawan</div>
            <small class="text-muted">Kelola data akun dan informasi karyawan</small>
        </div>

        <div class="d-flex flex-wrap gap-2 btn-group-flex">

            <form action="{{ route('admin.karyawans.index') }}" method="GET" class="input-group" style="max-width: 280px;">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control rounded-start-pill"
                    placeholder="Cari karyawan...">
                <button class="btn btn-outline-secondary rounded-end-pill">
                    Cari
                </button>
            </form>

            <a href="{{ route('admin.karyawans.create') }}" class="btn btn-primary rounded-pill">
                Buat Akun
            </a>
        </div>
    </div>

    {{-- Export & Print --}}
    <div class="mb-3 d-flex flex-wrap gap-2 no-print">
        <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill">
            Cetak
        </button>
        <a href="{{ route('admin.karyawans.export.pdf') }}" class="btn btn-danger rounded-pill">
            PDF
        </a>
        <a href="{{ route('admin.karyawans.export.csv') }}" class="btn btn-outline-success rounded-pill">
            CSV
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div id="print-section" class="card-clean table-responsive">

        <div class="text-center mb-4 d-none d-print-block">
            <h4 class="mb-0">Data Karyawan</h4>
            <small>PT. K2NET - Inventory Management System</small>
            <hr>
        </div>

        <table class="table table-hover align-middle table-bordered">
            <thead class="text-center">
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
<tr>
    <td class="text-center">{{ $index + 1 }}</td>
    <td>{{ $karyawan->id_pegawai }}</td>
    <td>{{ $karyawan->nama_lengkap }}</td>
    <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d M Y') }}</td>
    <td>{{ $karyawan->jabatan }}</td>

    <td>
        @if($karyawan->password_plain)
            <div class="input-group input-group-sm">
                <input type="password"
                       class="form-control password-input"
                       value="{{ $karyawan->password_plain }}"
                       readonly>

                <button type="button"
                        class="btn btn-outline-secondary toggle-password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
        @else
            <span class="text-muted">Tidak tersedia</span>
        @endif
    </td>

    <td class="text-center no-print">
        <a href="{{ route('admin.karyawans.edit', $karyawan->id_pegawai) }}"
           class="btn btn-warning btn-sm rounded-pill me-1">
            Edit
        </a>

        <form action="{{ route('admin.karyawans.delete', $karyawan->id_pegawai) }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Yakin ingin menghapus?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm rounded-pill">
                Hapus
            </button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted py-4">
        Tidak ada karyawan ditemukan.
    </td>
</tr>
@endforelse
</tbody>
        </table>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = btn.closest('.input-group').querySelector('.password-input');
            const icon = btn.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("bi-eye-slash");
            }
        });
    });
});
</script>
@endsection
