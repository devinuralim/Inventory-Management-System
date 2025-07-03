@extends('layouts.user')

@section('content')
<div class="pt-4 pb-5 bg-light min-vh-100">
    <div class="container">

        <div class="text-center mb-4 animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark border-bottom border-primary border-3 d-inline-block pb-1">
                <i class="fas fa-cart-arrow-down me-2 text-black"></i>Peminjaman Barang
            </h2>
            <p class="text-muted mt-1">Isi formulir di bawah untuk meminjam barang kantor.</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger shadow-sm text-center w-75 mx-auto animate__animated animate__fadeIn">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="card shadow border-0 rounded-4 animate__animated animate__fadeInUp">
            <div class="card-body p-4">
                <form action="{{ route('user.peminjaman.store') }}" method="POST">
                    @csrf

                    <div id="barang-wrapper">
                        <div class="row g-3 align-items-end barang-group mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Barang</label>
                                <select name="nama_barang[]" class="form-select shadow-sm" required>
                                    <option value="" disabled selected>-- Pilih Barang --</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Jumlah</label>
                                <input type="number" name="jumlah[]" class="form-control shadow-sm" min="1" required>
                            </div>
                            <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-danger remove-barang d-none">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 text-end">
                        <button type="button" id="add-barang" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Barang
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control shadow-sm" required>
                    </div>

                    <input type="hidden" name="tanggal_kembali" value="0000-00-00">

                    <div class="text-end mt-4">
                        <button type="submit" class="btn text-white shadow-sm" style="background-color: #1d3557;">
                            <i class="fas fa-paper-plane me-1"></i> Pinjam Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- Tambahkan script --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const addBtn = document.getElementById('add-barang');
        const wrapper = document.getElementById('barang-wrapper');
        const maxFields = 5;

        addBtn.addEventListener('click', function () {
            const barangGroups = wrapper.querySelectorAll('.barang-group');
            if (barangGroups.length < maxFields) {
                const first = barangGroups[0];
                const clone = first.cloneNode(true);

                clone.querySelectorAll('input, select').forEach(el => {
                    el.value = '';
                });

                clone.querySelector('.remove-barang').classList.remove('d-none');
                wrapper.appendChild(clone);
            }
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.closest('.remove-barang')) {
                e.target.closest('.barang-group').remove();
            }
        });
    });
</script>
@endsection
