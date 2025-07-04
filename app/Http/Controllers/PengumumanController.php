<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumen = Pengumuman::latest()->paginate(10);
        return view('admin.pengumuman.index', compact('pengumumen'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string',
        ]);

        Pengumuman::create([
            'judul' => 'PENGUMUMAN !!!',
            'isi' => $request->isi,
            'tampilkan' => $request->has('tampilkan'),
        ]);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil dibuat');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'isi' => 'required|string',
        ]);

        $pengumuman->update([
            'judul' => 'PENGUMUMAN !!!',
            'isi' => $request->isi,
            'tampilkan' => $request->has('tampilkan'),
        ]);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil dihapus');
    }
}
