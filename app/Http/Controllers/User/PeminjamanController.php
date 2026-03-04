<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::where('nama_peminjam', auth()->user()->name)
                            ->latest()
                            ->get();

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    public function riwayat(Request $request)
    {
        $query = Peminjaman::where('nama_peminjam', auth()->user()->name);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->waktu == '7') {
            $query->whereDate('created_at', '>=', now()->subDays(7));
        } elseif ($request->waktu == '30') {
            $query->whereDate('created_at', '>=', now()->subDays(30));
        }

        $peminjamans = $query->orderByRaw("FIELD(status, 'dipinjam', 'menunggu konfirmasi', 'dikembalikan')")
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('user.peminjaman.riwayat', compact('peminjamans'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('user.peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string|distinct',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        foreach ($request->nama_barang as $index => $namaBarang) {

            $barang = Barang::where('nama_barang', $namaBarang)->first();

            if (!$barang || $barang->stok < $request->jumlah[$index]) {
                return back()->with('error', 'Stok tidak cukup untuk barang: ' . $namaBarang);
            }

            // Kurangi stok saat dipinjam
            $barang->stok -= $request->jumlah[$index];
            $barang->save();

            Peminjaman::create([
                'nama_peminjam'   => auth()->user()->name,
                'nama_barang'     => $namaBarang,
                'jumlah'          => $request->jumlah[$index],
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'tanggal_kembali' => null,
                'status'          => 'dipinjam',
            ]);
        }

        return redirect()->route('user.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    // Redirect ke form upload bukti
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
                        ->where('nama_peminjam', auth()->user()->name)
                        ->firstOrFail();

        if ($peminjaman->status === 'dipinjam') {
            return redirect()->route('user.peminjaman.bukti', $id);
        }

        return redirect()->route('user.peminjaman.index')
            ->with('error', 'Barang tidak dapat dikembalikan.');
    }

    public function formBukti($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
                        ->where('nama_peminjam', auth()->user()->name)
                        ->firstOrFail();

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->route('user.peminjaman.index')
                ->with('error', 'Pengembalian tidak bisa diajukan.');
        }

        return view('user.peminjaman.upload_bukti', compact('peminjaman'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pengembalian' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required|string|max:500',
        ]);

        $peminjaman = Peminjaman::where('id', $id)
                        ->where('nama_peminjam', auth()->user()->name)
                        ->firstOrFail();

        $path = $request->file('bukti_pengembalian')
                        ->store('bukti_pengembalian', 'public');

        $peminjaman->bukti_pengembalian = $path;
        $peminjaman->keterangan = $request->keterangan;
        $peminjaman->status = 'menunggu konfirmasi';
        $peminjaman->save();

        return redirect()->route('user.peminjaman.index')
            ->with('success', 'Bukti pengembalian berhasil diupload! Menunggu konfirmasi admin.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (in_array($peminjaman->status, ['dipinjam', 'menunggu konfirmasi'])) {
            return redirect()->route('user.peminjaman.index')
                ->with('error', 'Peminjaman tidak dapat dihapus karena masih berlangsung.');
        }

        $peminjaman->delete();

        return redirect()->route('user.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function detail($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
                        ->where('nama_peminjam', auth()->user()->name)
                        ->firstOrFail();

        return view('user.peminjaman.detail', compact('peminjaman'));
    }
}