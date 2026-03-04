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

// Jalankan migrate via route (opsional untuk development)
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

    // Reporting
    Route::get('/reporting/history', [LaporanController::class, 'history'])->name('reporting.history');
    Route::get('/reporting/bulanan', [LaporanController::class, 'bulanan'])->name('reporting.bulanan');
    Route::get('/reporting/rusak', [LaporanController::class, 'rusak'])->name('reporting.rusak');
    Route::post('/reporting/rusak/store', [LaporanController::class, 'storeRusak'])->name('reporting.rusak.store');

    Route::post('/reporting/rusak/update/{id}', [LaporanController::class, 'updateStatus'])->name('reporting.rusak.update');

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

    // Profile
    Route::get('/profile', [ProfileController::class, 'userProfile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================= LAPORAN (PERBAIKAN) =================
        Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])
            ->name('index'); // Ini akan menjadi 'user.laporan.index'

        Route::get('/create', [LaporanController::class, 'create'])
            ->name('create'); // Ini akan menjadi 'user.laporan.create'

        Route::post('/', [LaporanController::class, 'storeRusak'])
            ->name('store');
    });
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

// Export history
Route::get('/report/history', [LaporanController::class, 'history'])->name('report.history');
Route::get('/report/history/pdf', [LaporanController::class, 'pdf'])->name('report.history.pdf');
Route::get('/report/history/excel', [LaporanController::class, 'excel'])->name('report.history.excel');

// Export Riwayat (user)
Route::get('/riwayat/export/pdf', [UserPeminjamanController::class, 'exportPdf'])->name('user.riwayat.export.pdf');
Route::get('/riwayat/export/csv', [UserPeminjamanController::class, 'exportCsv'])->name('user.riwayat.export.csv');

Route::post('/reporting/rusak/store', [LaporanController::class, 'storeRusak'])
    ->name('reporting.rusak.store');