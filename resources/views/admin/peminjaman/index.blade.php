@extends('layouts.admin')

@section('content')

<style>
    .page-title { font-weight: 700; font-size: 1.6rem; color: #0f172a; }
    
    .card-clean { 
        background: #ffffff; 
        padding: 1.5rem; 
        border-radius: 16px; 
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .table thead { background-color: #f8fafc; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .table tbody tr:hover { background-color: #f1f5f9; transition: 0.2s; }

    .btn-primary { background-color: #3b82f6; border: none; padding: 0.5rem 1.2rem; }
    .btn-danger { background-color: #ef4444; border: none; }

    @media print {
        body * { visibility: hidden !important; }
        #print-section, #print-section * { visibility: visible !important; }
        #print-section { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>

<div class="container pt-3 pb-5">

    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="page-title">Daftar Peminjaman</div>
            <p class="text-muted small mb-0">Monitor status peminjaman dan verifikasi pengembalian barang</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div id="print-section" class="card-clean table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Barang</th>
                    <th class="text-center">Jumlah</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th class="text-center">Status</th>
                    <th>Bukti</th>
                    <th>Keterangan</th>
                    <th class="text-center no-print">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <td><span class="fw-bold">{{ $peminjaman->nama_peminjam }}</span></td>
                        <td>{{ $peminjaman->nama_barang }}</td>
                        <td class="text-center">{{ $peminjaman->jumlah }}</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td>
                            @if($peminjaman->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($peminjaman->status == 'dipinjam')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Dipinjam</span>
                            @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Menunggu</span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            @if ($peminjaman->bukti_pengembalian)
                                <a href="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}" width="40" class="rounded shadow-sm">
                                </a>
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $peminjaman->keterangan ?? '-' }}</td>
                        <td class="text-center no-print">
                            @if($peminjaman->status == 'menunggu konfirmasi')
                                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" 
                                    onclick="showConfirmModal('{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}')">
                                    <i class="fas fa-check me-1"></i> Konfirmasi
                                </button>
                            @elseif($peminjaman->status == 'dikembalikan')
                                <form action="{{ route('admin.peminjaman.delete', $peminjaman->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-5">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3 text-muted small">
            <strong>Total Peminjaman:</strong> {{ $total }}
        </div>
    </div>
</div>

{{-- Modal Konfirmasi --}}
<div class="modal fade" id="confirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title">Konfirmasi Pengembalian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Apakah Anda yakin barang ini sudah dikembalikan dengan benar?</div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
        <form id="confirmForm" method="POST">
          @csrf @method('PATCH')
          <button type="submit" class="btn btn-primary rounded-pill px-4">Ya, Konfirmasi</button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
    function showConfirmModal(route) {
        document.getElementById('confirmForm').action = route;
        new bootstrap.Modal(document.getElementById('confirmModal')).show();
    }
</script>
@endpush
@endsection