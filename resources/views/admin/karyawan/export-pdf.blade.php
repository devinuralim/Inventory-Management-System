<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Karyawan - PT. K2NET</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #2d3436;
        }
        .header { text-align: center; margin-bottom: 25px; }
        .logo { width: 80px; margin-bottom: 10px; }
        h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        small { color: #636e72; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #f1f2f6;
            font-weight: 700;
            padding: 10px 8px;
            border: 1px solid #dfe6e9;
            text-transform: uppercase;
            font-size: 11px;
        }
        td {
            border: 1px solid #dfe6e9;
            padding: 8px;
            font-size: 11px;
        }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('k2net.png') }}" class="logo" alt="Logo">
        <h2>Data Karyawan</h2>
        <small>PT. K2NET - Inventory Management System</small>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">ID Pegawai</th>
                <th width="30%">Nama Lengkap</th>
                <th width="20%">Tgl Bergabung</th>
                <th width="30%">Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $index => $karyawan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $karyawan->id_pegawai }}</td>
                    <td>{{ $karyawan->nama_lengkap }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d/m/Y') }}</td>
                    <td>{{ $karyawan->jabatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>