<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Karyawan - PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2, small {
            text-align: center;
        }
        .logo {
            width: 80px;
            display: block;
            margin: 0 auto 10px auto;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('k2net.png') }}" class="logo" alt="Logo">
    <h2>Data Karyawan</h2>
    <small>PT. K2NET - Inventory Management System</small>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pegawai</th>
                <th>Nama Lengkap</th>
                <th>Tanggal Bergabung</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $index => $karyawan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $karyawan->id_pegawai }}</td>
                    <td>{{ $karyawan->nama_lengkap }}</td>
                    <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d-m-Y') }}</td>
                    <td>{{ $karyawan->jabatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
