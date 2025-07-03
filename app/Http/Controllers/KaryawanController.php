<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $karyawans = Karyawan::query();

        if ($search) {
            $karyawans->where('id_pegawai', 'like', "%$search%")
                      ->orWhere('nama_lengkap', 'like', "%$search%")
                      ->orWhere('jabatan', 'like', "%$search%");
        }

        $karyawans = $karyawans->get()->map(function ($karyawan) {
            $user = User::where('id_pegawai', $karyawan->id_pegawai)->first();
            $karyawan->password_plain = $user?->password_plain ?? null;
            return $karyawan;
        });

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function save(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|unique:users,id_pegawai|unique:karyawans,id_pegawai',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'tanggal_bergabung' => 'required|date',
            'jabatan' => 'required|string|max:255',
        ]);

        User::create([
            'id_pegawai' => $request->id_pegawai,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'role' => 'karyawan',
        ]);

        Karyawan::create([
            'id_pegawai' => $request->id_pegawai,
            'nama_lengkap' => $request->name,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('admin.karyawans.index')
                         ->with('success', 'Akun karyawan berhasil dibuat!');
    }

    public function edit($id_pegawai)
    {
        $karyawan = Karyawan::where('id_pegawai', $id_pegawai)->firstOrFail();
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id_pegawai)
    {
        $karyawan = Karyawan::where('id_pegawai', $id_pegawai)->firstOrFail();
        $user = User::where('id_pegawai', $id_pegawai)->first();

        $request->validate([
            'id_pegawai' => 'required|unique:karyawans,id_pegawai,' . $karyawan->id,
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_bergabung' => 'required|date',
            'jabatan' => 'required|string|max:255',
            'password' => 'nullable|min:6',
        ]);

        $karyawan->update([
            'id_pegawai' => $request->id_pegawai,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'jabatan' => $request->jabatan,
        ]);

        if ($user) {
            $user->id_pegawai = $request->id_pegawai;
            $user->name = $request->nama_lengkap;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->password_plain = $request->password;
            }

            $user->save();
        }

        return redirect()->route('admin.karyawans.index')
                         ->with('success', 'Data karyawan berhasil diperbarui');
    }

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

    public function exportPdf()
    {
        $karyawans = Karyawan::all();
        $pdf = Pdf::loadView('admin.karyawan.export-pdf', compact('karyawans'));
        return $pdf->download('data-karyawan.pdf');
    }

    public function exportExcel()
    {
        $fileName = 'data-karyawan.csv';
        $karyawans = Karyawan::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($karyawans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID Pegawai', 'Nama Lengkap', 'Tanggal Bergabung', 'Jabatan']);

            foreach ($karyawans as $karyawan) {
                fputcsv($file, [
                    $karyawan->id_pegawai,
                    $karyawan->nama_lengkap,
                    \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d-m-Y'),
                    $karyawan->jabatan,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
