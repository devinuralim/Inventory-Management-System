@extends('layouts.admin')

@section('content')
    <style>
        .page-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: #0f172a;
        }

        .card-clean {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .table tbody tr:hover {
            background-color: #f1f5f9;
            transition: 0.2s;
        }

        .form-select-sm {
            border-radius: 8px;
            border-color: #cbd5e1;
        }
    </style>

    <div class="container pt-3 pb-5">
        {{-- Header --}}
        <div class="mb-4">
            <div class="page-title">Laporan Barang Rusak / Hilang</div>
            <p class="text-muted small">Kelola dan pantau status laporan kondisi barang</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Content --}}
        <div class="card-clean table-responsive">
            @if ($laporans->count())
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
                        @foreach ($laporans as $item)
                            <tr>
                                <td class="fw-bold">{{ $item->barang->nama_barang ?? 'Data dihapus' }}</td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border rounded-pill">
                                        {{ ucfirst($item->jenis_laporan) }}
                                    </span>
                                </td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        // Menentukan label, warna, dan ikon untuk setiap status
                                        $statusInfo = [
                                            'menunggu' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-warning text-dark border-warning'],
                                            'diproses' => ['label' => 'Sedang Diproses', 'class' => 'bg-info text-white border-info'],
                                            'selesai' => ['label' => 'Selesai', 'class' => 'bg-success text-white border-success'],
                                        ];

                                        $current = $statusInfo[$item->status] ?? ['label' => ucfirst($item->status), 'class' => 'bg-secondary text-white'];
                                    @endphp

                                    <span
                                        class="badge {{ $current['class'] }} border rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas fa-circle me-1" style="font-size: 0.6rem"></i>
                                        {{ $current['label'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.laporan.selesai', $item->id) }}" method="POST">
                                        @csrf
                                        <select
                                            name="status"
                                            onchange="this.form.submit()"
                                            class="form-select form-select-sm"
                                            style="width: auto; margin: 0 auto">
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
                                            <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>
                                                Selesai
                                            </option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-clipboard-list fa-3x mb-3 opacity-50"></i>
                    <p>Belum ada laporan barang yang masuk.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
