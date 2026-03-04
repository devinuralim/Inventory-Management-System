<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header small {
            font-size: 12px;
            color: #666;
        }

        .divider {
            border-top: 2px solid #000;
            margin: 10px 0 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #bbb;
            padding: 6px 8px;
        }

        td {
            font-size: 11px;
        }

        td:nth-child(1),
        td:nth-child(4) {
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>DATA BARANG</h2>
        <small>PT. K2NET - Inventory Management System</small>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama</th>
                <th width="15%">Jenis</th>
                <th width="10%">Stok</th>
                <th width="15%">Seri</th>
                <th width="35%">Keterangan</th>
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

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y') }}
    </div>
</body>
</html>
