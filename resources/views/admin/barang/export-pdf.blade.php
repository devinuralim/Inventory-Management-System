<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Barang - PT. K2NET</title>

    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #2d3436;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .header p {
            margin: 0;
            font-size: 11px;
            color: #636e72;
            text-transform: uppercase;
        }

        .divider {
            border-top: 2px solid #2d3436;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f1f2f6;
            font-weight: 700;
            text-align: left;
            padding: 10px 8px;
            border: 1px solid #dfe6e9;
            font-size: 11px;
            text-transform: uppercase;
        }

        td {
            border: 1px solid #dfe6e9;
            padding: 8px;
            font-size: 11px;
            vertical-align: top;
        }

        /* Perataan khusus */
        .text-center { text-align: center; }
        
        tr:nth-child(even) { background-color: #f9f9f9; }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            color: #b2bec3;
            border-top: 1px solid #dfe6e9;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN DATA BARANG</h2>
        <p>PT. K2NET - Inventory Management System</p>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="20%">Nama Barang</th>
                <th width="15%">Jenis</th>
                <th class="text-center" width="8%">Stok</th>
                <th width="15%">Seri/Model</th>
                <th width="37%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $index => $barang)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->jenis_barang }}</td>
                    <td class="text-center">{{ $barang->stok }}</td>
                    <td>{{ $barang->seri }}</td>
                    <td>{{ $barang->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh sistem pada: {{ date('d/m/Y H:i') }} WIB
    </div>

</body>
</html>