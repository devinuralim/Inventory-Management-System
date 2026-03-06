<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Riwayat Peminjaman</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 11px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }
            th,
            td {
                border: 1px solid #000;
                padding: 5px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .text-center {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h2 class="text-center">Riwayat Peminjaman Barang K2NET</h2>
        <p class="text-center">Periode: {{ date('d F Y') }}</p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayat as $key => $item)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $item->nama_peminjam }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td>{{ $item->tanggal_pinjam }}</td>
                        <td>{{ $item->tanggal_kembali }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
