@extends('layouts.admin')

@section('content')
<style>
@media print {
    body * { visibility: hidden !important; }
    #print-section, #print-section * { visibility: visible !important; }
    #print-section { position: absolute; top: 0; left: 0; width: 100%; }
    .no-print { display: none !important; }
}
</style>

<div class="pt-4 pb-5 container">
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">
            
            <!-- Header -->
            <div class="d-flex align-items-center justify-content-between mb-4 no-print">
                <h2 class="fw-bold text-dark d-flex align-items-center mb-0">
                    <i class="fas fa-users me-2 text-black"></i> Daftar Karyawan
                </h2>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.karyawans.create') }}" class="btn btn-dark btn-sm rounded-pill px-4">
                        <i class="fas fa-user-plus me-1"></i> Tambah
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                </div>
            </div>

            <!-- Notifikasi -->
            @if(Session::has('success'))
                <div class="alert alert-success shadow-sm no-print">
                    <i class="fas fa-check-circle me-2"></i>{{ Session::get('success') }}
                </div>
            @endif

            <!-- Tabel -->
            <div id="print-section" class="table-responsive">
                <div class="text-center mb-4 d-none d-print-block">
                    <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
                    <h2 class="mb-0">Data Karyawan</h2>
                    <small>PT. K2NET - Inventory Management System</small>
                    <hr>
                </div>
                
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>ID Pegawai</th>
                            <th>Nama Lengkap</th>
                            <th>Tgl Bergabung</th>
                            <th>Jabatan</th>
                            <th class="no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawans as $karyawan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $karyawan->id_pegawai }}</td>
                                <td>{{ $karyawan->nama_lengkap }}</td>
                                <td>{{ $karyawan->tanggal_bergabung }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $karyawan->jabatan }}</span>
                                </td>
                                <td class="text-center no-print">
                                    <a href="{{ route('admin.karyawans.edit', $karyawan->id_pegawai) }}"
                                       class="btn btn-warning btn-sm rounded-pill me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.karyawans.delete', $karyawan->id_pegawai) }}"
                                          method="POST" class="d-inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm rounded-pill"
                                                onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    <i class="fas fa-user-friends fa-2x mb-2 text-secondary"></i><br>
                                    Tidak ada karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
