<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan Peminjaman AKTIF (Hanya yang sedang dipinjam/proses)
     */
    public function index()
    {
        $peminjamans = Peminjaman::where('nama_peminjam', Auth::user()->name)
                            ->whereIn('status', ['dipinjam', 'menunggu konfirmasi'])
                            ->latest()
                            ->get();

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    /**
     * --- INI FUNGSI YANG TADI HILANG ---
     * Menampilkan Form Tambah Peminjaman
     */
    public function create()
    {
        // Ambil data barang yang stoknya ada (stok > 0)
        $barangs = Barang::where('stok', '>', 0)->orderBy('nama_barang', 'asc')->get();
        
        return view('user.peminjaman.create', compact('barangs'));
    }

    /**
     * Menampilkan RIWAYAT berdasarkan Filter WAKTU saja
     */
    public function riwayat(Request $request)
    {
        $query = Peminjaman::where('nama_peminjam', Auth::user()->name);

        if ($request->filled('waktu')) {
            $hari = (int)$request->waktu;
            $query->whereDate('created_at', '>=', Carbon::now()->subDays($hari));
        }

        $peminjamans = $query->latest()->get();

        return view('user.peminjaman.riwayat', compact('peminjamans'));
    }

    /**
     * Proses Simpan Peminjaman Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        foreach ($request->nama_barang as $index => $namaBarang) {
            $barang = Barang::where('nama_barang', $namaBarang)->first();

            if (!$barang || $barang->stok < $request->jumlah[$index]) {
                return back()->with('error', 'Stok tidak cukup untuk: ' . $namaBarang);
            }

            // Kurangi stok barang
            $barang->decrement('stok', $request->jumlah[$index]);

            Peminjaman::create([
                'nama_peminjam'   => Auth::user()->name,
                'nama_barang'     => $namaBarang,
                'jumlah'          => $request->jumlah[$index],
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'status'          => 'dipinjam',
            ]);
        }

        return redirect()->route('user.peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
    }

    /**
     * Form Upload Bukti Pengembalian
     */
    public function formBukti($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
                        ->where('nama_peminjam', Auth::user()->name)
                        ->firstOrFail();

        return view('user.peminjaman.upload_bukti', compact('peminjaman'));
    }

    /**
     * Proses Upload Bukti
     */
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pengembalian' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required|string|max:500',
        ]);

        $peminjaman = Peminjaman::where('id', $id)
                        ->where('nama_peminjam', Auth::user()->name)
                        ->firstOrFail();

        $path = $request->file('bukti_pengembalian')->store('bukti_pengembalian', 'public');

        $peminjaman->update([
            'bukti_pengembalian' => $path,
            'keterangan' => $request->keterangan,
            'status' => 'menunggu konfirmasi'
        ]);

        return redirect()->route('user.peminjaman.index')->with('success', 'Bukti berhasil diupload!');
    }

    /**
     * Hapus Riwayat (Hanya yang sudah selesai)
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
                        ->where('nama_peminjam', Auth::user()->name)
                        ->firstOrFail();

        if ($peminjaman->status !== 'dikembalikan') {
            return redirect()->back()->with('error', 'Peminjaman aktif tidak bisa dihapus.');
        }

        $peminjaman->delete();
        return redirect()->back()->with('success', 'Riwayat berhasil dihapus.');
    }

    public function detail($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
                        ->where('nama_peminjam', Auth::user()->name)
                        ->firstOrFail();

        return view('user.peminjaman.detail', compact('peminjaman'));
    }
}