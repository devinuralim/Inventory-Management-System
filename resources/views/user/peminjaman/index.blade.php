@extends('layouts.user')

@section('content')
<div class="pt-3 pb-5">
    <div class="container">
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <h2 class="fw-bold text-dark d-flex align-items-center">
                <i class="fas fa-clipboard-list me-2 text-black"></i>
                Daftar Peminjaman Anda
            </h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger shadow-sm">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="mb-3 text-end">
            <a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Tambah Peminjaman
            </a>
        </div>
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary text-center">
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
                                    <td class="text-center">{{ $peminjaman->jumlah }}</td>
                                    <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td class="d-none">{{ $peminjaman->tanggal_kembali }}</td>
                                    <td class="text-center">
                                        @if ($peminjaman->status == 'dipinjam')
                                            <span class="badge bg-danger">Dipinjam</span>
                                        @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($peminjaman->status == 'dipinjam')
                                            <a href="{{ route('user.peminjaman.kembalikan', $peminjaman->id) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-undo me-1"></i> Kembalikan
                                            </a>
                                        @else
                                            <span class="text-muted small">Barang Sudah Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
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
                                    <td colspan="7" class="text-center text-muted py-3">
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
