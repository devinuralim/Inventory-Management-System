<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
{
    $query = Peminjaman::where('created_at', '>=', Carbon::now()->subDays(30));

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

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH PEMINJAMAN (ADMIN)
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $barangs = Barang::all();
        $karyawans = Karyawan::all();

        return view('admin.peminjaman.create', compact('barangs', 'karyawans'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PEMINJAMAN BARU
    |--------------------------------------------------------------------------
    */
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

            if (!$barang) {
                return back()->with('error', 'Barang tidak ditemukan.');
            }

            if ($barang->stok < $request->jumlah) {
                return back()->with('error', 'Stok barang tidak mencukupi.');
            }

            // Kurangi stok
            $barang->stok -= $request->jumlah;
            $barang->save();

            // Simpan peminjaman
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

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditambahkan');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA (HANYA YANG SUDAH DIKEMBALIKAN)
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'dikembalikan') {
            return redirect()->route('admin.peminjaman.index')
                ->with('error', 'Data tidak dapat dihapus karena belum dikembalikan.');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 KONFIRMASI PENGEMBALIAN (INI YANG ISI TANGGAL KEMBALI)
    |--------------------------------------------------------------------------
    */
    public function konfirmasiPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return redirect()->route('admin.peminjaman.index')
                ->with('error', 'Status peminjaman tidak valid untuk dikonfirmasi');
        }

        DB::beginTransaction();

        try {

            // Tambah stok kembali
            $barang = Barang::where('nama_barang', $peminjaman->nama_barang)->first();
            if ($barang) {
                $barang->stok += $peminjaman->jumlah;
                $barang->save();
            }

            // 🔥 UPDATE STATUS & TANGGAL KEMBALI OTOMATIS
            $peminjaman->status = 'dikembalikan';
            $peminjaman->tanggal_kembali = Carbon::now(); 
            $peminjaman->save();

            DB::commit();

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Pengembalian barang telah dikonfirmasi');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.peminjaman.index')
                ->with('error', 'Terjadi kesalahan saat konfirmasi pengembalian.');
        }
    }
}