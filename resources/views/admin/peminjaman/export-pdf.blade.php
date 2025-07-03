<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Peminjaman Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        small {
            text-align: center;
            display: block;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        .footer {
            margin-top: 30px;
            font-size: 11px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>Data Peminjaman Barang</h2>
    <small>PT. K2NET - Inventory Management System</small>

    <table>
        <thead>
            <tr>
                <th>Nama Peminjam</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $peminjaman->nama_peminjam }}</td>
                    <td>{{ $peminjaman->nama_barang }}</td>
                    <td>{{ $peminjaman->jumlah }}</td>
                    <td>{{ $peminjaman->tanggal_pinjam }}</td>
                    <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
                    <td>{{ ucfirst($peminjaman->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
    </div>
</body>
</html>
