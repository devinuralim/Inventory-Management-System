<!DOCTYPE html>
<html>
<head>
    <title>History Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: center; }
    </style>
</head>
<body>

<h3 style="text-align: center;">History Peminjaman Barang</h3>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $item->nama_peminjam }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
            <td>
                {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}
            </td>
            <td>{{ ucfirst($item->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>