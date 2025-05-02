<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full mt-6 table-auto border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">ID Pegawai</th>
                                <th class="border px-4 py-2">Nama Lengkap</th>
                                <th class="border px-4 py-2">Tanggal Bergabung</th>
                                <th class="border px-4 py-2">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans as $index => $karyawan)
                                <tr>
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td> <!-- No -->
                                    <td class="border px-4 py-2">{{ $karyawan->id_pegawai }}</td> <!-- ID Pegawai -->
                                    <td class="border px-4 py-2">{{ $karyawan->nama_lengkap }}</td>
                                    <td class="border px-4 py-2">{{ $karyawan->created_at->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2">{{ $karyawan->jabatan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
