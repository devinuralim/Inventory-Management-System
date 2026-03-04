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

    .btn-group-flex form,
    .btn-group-flex a,
    .btn-group-flex button {
        width: 100%;
    }
}
</style>

<div class="container pt-2 pb-4">

    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="page-title">Daftar Peminjaman</div>
            <small class="text-muted">Kelola data peminjaman dan pengembalian barang</small>
        </div>

        <div class="d-flex flex-wrap gap-2 btn-group-flex">

            <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="input-group" style="max-width: 260px;">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control rounded-start-pill"
                       placeholder="Cari...">
                <button class="btn btn-outline-secondary rounded-end-pill">
                    Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Table --}}
    <div id="print-section" class="card-clean table-responsive">

        <div class="text-center mb-4 d-none d-print-block">
            <h4 class="mb-0">Daftar Peminjaman Barang</h4>
            <small>PT. K2NET - Inventory Management System</small>
            <hr>
        </div>

        <table class="table table-hover align-middle table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Nama Peminjam</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Keterangan</th>
                    <th class="no-print">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjaman->nama_peminjam }}</td>
                        <td>{{ $peminjaman->nama_barang }}</td>
                        <td class="text-center">{{ $peminjaman->jumlah }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                        </td>

                        <td>
                            @if($peminjaman->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

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
                                    <img src="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}"
                                         width="60"
                                         class="img-thumbnail">
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>{{ $peminjaman->keterangan ?? '-' }}</td>

                        <td class="text-center no-print">
                            @if($peminjaman->status == 'menunggu konfirmasi')
                                <button type="button"
                                        class="btn btn-primary btn-sm rounded-pill"
                                        onclick="showConfirmModal('{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}')">
                                    Konfirmasi
                                </button>
                            @elseif($peminjaman->status == 'dikembalikan')
                                <form action="{{ route('admin.peminjaman.delete', $peminjaman->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus data ini?')"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm rounded-pill">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
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

{{-- Modal Konfirmasi --}}
<div class="modal fade" id="confirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Apakah kamu yakin ingin mengonfirmasi pengembalian barang ini?
      </div>
      <div class="modal-footer">
        <button type="button"
                class="btn btn-outline-secondary rounded-pill"
                data-bs-dismiss="modal">
            Batal
        </button>
        <form id="confirmForm" method="POST">
          @csrf
          @method('PATCH')
          <button type="submit"
                  class="btn btn-primary rounded-pill">
              Ya, Konfirmasi
          </button>
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
