@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }
    .card-glass {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease-in-out;
    }
    .card-glass:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Judul --}}
        <div class="mb-4 text-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-star me-2 text-warning"></i>Barang Favorit
            </h2>
            <p class="text-muted mt-2">Berikut adalah daftar barang yang kamu tandai sebagai favorit.</p>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success text-center w-75 mx-auto animate__animated animate__fadeIn">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabel Favorit --}}
        <div class="card card-glass border-0 rounded-4 animate__animated animate__fadeInUp">
            <div class="card-body">
                @if($favoritBarangs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead style="background-color: #f1f1f1;">
                                <tr class="text-dark fw-semibold">
                                    <th>Nama Barang</th>
                                    <th>Jenis</th>
                                    <th>Stok</th>
                                    <th>Seri</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($favoritBarangs as $barang)
                                <tr>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->jenis_barang }}</td>
                                    <td>{{ $barang->stok }}</td>
                                    <td>{{ $barang->seri }}</td>
                                    <td>{{ $barang->keterangan }}</td>
                                    <td>
                                        <form action="{{ route('user.favorit.toggle', $barang->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                &#9733; Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-star fa-2x mb-2 text-secondary"></i><br>
                        Belum ada barang yang kamu tandai sebagai favorit.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
