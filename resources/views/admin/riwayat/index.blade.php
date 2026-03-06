@extends('layouts.admin')

@section('content')
<style>
    .page-title { font-weight: 700; font-size: 1.6rem; color: #0f172a; }
    .card-clean { background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .table thead { background-color: #f8fafc; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .table tbody tr:hover { background-color: #f1f5f9; transition: 0.2s; }
    
    @media print {
        .no-print { display: none !important; }
    }
</style>

<div class="container pt-3 pb-5">
    {{-- Header --}}
    <div class="mb-4">
        <div class="page-title">Riwayat Peminjaman</div>
        <p class="text-muted small mb-0">Pantau seluruh riwayat transaksi peminjaman barang</p>
    </div>

    {{-- Filter & Action Bar --}}
    <div class="card-clean mb-4 no-print">
        <form action="{{ route('admin.riwayat.index') }}" method="GET" class="row g-2 align-items-end">
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
                <a href="{{ route('admin.riwayat.index') }}" class="btn btn-sm btn-secondary px-3">Reset</a>
            </div>
            
            <div class="col-auto ms-auto">
                <button type="button" onclick="window.print()" class="btn btn-sm btn-outline-dark rounded-pill px-3" title="Print">
                    <i class="fas fa-print"></i>
                </button>
                <a href="{{ route('admin.riwayat.pdf', request()->all()) }}" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="PDF">
                    <i class="fas fa-file-pdf"></i>
                </a>
                <a href="{{ route('admin.riwayat.csv', request()->all()) }}" class="btn btn-sm btn-outline-success rounded-pill px-3" title="CSV">
                    <i class="fas fa-file-csv"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card-clean table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Barang</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayat as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="fw-bold">{{ $item->nama_peminjam }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">Tidak ada riwayat ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection