<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Riwayat Peminjaman</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $p)
                <tr>
                    <td>{{ $p->nama_barang }}</td>
                    <td>{{ $p->jumlah }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
