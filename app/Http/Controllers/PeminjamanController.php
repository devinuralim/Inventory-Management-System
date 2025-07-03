<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Karyawan;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $peminjamans = Peminjaman::query();

        if ($search) {
            $peminjamans->where('nama_peminjam', 'like', "%$search%")
                        ->orWhere('nama_barang', 'like', "%$search%");
        }

        $peminjamans = $peminjamans->orderBy('id', 'desc')->get();
        $total = $peminjamans->count();

        return view('admin.peminjaman.index', compact('peminjamans', 'total'));
    }

    public function create()
    {
        $barangs = Barang::all(); 
        $karyawans = Karyawan::all();
        return view('admin.peminjaman.create', compact('barangs', 'karyawans'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
        ]);

        $data = Peminjaman::create([
            'nama_peminjam' => $request->nama_peminjam,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali ?: null,
            'status' => 'dipinjam', 
        ]);

        if ($data) {
            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
        } else {
            return redirect()->route('admin.peminjaman.create')->with('error', 'Terjadi masalah saat menambahkan peminjaman');
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->delete()) {
            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
        } else {
            return redirect()->route('admin.peminjaman.index')->with('error', 'Peminjaman gagal dihapus');
        }
    }

    public function konfirmasiPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return redirect()->route('admin.peminjaman.index')->with('error', 'Status peminjaman tidak valid untuk dikonfirmasi');
        }

        $peminjaman->status = 'dikembalikan';

        if ($peminjaman->save()) {
            $barang = Barang::where('nama_barang', $peminjaman->nama_barang)->first();
            if ($barang) {
                $barang->stok += $peminjaman->jumlah;
                $barang->save();
            }

            return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian barang telah dikonfirmasi');
        } else {
            return redirect()->route('admin.peminjaman.index')->with('error', 'Gagal mengonfirmasi pengembalian barang');
        }
    }

    public function exportPdf()
    {
        $peminjamans = Peminjaman::all();
        $total = $peminjamans->count();

        $pdf = Pdf::loadView('admin.peminjaman.export-pdf', compact('peminjamans', 'total'));
        return $pdf->download('data-peminjaman.pdf');
    }

    public function exportExcel()
    {
        $fileName = 'data-peminjaman.csv';
        $peminjamans = Peminjaman::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($peminjamans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Peminjam', 'Nama Barang', 'Jumlah', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status']);

            foreach ($peminjamans as $p) {
                fputcsv($file, [
                    $p->nama_peminjam,
                    $p->nama_barang,
                    $p->jumlah,
                    $p->tanggal_pinjam,
                    $p->tanggal_kembali,
                    $p->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
