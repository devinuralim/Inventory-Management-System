<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login pakai ID Pegawai.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'id_pegawai' => 'required|string',
            'password' => 'required|string',
        ]);

        // Ambil data login dari input
        $credentials = [
            'id_pegawai' => $request->id_pegawai,
            'password' => $request->password,
        ];

        // Coba login
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'id_pegawai' => 'ID Pegawai atau password salah.',
            ])->onlyInput('id_pegawai');
        }

        $request->session()->regenerate();

        // Arahkan berdasarkan role
        if ($request->user()->usertype == 'admin') {
            return redirect('admin/dashboard');
        } elseif ($request->user()->usertype == 'user') {
            return redirect('user/dashboard');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Logout user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
