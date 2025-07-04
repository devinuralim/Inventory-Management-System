@extends('layouts.user')

@section('content')
<style>
    /* CSS tetap sama, tidak diubah dari sebelumnya */
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Tombol Kembali --}}
        <div class="mb-3">
            <a href="{{ route('user.dashboard') }}"
               class="btn btn-outline-secondary btn-icon btn-back shadow-sm"
               title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        {{-- Judul --}}
        <div class="text-center mb-4 animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-history me-2 text-black"></i>Riwayat Peminjaman
            </h2>
            <p class="text-muted mt-1">Berisi semua peminjaman yang pernah kamu lakukan</p>
        </div>

        {{-- Filter & Action --}}
        <div class="action-wrapper flex-column flex-md-row align-items-start align-items-md-center">
            {{-- Filter --}}
            <form method="GET" action="{{ route('user.peminjaman.riwayat') }}" class="d-flex flex-wrap align-items-center gap-2 mb-3 mb-md-0">
                {{-- Filter Status --}}
                <div>
                    <label for="status" class="fw-semibold text-dark mb-0 me-1"><i class="fas fa-filter me-1"></i>Status</label>
                    <select name="status" id="status" class="form-select form-select-sm w-auto rounded-3 shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="menunggu konfirmasi" {{ request('status') == 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>

                {{-- Filter Waktu --}}
                <div>
                    <label for="waktu" class="fw-semibold text-dark mb-0 me-1"><i class="fas fa-clock me-1"></i>Waktu</label>
                    <select name="waktu" id="waktu" class="form-select form-select-sm w-auto rounded-3 shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="7" {{ request('waktu') == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="30" {{ request('waktu') == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    </select>
                </div>
            </form>

            {{-- Tombol Aksi --}}
            <div class="action-right">
                <button onclick="window.print()" class="btn btn-icon btn-sm btn-outline-dark" title="Print">
                    <i class="fas fa-print"></i>
                </button>
                <a href="{{ route('user.riwayat.export.pdf') }}" class="btn btn-icon btn-sm btn-danger" title="Export PDF">
                    <i class="fas fa-file-pdf"></i>
                </a>
                <a href="{{ route('user.riwayat.export.csv') }}" class="btn btn-icon btn-sm btn-success" title="Export CSV">
                    <i class="fas fa-file-csv"></i>
                </a>
                <a href="{{ route('user.peminjaman.index') }}" class="btn btn-ajukan btn-sm" title="Ajukan Peminjaman">
                    <i class="fas fa-plus"></i> Peminjaman
                </a>
            </div>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="card card-glass border-0 rounded-4 animate__animated animate__fadeInUp" id="print-section">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center mb-0">
                        <thead style="background-color: #1d3557; color: white;">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $peminjaman->nama_barang }}</td>
                                    <td>{{ $peminjaman->jumlah }}</td>
                                    <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td>
                                        @if ($peminjaman->status == 'dipinjam')
                                            <span class="badge bg-danger">Dipinjam</span>
                                        @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2 text-secondary"></i><br>
                                        Belum ada riwayat peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
