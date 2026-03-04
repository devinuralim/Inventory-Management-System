@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-3">History Peminjaman</h4>

    <!-- FILTER -->
<form method="GET" action="{{ url()->current() }}" class="mb-3">
    <div class="row g-2">

        <!-- STATUS -->
        <div class="col-md-3">
            <label>Status</label>
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">-- Semua Status --</option>
                <option value="dipinjam" {{ request('status')=='dipinjam'?'selected':'' }}>Dipinjam</option>
                <option value="dikembalikan" {{ request('status')=='dikembalikan'?'selected':'' }}>Dikembalikan</option>
                <option value="menunggu konfirmasi" {{ request('status')=='menunggu konfirmasi'?'selected':'' }}>Menunggu</option>
            </select>
        </div>

        <!-- BARANG -->
        <div class="col-md-3">
            <label>Barang</label>
            <select name="barang" class="form-control" onchange="this.form.submit()">
                <option value="">-- Semua Barang --</option>
                @foreach($barangList as $b)
                    <option value="{{ $b->nama_barang }}" {{ request('barang')==$b->nama_barang?'selected':'' }}>
                        {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- PEMINJAM -->
        <div class="col-md-3">
            <label>Peminjam</label>
            <select name="peminjam" class="form-control" onchange="this.form.submit()">
                <option value="">-- Semua Peminjam --</option>
                @foreach($peminjamList as $p)
                    <option value="{{ $p->nama_peminjam }}" {{ request('peminjam')==$p->nama_peminjam?'selected':'' }}>
                        {{ $p->nama_peminjam }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>
</form>

    <!-- BUTTON CETAK / PDF / CSV -->
    <div class="mb-3">
        <button onclick="window.print()" class="btn btn-secondary">
            Cetak
        </button>

        <a href="{{ route('report.history.pdf', request()->all()) }}" class="btn btn-danger">
            PDF
        </a>

        <a href="{{ route('report.history.excel', request()->all()) }}" class="btn btn-success">
            CSV
        </a>
    </div>

    <!-- TABEL HISTORY -->
    <table class="table table-bordered table-hover">
        <thead class="text-center">
            <tr>
                <th>Nama</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr>
                <td>{{ $item->nama_peminjam }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td class="text-center">{{ $item->jumlah }}</td>

                <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>

                <td>
                    @if($item->tanggal_kembali)
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>

                <td class="text-center">
                    @if ($item->status == 'dipinjam')
                        <span class="badge bg-danger">Dipinjam</span>
                    @elseif ($item->status == 'menunggu konfirmasi')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @else
                        <span class="badge bg-success">Dikembalikan</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Tidak ada data history peminjaman.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- STYLE PRINT BIAR YANG KEPRINT CUMA TABEL -->
<style>
@media print {
    body * {
        visibility: hidden;
    }

    table, table * {
        visibility: visible;
    }

    table {
        position: absolute;
        top: 0;
        left: 0;
    }
}
</style>

@endsection