@extends('layouts.admin')

@section('content')
<style>
    .page-title { font-weight: 700; font-size: 1.6rem; color: #0f172a; }
    .card-clean { background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .table thead { background-color: #f8fafc; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .table tbody tr:hover { background-color: #f1f5f9; transition: 0.2s; }
    
    @media print {
        /* Sembunyikan elemen yang tidak perlu */
        .no-print, .btn, .input-group, .alert { display: none !important; }
        
        /* Reset Card agar rata kertas */
        .card-clean { border: none !important; box-shadow: none !important; padding: 0 !important; }
        
        /* Tambahkan header laporan khusus print */
        .d-print-block { display: block !important; }
        
        /* Paksa tabel hitam putih dan garis terlihat jelas */
        table { width: 100% !important; border-collapse: collapse !important; }
        th, td { border: 1px solid #000 !important; padding: 8px !important; color: #000 !important; }
        th { background-color: #f2f2f2 !important; -webkit-print-color-adjust: exact; }
    }
</style>

<div class="container pt-3 pb-5">
    {{-- Header - Sembunyikan saat print --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 no-print">
        <div>
            <div class="page-title">Daftar Karyawan</div>
            <p class="text-muted small mb-0">Kelola data akun dan informasi karyawan secara terpusat</p>
        </div>
        <a href="{{ route('admin.karyawans.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus me-1"></i> Buat Akun
        </a>
    </div>

    {{-- Filter & Action Bar - Sembunyikan saat print --}}
    <div class="card-clean mb-4 no-print">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <form action="{{ route('admin.karyawans.index') }}" method="GET" class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nama/id...">
                    <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="col-md-8 text-md-end">
                <button onclick="window.print()" class="btn btn-sm btn-outline-dark rounded-pill px-3" title="Print Laporan">
                    <i class="fas fa-print me-1"></i> Print
                </button>
                <a href="{{ route('admin.karyawans.export.pdf') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Export PDF">
                    <i class="fas fa-file-pdf me-1"></i> PDF
                </a>
                <a href="{{ route('admin.karyawans.export.csv') }}" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Export CSV">
                    <i class="fas fa-file-csv me-1"></i> CSV
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3 no-print">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Table Area --}}
    <div class="card-clean table-responsive">
        {{-- Judul Laporan yang HANYA muncul saat di-print --}}
        <div class="text-center mb-4 d-none d-print-block">
            <h3 class="mb-1 fw-bold">LAPORAN DATA KARYAWAN</h3>
            <p class="mb-0 text-uppercase" style="font-size: 11px; letter-spacing: 2px;">PT. K2NET - Management System</p>
            <div style="border-bottom: 2px solid #000; margin-top: 15px;"></div>
        </div>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>ID Pegawai</th>
                    <th>Nama</th>
                    <th>Tanggal Bergabung</th>
                    <th>Jabatan</th>
                    <th>Password</th>
                    <th class="text-center no-print">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawans as $index => $karyawan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $karyawan->id_pegawai }}</td>
                        <td>{{ $karyawan->nama_lengkap }}</td>
                        <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d M Y') }}</td>
                        <td><span class="badge bg-light text-dark border rounded-pill">{{ $karyawan->jabatan }}</span></td>
                        <td>
                            @if ($karyawan->password_plain)
                                <div class="input-group input-group-sm no-print" style="max-width: 150px">
                                    <input type="password" class="form-control password-input" value="{{ $karyawan->password_plain }}" readonly>
                                    <button type="button" class="btn btn-outline-secondary toggle-password"><i class="fas fa-eye"></i></button>
                                </div>
                                <span class="d-none d-print-inline">******</span> {{-- Password tidak tampil saat print demi keamanan --}}
                            @else
                                <span class="text-muted small">Tidak tersedia</span>
                            @endif
                        </td>
                        <td class="text-center no-print">
                            <a href="{{ route('admin.karyawans.edit', $karyawan->id_pegawai) }}" class="btn btn-sm btn-outline-warning rounded-circle me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.karyawans.delete', $karyawan->id_pegawai) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">Data karyawan tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer Laporan khusus PRINT --}}
        <div class="mt-4 d-none d-print-block">
            <div class="d-flex justify-content-between">
                <small class="text-muted">Status: Data Karyawan Aktif</small>
                <small class="text-muted">Tanggal Cetak: {{ date('d/m/Y H:i') }}</small>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach((btn) => {
        btn.addEventListener('click', function () {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            input.type = (input.type === 'password') ? 'text' : 'password';
            icon.className = (input.type === 'text') ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });
</script>
@endsection