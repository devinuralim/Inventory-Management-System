@extends('layouts.admin')

@section('content')
<style>
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
                <i class="fas fa-bullhorn me-2 text-dark"></i> Daftar Pengumuman
            </h2>
            <div>
                <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-success rounded-pill">
                    <i class="fas fa-plus me-1"></i> Tambah Pengumuman
                </a>
            </div>
        </div>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Tabel Pengumuman --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
                <thead class="table-light text-center">
                    <tr>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengumumen as $pengumuman)
                        <tr>
                            <td>{{ $pengumuman->judul }}</td>
                            <td class="text-center">
                                @if($pengumuman->tampilkan)
                                    <span class="badge bg-success">Ditampilkan</span>
                                @else
                                    <span class="badge bg-secondary">Disembunyikan</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $pengumuman->created_at->translatedFormat('d F Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-warning btn-sm rounded-pill me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengumuman ini?')">
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
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-bullhorn-slash fa-2x mb-2 text-secondary"></i><br>
                                Belum ada pengumuman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $pengumumen->links() }}
        </div>
    </div>
</div>
@endsection
