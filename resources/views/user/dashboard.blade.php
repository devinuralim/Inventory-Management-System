<!-- resources/views/user/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
                            <h3 class="font-semibold text-lg">Daftar Barang</h3>
                            <p class="mt-4">Lihat daftar barang yang tersedia untuk dipinjam.</p>
                            <a href="{{ route('user.barang.index') }}" class="block mt-4 text-white font-bold text-center">Lihat Barang</a>
                        </div>

                        <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
                            <h3 class="font-semibold text-lg">Daftar Karyawan</h3>
                            <p class="mt-4">Lihat daftar karyawan yang terdaftar di sistem.</p>
                            <a href="{{ route('user.karyawan.index') }}" class="block mt-4 text-white font-bold text-center">Lihat Karyawan</a>
                        </div>

                        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
                            <h3 class="font-semibold text-lg">Peminjaman Barang</h3>
                            <p class="mt-4">Lihat daftar peminjaman dan ajukan peminjaman barang baru.</p>
                            <a href="{{ route('user.peminjaman.index') }}" class="block mt-4 text-white font-bold text-center">Lihat & Pinjam Barang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
