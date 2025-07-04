@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }

    .card-item {
        background: #ffffffcc;
        border-radius: 12px;
        padding: 15px 20px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        margin-bottom: 15px;
        transition: transform 0.2s;
        position: relative;
    }

    .card-item:hover {
        transform: translateY(-2px);
    }

    .item-icon {
        width: 50px;
        height: 50px;
        background: #1d3557;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
    }

    .item-header {
        display: flex;
        align-items: center;
    }

    .item-text {
        line-height: 1.4;
        overflow: hidden;
    }

    .item-text .title {
        font-weight: 600;
        font-size: 1rem;
        color: #1d3557;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-text .desc {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .item-text .note {
        font-size: 0.8rem;
        color: #888;
        margin-top: 4px;
    }

    .btn-fav {
        font-size: 22px;
        border: none;
        background: none;
        color: #fca311;
        position: absolute;
        top: 10px;
        right: 12px;
        z-index: 2;
    }

    .btn-fav-outline {
        color: #ccc;
    }

    .search-box {
        max-width: 500px;
        margin: 0 auto 1.5rem;
    }

    @media (max-width: 576px) {
        .item-header {
            flex-direction: row;
            align-items: flex-start;
        }

        .item-icon {
            width: 45px;
            height: 45px;
            font-size: 18px;
            margin-right: 12px;
        }

        .btn-fav {
            top: 8px;
            right: 10px;
            font-size: 20px;
        }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Tombol Kembali --}}
        <div class="mb-3">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary rounded-circle shadow-sm" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        {{-- Judul --}}
        <div class="mb-4 text-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-cube me-2 text-black"></i>Daftar Barang
            </h2>
            <p class="text-muted mt-2">Temukan dan pinjam barang yang kamu butuhkan.</p>
        </div>

        {{-- Form Pencarian --}}
        <form action="{{ route('user.barang.index') }}" method="GET" class="search-box">
            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari barang...">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- Daftar Barang --}}
        @if ($barangs->count() > 0)
            @foreach ($barangs as $barang)
                <div class="card-item animate__animated animate__fadeInUp">
                    {{-- Tombol Favorit --}}
                    <form action="{{ route('user.favorit.toggle', $barang->id) }}" method="POST">
                        @csrf
                        @php
                            $isFavorit = auth()->user()->favoritBarang->contains($barang->id);
                        @endphp
                        <button type="submit" class="btn-fav {{ $isFavorit ? '' : 'btn-fav-outline' }}">
                            {!! $isFavorit ? '&#9733;' : '&#9734;' !!}
                        </button>
                    </form>

                    {{-- Info Barang --}}
                    <div class="item-header">
                        <div class="item-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="item-text">
                            <div class="title">{{ $barang->nama_barang }}</div>
                            <div class="desc">{{ $barang->jenis_barang }} &bull; Stok: {{ $barang->stok }} &bull; Seri: {{ $barang->seri }}</div>
                            @if($barang->keterangan)
                                <div class="note">{{ $barang->keterangan }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center text-muted py-4">
                <i class="fas fa-box fa-2x mb-2 text-secondary"></i>
                <p class="mb-0">Tidak ada barang yang ditemukan.</p>
            </div>
        @endif

    </div>
</div>
@endsection
