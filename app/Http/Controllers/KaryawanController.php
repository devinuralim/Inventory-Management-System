<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    // Tampilkan semua karyawan (dari tabel karyawans)
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('admin.karyawan.index', compact('karyawans'));
    }

    // Form tambah akun + data karyawan
    public function create()
    {
        return view('admin.karyawan.create');
    }

    // Simpan ke tabel users dan karyawans
    public function save(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|unique:users,id_pegawai|unique:karyawans,id_pegawai',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'tanggal_bergabung' => 'required|date',
            'jabatan' => 'required|string|max:255',
        ]);

        // Simpan ke tabel users
        User::create([
            'id_pegawai' => $request->id_pegawai,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
        ]);

        // Simpan ke tabel karyawans
        Karyawan::create([
            'id_pegawai' => $request->id_pegawai,
            'nama_lengkap' => $request->name,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('admin.karyawans.index')
                         ->with('success', 'Akun karyawan berhasil dibuat!');
    }

    // Form edit data karyawan
    public function edit($id_pegawai)
    {
        $karyawan = Karyawan::where('id_pegawai', $id_pegawai)->firstOrFail();
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    // Update data di karyawans + optional update nama di users
    public function update(Request $request, $id_pegawai)
    {
        $karyawan = Karyawan::where('id_pegawai', $id_pegawai)->firstOrFail();
        $user = User::where('id_pegawai', $id_pegawai)->first();

        $request->validate([
            'id_pegawai' => 'required|unique:karyawans,id_pegawai,' . $karyawan->id,
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_bergabung' => 'required|date',
            'jabatan' => 'required|string|max:255',
        ]);

        $karyawan->update([
            'id_pegawai' => $request->id_pegawai,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'jabatan' => $request->jabatan,
        ]);

        if ($user) {
            $user->update([
                'id_pegawai' => $request->id_pegawai,
                'name' => $request->nama_lengkap,
            ]);
        }

        return redirect()->route('admin.karyawans.index')
                         ->with('success', 'Data karyawan berhasil diperbarui');
    }

    // Hapus dari karyawans dan users
    public function delete($id_pegawai)
    {
        $karyawan = Karyawan::where('id_pegawai', $id_pegawai)->first();
        $user = User::where('id_pegawai', $id_pegawai)->first();

        if ($karyawan) {
            $karyawan->delete();
        }

        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.karyawans.index')
                         ->with('success', 'Data karyawan berhasil dihapus');
    }
}
