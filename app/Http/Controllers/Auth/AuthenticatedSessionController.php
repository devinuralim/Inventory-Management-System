<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    // ✅ Tambahkan ini!
    public function username()
    {
        return 'id_pegawai';
    }

   public function store(Request $request): RedirectResponse
{
    $request->validate([
        'id_pegawai' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = [
        'id_pegawai' => $request->id_pegawai,
        'password' => $request->password,
    ];

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'id_pegawai' => 'ID Pegawai atau password salah.',
        ])->onlyInput('id_pegawai');
    }

    $request->session()->regenerate();

    // 👇 Redirect berdasarkan role
    $user = Auth::user();
    if ($user->usertype === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->usertype === 'user') {
        return redirect()->route('user.dashboard');
    }

    // fallback
    return redirect('/');
}


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
