<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\HomeUserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\User\BarangController as UserBarangController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;
use App\Http\Controllers\User\FavoritBarangController;
use App\Http\Controllers\User\LaporanController as UserLaporanController;


Route::get('/run-migrate', function () {
    Artisan::call('migrate --force');
    return '✅ Migrasi berhasil dijalankan!';
});

// Home
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// ================= ADMIN ROUTES =================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [HomeAdminController::class, 'index'])->name('dashboard');

    // Barang
    Route::get('/barangs', [BarangController::class, 'index'])->name('barangs');
    Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
    Route::post('/barangs/save', [BarangController::class, 'save'])->name('barangs.save');
    Route::get('/barangs/edit/{id}', [BarangController::class, 'edit'])->name('barangs.edit');
    Route::put('/barangs/edit/{id}', [BarangController::class, 'update'])->name('barangs.update');
    Route::delete('/barangs/delete/{id}', [BarangController::class, 'delete'])->name('barangs.delete');

    // Karyawan
    Route::get('/karyawans', [KaryawanController::class, 'index'])->name('karyawans.index');
    Route::get('/karyawans/create', [KaryawanController::class, 'create'])->name('karyawans.create');
    Route::post('/karyawans/save', [KaryawanController::class, 'save'])->name('karyawans.save');
    Route::get('/karyawans/edit/{id}', [KaryawanController::class, 'edit'])->name('karyawans.edit');
    Route::put('/karyawans/edit/{id}', [KaryawanController::class, 'update'])->name('karyawans.update');
    Route::delete('/karyawans/delete/{id}', [KaryawanController::class, 'delete'])->name('karyawans.delete');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::patch('/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasiPengembalian'])->name('peminjaman.konfirmasi');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.delete');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/{id}/selesai', [LaporanController::class, 'selesaikan'])->name('laporan.selesai');
    
    // Riwayat
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayat'])->name('riwayat.index');
    Route::get('/riwayat-peminjaman/pdf', [PeminjamanController::class, 'exportPDF'])->name('riwayat.pdf');
    Route::get('/riwayat-peminjaman/csv', [PeminjamanController::class, 'exportCSV'])->name('riwayat.csv');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================= USER ROUTES =================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [HomeUserController::class, 'index'])->name('dashboard');

    
    // Form upload bukti pengembalian
    Route::get('/peminjaman/{id}/bukti', [UserPeminjamanController::class, 'formBukti'])->name('peminjaman.bukti');
    Route::post('/peminjaman/{id}/bukti', [UserPeminjamanController::class, 'uploadBukti'])->name('peminjaman.uploadBukti');
    Route::get('/peminjaman/{id}/detail', [UserPeminjamanController::class, 'detail'])->name('peminjaman.detail');

    // Barang
    Route::get('/barang', [UserBarangController::class, 'index'])->name('barang.index');

    // Peminjaman
    Route::get('/peminjaman', [UserPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [UserPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [UserPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/kembalikan/{id}', [UserPeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::delete('/peminjaman/{id}', [UserPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Riwayat Peminjaman
    Route::get('/riwayat', [UserPeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
    

    // Favorit Barang (Wishlist)
    Route::get('/favorit', [FavoritBarangController::class, 'index'])->name('favorit.index');
    Route::post('/favorit/toggle/{barang}', [FavoritBarangController::class, 'toggle'])->name('favorit.toggle');

    // Laporan
    Route::get('/laporan', [UserLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/create', [UserLaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [UserLaporanController::class, 'store'])->name('laporan.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'userProfile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================= REDIRECT OTOMATIS LOGIN =================
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->usertype === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->usertype === 'user') {
            return redirect()->route('user.dashboard');
        }
    }
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// ================= EXPORT ROUTES =================
// Export Barang
Route::get('/admin/barangs/export/pdf', [BarangController::class, 'exportPdf'])->name('admin.barangs.export.pdf');
Route::get('/admin/barangs/export/csv', [BarangController::class, 'exportExcel'])->name('admin.barangs.export.csv');

// Export Karyawan
Route::get('/admin/karyawans/export/pdf', [KaryawanController::class, 'exportPdf'])->name('admin.karyawans.export.pdf');
Route::get('/admin/karyawans/export/csv', [KaryawanController::class, 'exportExcel'])->name('admin.karyawans.export.csv');
