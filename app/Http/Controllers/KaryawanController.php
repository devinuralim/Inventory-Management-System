<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all(); 
        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function save(Request $request)
    {
        $request->validate([
                    'id_pegawai' => 'required|unique:karyawans,id_pegawai',
                    'nama_lengkap' => 'required',
                    'tanggal_bergabung' => 'required|date',
                    'jabatan' => 'required',
                     ]);

        Karyawan::create($request->all()); 

        return redirect()->route('admin.karyawans.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function edit($id_pegawai)
    {
        $karyawan = Karyawan::where('id_pegawai', $id_pegawai)->firstOrFail();
        return view('admin.karyawan.edit', compact('karyawan'));
    }
    
    public function update(Request $request, $id_pegawai)
    {
        $request->validate([
            'id_pegawai' => 'required|unique:karyawans,id_pegawai,' . $id_pegawai . ',id_pegawai',
            'nama_lengkap' => 'required',
            'tanggal_bergabung' => 'required|date',
            'jabatan' => 'required',
        ]);
    
        $karyawan = Karyawan::where('id_pegawai', $id_pegawai)->firstOrFail();
        $karyawan->update($request->all());
    
        return redirect()->route('admin.karyawans.index')->with('success', 'Karyawan berhasil diperbarui');
    }
    
    public function delete($id_pegawai)
    {
        $karyawan = Karyawan::where('id_pegawai', $id_pegawai)->firstOrFail();
        $karyawan->delete();
    
        return redirect()->route('admin.karyawans.index')->with('success', 'Karyawan berhasil dihapus');
    }
}