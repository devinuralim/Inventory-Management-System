<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\LaporanBarang;
use App\Models\Barang;
use PDF;

class LaporanController extends Controller
{
    // ================= HISTORY PEMINJAMAN =================
    public function history(Request $request)
    {
        $query = Peminjaman::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->barang) {
            $query->where('nama_barang', $request->barang);
        }

        if ($request->peminjam) {
            $query->where('nama_peminjam', $request->peminjam);
        }

        $data = $query->latest()->get();

        $barangList = Peminjaman::select('nama_barang')->distinct()->get();
        $peminjamList = Peminjaman::select('nama_peminjam')->distinct()->get();

        return view('admin.reporting.history', compact('data', 'barangList', 'peminjamList'));
    }

    // ================= CETAK PDF =================
    public function pdf(Request $request)
    {
        $query = Peminjaman::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->barang) {
            $query->where('nama_barang', 'like', '%' . $request->barang . '%');
        }

        if ($request->peminjam) {
            $query->where('nama_peminjam', 'like', '%' . $request->peminjam . '%');
        }

        $data = $query->latest()->get();

        $pdf = PDF::loadView('admin.reporting.pdf', compact('data'));
        return $pdf->download('history-peminjaman.pdf');
    }

    // ================= EXPORT CSV =================
    public function excel(Request $request)
    {
        $query = Peminjaman::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->barang) {
            $query->where('nama_barang', 'like', '%' . $request->barang . '%');
        }

        if ($request->peminjam) {
            $query->where('nama_peminjam', 'like', '%' . $request->peminjam . '%');
        }

        $data = $query->get();

        $filename = "history-peminjaman.csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Nama', 'Barang', 'Jumlah', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status']);

            foreach ($data as $item) {
                fputcsv($file, [
                    $item->nama_peminjam,
                    $item->nama_barang,
                    $item->jumlah,
                    $item->tanggal_pinjam,
                    $item->tanggal_kembali ?? '-',
                    $item->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ================= LAPORAN BULANAN =================
    public function bulanan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = Peminjaman::query();

        if ($bulan && $tahun) {
            $query->whereMonth('tanggal_pinjam', $bulan)
                  ->whereYear('tanggal_pinjam', $tahun);
        }

        $data = $query->get();

        return view('admin.reporting.bulanan', compact('data'));
    }

    // ================= VIEW LAPORAN RUSAK / HILANG (ADMIN) =================
    public function rusak()
    {
        $laporan = LaporanBarang::latest()->get();
        return view('admin.reporting.rusak', compact('laporan'));
    }

    // ================= VIEW LAPORAN USER =================
    public function laporanUser()
    {
        $laporan = LaporanBarang::where('user_id', auth()->id())
                    ->latest()
                    ->get();

        return view('user.laporan.rusak', compact('laporan'));
    }

    // ================= SIMPAN LAPORAN (USER) =================
    public function storeRusak(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jenis_laporan' => 'required',
            'tanggal_laporan' => 'required|date',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // simpan laporan
        LaporanBarang::create([
            'barang_id' => $barang->id,
            'nama_barang' => $barang->nama_barang,
            'jenis_laporan' => $request->jenis_laporan,
            'keterangan' => $request->keterangan,
            'tanggal_laporan' => $request->tanggal_laporan,
            'status' => 'menunggu',
            'user_id' => auth()->id(),
        ]);

        // kalau rusak -> stok berkurang 1
        if ($request->jenis_laporan == 'rusak') {
            if ($barang->jumlah > 0) {
                $barang->jumlah -= 1;
                $barang->save();
            }
        }

        return back()->with('success', 'Laporan berhasil dikirim');
    }

    // ================= UPDATE STATUS (ADMIN) =================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $laporan = LaporanBarang::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        // kalau selesai & jenis rusak -> stok barang tambah
        if ($request->status == 'selesai' && $laporan->jenis_laporan == 'rusak') {
            $barang = Barang::where('id', $laporan->barang_id)->first();

            if ($barang) {
                $barang->jumlah += 1;
                $barang->save();
            }
        }

        return back()->with('success', 'Status laporan diperbarui');
    }

public function index()
{
    // Karena tidak pakai user_id, kita ambil semua data laporan yang ada
    $laporan = LaporanBarang::latest()->get();

    // Pastikan nama view-nya benar (user/laporan/index.blade.php)
    return view('user.laporan.index', compact('laporan'));
}


    public function create()
    {
        $barang = Barang::all();

        return view('user.laporan.create', compact('barang'));
    }
}