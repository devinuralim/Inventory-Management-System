@extends('layouts.user')

@section('content')
<div class="py-10 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }} 👋</h1>
            <p class="text-sm text-gray-600 mt-1">Silakan pilih menu di bawah untuk mengakses fitur aplikasi.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Menu Barang -->
            <a href="{{ route('user.barang.index') }}" class="block bg-white hover:bg-blue-50 border border-blue-200 p-6 rounded-xl shadow transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full text-xl">📦</div>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-700">Daftar Barang</h3>
                        <p class="text-sm text-gray-600">Lihat barang yang tersedia dan detailnya.</p>
                    </div>
                </div>
            </a>

            <!-- Menu Karyawan -->
            <a href="{{ route('user.karyawan.index') }}" class="block bg-white hover:bg-green-50 border border-green-200 p-6 rounded-xl shadow transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full text-xl">🧑‍💼</div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-700">Daftar Karyawan</h3>
                        <p class="text-sm text-gray-600">Lihat siapa saja yang terdaftar sebagai karyawan.</p>
                    </div>
                </div>
            </a>

            <!-- Menu Peminjaman -->
            <a href="{{ route('user.peminjaman.index') }}" class="block bg-white hover:bg-yellow-50 border border-yellow-200 p-6 rounded-xl shadow transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full text-xl">📝</div>
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-700">Peminjaman Barang</h3>
                        <p class="text-sm text-gray-600">Ajukan atau cek riwayat peminjaman barang.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
