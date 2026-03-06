<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Peminjaman;
use App\Models\LaporanBarang;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {

            $notifikasiCount = Peminjaman::whereIn('status', [
                'menunggu konfirmasi',
                'dipinjam'
            ])->count();

            $notifikasiLaporan = LaporanBarang::where('status', [
                'pending',
                'menunggu'
            ])->count();

            $view->with([
                'notifikasiCount' => $notifikasiCount,
                'notifikasiLaporan' => $notifikasiLaporan
            ]);
        });
    }
}
