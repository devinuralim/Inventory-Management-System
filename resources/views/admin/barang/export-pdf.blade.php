<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f1f1f1;
        }
        h2, small {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Data Barang</h2>
    <small>PT. K2NET - Inventory Management System</small>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Stok</th>
                <th>Seri</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->jenis_barang }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>{{ $barang->seri }}</td>
                    <td>{{ $barang->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
