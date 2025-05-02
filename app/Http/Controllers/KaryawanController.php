<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    // Tampilkan daftar karyawan
    public function index()
    {
        $karyawans = Karyawan::all(); // Ambil semua data karyawan
        return view('admin.karyawan.index', compact('karyawans'));
    }

    // Form tambah karyawan
    public function create()
    {
        return view('admin.karyawan.create');
    }

    // Simpan karyawan baru
    public function save(Request $request)
    {
        $request->validate([
                    'id_pegawai' => 'required|unique:karyawans,id_pegawai',
                    'nama_lengkap' => 'required',
                    'tanggal_bergabung' => 'required|date',
                    'jabatan' => 'required',
                     ]);

        Karyawan::create($request->all()); // Simpan data karyawan

        return redirect()->route('admin.karyawans.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    // Form edit karyawan
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    // Update data karyawan
    public function update(Request $request, $id)
    {
        $request->validate([
        'id_pegawai' => 'required|unique:karyawans,id_pegawai',
        'nama_lengkap' => 'required',
        'tanggal_bergabung' => 'required|date',
        'jabatan' => 'required',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->all()); // Update data karyawan

        return redirect()->route('admin.karyawans.index')->with('success', 'Karyawan berhasil diperbarui');
    }

    // Hapus data karyawan
    public function delete($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete(); // Hapus data karyawan

        return redirect()->route('admin.karyawans.index')->with('success', 'Karyawan berhasil dihapus');
    }
}
