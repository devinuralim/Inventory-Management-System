@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Riwayat Peminjaman</h3>

    <form action="{{ route('admin.riwayat.index') }}" method="GET" class="row g-3 mb-4 align-items-end bg-white p-3 rounded shadow-sm">
        <div class="col-md-2">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-select">
                <option value="">Semua Bulan</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Tahun</label>
            <select name="tahun" class="form-select">
                <option value="">Semua Tahun</option>
                @foreach(range(date('Y'), date('Y') - 5) as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.riwayat.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>

        <div class="col-md-4 d-flex gap-2 justify-content-end align-items-end ms-auto">
            <button type="button" onclick="window.print()" class="btn btn-warning text-white" title="Print">
                <i class="fas fa-print"></i>
            </button>
            <a href="{{ route('admin.riwayat.pdf', request()->all()) }}" class="btn btn-danger" title="Download PDF">
                <i class="fas fa-file-pdf"></i>
            </a>
            <a href="{{ route('admin.riwayat.csv', request()->all()) }}" class="btn btn-success" title="Download CSV">
                <i class="fas fa-file-csv"></i>
            </a>
        </div>
    </form>

    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-hover">
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
                @foreach ($riwayat as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama_peminjam }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->tanggal_pinjam }}</td>
                    <td>{{ $item->tanggal_kembali }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Styling tombol agar icon center dan ukuran sama */
    .btn-warning, .btn-danger, .btn-success {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    @media print {
        .sidebar, .toggle-btn, form, .btn, .nav, .sidebar-footer-fixed { display: none !important; }
        .main-content, .container-fluid { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .table { border: 1px solid #000; width: 100%; }
        h3 { text-align: center; }
    }
</style>
@endsection