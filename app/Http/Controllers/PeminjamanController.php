<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::whereIn('status', ['dipinjam', 'menunggu konfirmasi']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_peminjam', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_barang', 'like', '%' . $request->search . '%');
            });
        }

        $peminjamans = $query->latest()->get();
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
            'nama_peminjam'  => 'required',
            'nama_barang'    => 'required',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'keterangan'     => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::where('nama_barang', $request->nama_barang)->first();
            if (!$barang) return back()->with('error', 'Barang tidak ditemukan.');
            if ($barang->stok < $request->jumlah) return back()->with('error', 'Stok barang tidak mencukupi.');

            $barang->stok -= $request->jumlah;
            $barang->save();

            Peminjaman::create([
                'nama_peminjam'   => $request->nama_peminjam,
                'nama_barang'     => $request->nama_barang,
                'jumlah'          => $request->jumlah,
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'tanggal_kembali' => null,
                'status'          => 'dipinjam',
                'keterangan'      => $request->keterangan,
            ]);

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status !== 'dikembalikan') {
            return redirect()->route('admin.peminjaman.index')->with('error', 'Data tidak dapat dihapus karena belum dikembalikan.');
        }
        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    }

    public function konfirmasiPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return redirect()->route('admin.peminjaman.index')->with('error', 'Status peminjaman tidak valid');
        }

        DB::beginTransaction();
        try {
            $barang = Barang::where('nama_barang', $peminjaman->nama_barang)->first();
            if ($barang) {
                $barang->stok += $peminjaman->jumlah;
                $barang->save();
            }
            $peminjaman->status = 'dikembalikan';
            $peminjaman->tanggal_kembali = Carbon::now();
            $peminjaman->save();

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian dikonfirmasi');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan.');
        }
    }

    public function riwayat(Request $request)
    {
        $query = Peminjaman::where('status', 'dikembalikan');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_kembali', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_kembali', $request->tahun);
        }

        $riwayat = $query->orderBy('tanggal_kembali', 'DESC')->get();
        return view('admin.riwayat.index', compact('riwayat'));
    }

    public function exportPDF(Request $request)
    {
        $query = Peminjaman::where('status', 'dikembalikan');

        if ($request->filled('bulan')) $query->whereMonth('tanggal_kembali', $request->bulan);
        if ($request->filled('tahun')) $query->whereYear('tanggal_kembali', $request->tahun);

        $riwayat = $query->orderBy('tanggal_kembali', 'DESC')->get();
        $pdf = Pdf::loadView('admin.riwayat.pdf', compact('riwayat'));
        return $pdf->download('Riwayat-Peminjaman-' . date('d-m-Y') . '.pdf');
    }

    public function exportCSV(Request $request)
    {
        $query = Peminjaman::where('status', 'dikembalikan');

        if ($request->filled('bulan')) $query->whereMonth('tanggal_kembali', $request->bulan);
        if ($request->filled('tahun')) $query->whereYear('tanggal_kembali', $request->tahun);

        $riwayat = $query->get();

        $filename = "Riwayat-Peminjaman-" . date('d-m-Y') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use($riwayat) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama Peminjam', 'Nama Barang', 'Jumlah', 'Tanggal Pinjam', 'Tanggal Kembali', 'Keterangan']);
            foreach ($riwayat as $key => $row) {
                fputcsv($file, [$key + 1, $row->nama_peminjam, $row->nama_barang, $row->jumlah, $row->tanggal_pinjam, $row->tanggal_kembali, $row->keterangan ?? '-']);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}