@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }
    .card-glass {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease-in-out;
    }
    .card-glass:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Judul --}}
        <div class="mb-4 text-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-clipboard-list me-2 text-black"></i>Daftar Peminjaman Anda
            </h2>
            <p class="text-muted mt-2">Lihat semua riwayat dan status peminjaman barang milikmu di sini.</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm text-center w-75 mx-auto animate__animated animate__fadeIn">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger shadow-sm text-center w-75 mx-auto animate__animated animate__fadeIn">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="mb-3 text-end">
            <a href="{{ route('user.peminjaman.create') }}" class="btn shadow-sm text-white" style="background-color: #1d3557;">
                <i class="fas fa-plus-circle me-1"></i> Tambah Peminjaman
            </a>
        </div>

        {{-- Tabel --}}
        <div class="card card-glass border-0 rounded-4 animate__animated animate__fadeInUp shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center mb-0">
                        <thead style="background-color: #1d3557; color: white;">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th class="d-none">Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $peminjaman->nama_barang }}</td>
                                    <td>{{ $peminjaman->jumlah }}</td>
                                    <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td class="d-none">{{ $peminjaman->tanggal_kembali }}</td>
                                    <td>
                                        @if ($peminjaman->status == 'dipinjam')
                                            <span class="badge bg-danger">Dipinjam</span>
                                        @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($peminjaman->status == 'dipinjam')
                                            <a href="{{ route('user.peminjaman.kembalikan', $peminjaman->id) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-undo me-1"></i> Kembalikan
                                            </a>
                                        @else
                                            <span class="text-muted small">Barang Sudah Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($peminjaman->status != 'dipinjam')
                                            <form action="{{ route('user.peminjaman.destroy', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peminjaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2 text-secondary"></i><br>
                                        Tidak ada data peminjaman.
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
