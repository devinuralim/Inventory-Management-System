@extends('layouts.user')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary-blue: #1d3557;
        --highlight: #fca311;
        --bg-light: #f8fafc;
    }

    .judul-section {
        border-bottom: 3px solid var(--highlight);
        display: inline-block;
        padding-bottom: 6px;
        color: var(--primary-blue);
        font-weight: 700;
        text-transform: uppercase;
    }

    .form-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-blue);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        background-color: #fcfdfe;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(29, 53, 87, 0.1);
        background-color: white;
    }

    .btn-kirim {
        background-color: var(--primary-blue);
        color: white;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 700;
        border: none;
        width: 100%;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-kirim:hover {
        background-color: #2a4a75;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(29, 53, 87, 0.2);
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background-color: var(--bg-light);">
    <div class="container">
        
        <div class="mb-4">
            <a href="{{ route('user.laporan.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-1"></i>
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                
                <div class="mb-4 animate__animated animate__fadeIn">
                    <h2 class="judul-section">Buat Laporan Barang</h2>
                    <p class="text-muted small mt-2">Laporkan kendala, kerusakan, atau kehilangan barang inventaris.</p>
                </div>

                <div class="form-container animate__animated animate__fadeInUp">
                    <form action="{{ route('user.laporan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input
                                list="barangList"
                                name="nama_barang"
                                class="form-control"
                                required
                                placeholder="Ketik nama barang yang ingin dilaporkan..." />

                            <datalist id="barangList">
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->nama_barang }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" placeholder="0" required min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kondisi Barang</label>
                                <select name="jenis_laporan" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Kondisi --</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Deskripsi Kejadian</label>
                            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ceritakan detail kondisi atau kronologi kejadian..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-kirim">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                        </button>
                    </form>
                </div>

                <div class="mt-4 text-center animate__animated animate__fadeIn">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i> Laporan akan segera diproses oleh admin.
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection