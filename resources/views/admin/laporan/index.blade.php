@extends('layouts.admin')

@section('content')
<style>
    .page-title { font-weight: 700; font-size: 1.6rem; color: #0f172a; }
    .card-clean { background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .table thead { background-color: #f8fafc; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .table tbody tr:hover { background-color: #f1f5f9; transition: 0.2s; }
    .form-select-sm { border-radius: 8px; border-color: #cbd5e1; }
</style>

<div class="container pt-3 pb-5">
    {{-- Header --}}
    <div class="mb-4">
        <div class="page-title">Laporan Barang Rusak / Hilang</div>
        <p class="text-muted small mb-0">Kelola dan pantau status laporan kondisi barang</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Form Filter --}}
    <div class="card-clean mb-4">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="small text-muted">Bulan</label>
                <select name="bulan" class="form-select form-select-sm">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="small text-muted">Tahun</label>
                <select name="tahun" class="form-select form-select-sm">
                    <option value="">Semua Tahun</option>
                    @foreach(range(date('Y'), date('Y') - 5) as $y)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary px-3">Filter</button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-secondary px-3">Reset</a>
            </div>
        </form>
    </div>

    {{-- Content Table --}}
    <div class="card-clean table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Kondisi</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th class="text-center">Update Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->barang->nama_barang ?? 'Data dihapus' }}</td>
                        <td>
                            <span class="badge bg-light text-secondary border rounded-pill">
                                {{ ucfirst($item->jenis_laporan) }}
                            </span>
                        </td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $statusInfo = [
                                    'menunggu' => ['label' => 'Menunggu', 'class' => 'bg-warning text-dark border-0'],
                                    'diproses' => ['label' => 'Diproses', 'class' => 'bg-info text-white border-0'],
                                    'selesai' => ['label' => 'Selesai', 'class' => 'bg-success text-white border-0'],
                                ];
                                $current = $statusInfo[$item->status] ?? ['label' => ucfirst($item->status), 'class' => 'bg-secondary text-white'];
                            @endphp
                            <span class="badge {{ $current['class'] }} rounded-pill px-3 py-1">
                                {{ $current['label'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.laporan.selesai', $item->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm w-auto mx-auto">
                                    <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-list fa-2x mb-3 d-block opacity-50"></i>
                            Tidak ada laporan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection