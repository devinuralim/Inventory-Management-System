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

    .no-print, .no-print-column {
        display: none !important;
    }
}

@media (max-width: 768px) {
    .input-group .form-control,
    .input-group .btn {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }

    .btn-icon {
        width: 38px;
        height: 38px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-body {
        padding: 1.5rem 1rem;
    }

    .table-responsive {
        font-size: 0.85rem;
    }
}
</style>

<div class="pt-4 pb-5 container">
    <div class="card shadow border-0 rounded-4 p-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <h2 class="fw-bold text-dark d-flex align-items-center mb-0">
                <i class="fas fa-clipboard-list me-2 text-black"></i> Daftar Peminjaman
            </h2>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                {{-- Form Cari --}}
                <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="shadow-sm" style="max-width: 260px; width: 100%;">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-start-pill" placeholder="Cari...">
                        <button class="btn btn-outline-primary rounded-end-circle btn-icon" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                {{-- Tombol Export --}}
                <button onclick="window.print()" class="btn btn-outline-secondary rounded-circle btn-icon no-print" title="Cetak">
                    <i class="fas fa-print"></i>
                </button>
                <a href="{{ route('admin.peminjaman.export.pdf') }}" class="btn btn-danger rounded-circle btn-icon no-print" title="Export PDF">
                    <i class="fas fa-file-pdf"></i>
                </a>
                <a href="{{ route('admin.peminjaman.export.csv') }}" class="btn btn-success rounded-circle btn-icon no-print" title="Export CSV">
                    <i class="fas fa-file-csv"></i>
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
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

        {{-- Tabel --}}
        <div id="print-section" class="table-responsive">
            <div class="text-center mb-4 d-none d-print-block">
                <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
                <h2 class="mb-0">Daftar Peminjaman Barang</h2>
                <small>PT. K2NET - Inventory Management System</small>
                <hr>
            </div>

            <table class="table table-hover align-middle table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th class="d-none no-print-column">Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Keterangan</th>
                        <th class="text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->nama_peminjam }}</td>
                            <td>{{ $peminjaman->nama_barang }}</td>
                            <td>{{ $peminjaman->jumlah }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td class="d-none no-print-column">{{ $peminjaman->tanggal_kembali }}</td>
                            <td class="text-center">
                                @if ($peminjaman->status == 'dipinjam')
                                    <span class="badge bg-danger">Dipinjam</span>
                                @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($peminjaman->bukti_pengembalian)
                                    <a href="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}" alt="Bukti" width="60" class="img-thumbnail">
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $peminjaman->keterangan ?? '-' }}</td>
                            <td class="text-center no-print">
                                @if($peminjaman->status == 'menunggu konfirmasi')
                                    <button type="button" class="btn btn-dark btn-sm rounded-pill" onclick="showConfirmModal('{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @elseif($peminjaman->status == 'dikembalikan')
                                    <form action="{{ route('admin.peminjaman.delete', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-pill">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-2x mb-2 text-secondary"></i><br>
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                <strong>Total Peminjaman:</strong> {{ $total }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi --}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel"><i class="fas fa-question-circle me-2"></i>Konfirmasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah kamu yakin ingin mengonfirmasi pengembalian barang ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
        <form id="confirmForm" method="POST">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn btn-primary rounded-pill">Ya, Konfirmasi</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    function showConfirmModal(route) {
        const form = document.getElementById('confirmForm');
        form.action = route;
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
    }
</script>
@endpush
