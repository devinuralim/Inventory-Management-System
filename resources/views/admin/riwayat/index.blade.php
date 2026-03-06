@extends('layouts.admin')
{{-- Pastikan nama layout utama Anda benar --}}

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Riwayat Peminjaman</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Reporting</li>
                        <li class="breadcrumb-item active">Riwayat</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.riwayat.pdf', ['search' => request('search')]) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf me-2"></i>
                PDF
            </a>

            <a href="{{ route('admin.riwayat.csv', ['search' => request('search')]) }}" class="btn btn-success">
                <i class="fas fa-file-csv me-2"></i>
                CSV
            </a>

            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>
                Print
            </button>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('admin.riwayat.index') }}" method="GET" class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input
                                type="text"
                                name="search"
                                class="form-control border-start-0 ps-0"
                                placeholder="Cari nama peminjam atau nama barang..."
                                value="{{ request('search') }}" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary">Daftar Pengembalian Selesai</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Peminjam</th>
                                <th>Barang</th>
                                <th class="text-center">Jumlah</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat as $index => $item)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $item->nama_peminjam }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-box me-1"></i>
                                            {{ $item->nama_barang }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="text-success">
                                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success px-3">
                                            Selesai
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $item->keterangan ?? '-' }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <img
                                            src="https://illustrations.popsy.co/gray/data-report.svg"
                                            alt="no-data"
                                            style="width: 150px"
                                            class="mb-3" />
                                        <p class="text-muted">Tidak ada riwayat peminjaman yang ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styling khusus agar senada dengan sidebar Anda */
        .btn-primary {
            background-color: #457b9d;
            border-color: #457b9d;
        }
        .btn-primary:hover {
            background-color: #1d3557;
            border-color: #1d3557;
        }
        .text-primary {
            color: #1d3557 !important;
        }
        .breadcrumb-item a {
            color: #457b9d;
            text-decoration: none;
        }
        .table thead th {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
@endsection
