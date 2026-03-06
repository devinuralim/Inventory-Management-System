@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Laporan Barang Rusak / Hilang</h5>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($laporans->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Barang</th>
                                    <th>Kondisi</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporans as $item)
                                    <tr>
                                        <td>{{ $item->barang->nama_barang ?? 'Tidak ditemukan' }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($item->jenis_laporan) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $item->status == 'menunggu' ? 'bg-warning text-dark' : '' }} {{ $item->status == 'diproses' ? 'bg-info text-dark' : '' }} {{ $item->status == 'selesai' ? 'bg-success text-white' : '' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('admin.laporan.selesai', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                <select
                                                    name="status"
                                                    onchange="this.form.submit()"
                                                    class="form-select form-select-sm">
                                                    <option
                                                        value="menunggu"
                                                        {{ $item->status == 'menunggu' ? 'selected' : '' }}>
                                                        Menunggu
                                                    </option>
                                                    <option
                                                        value="diproses"
                                                        {{ $item->status == 'diproses' ? 'selected' : '' }}>
                                                        Diproses
                                                    </option>
                                                    <option
                                                        value="selesai"
                                                        {{ $item->status == 'selesai' ? 'selected' : '' }}>
                                                        Selesai
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">Belum ada laporan.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
