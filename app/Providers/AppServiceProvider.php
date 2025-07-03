<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Peminjaman;


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
        $notifikasiCount = Peminjaman::where('status', 'menunggu konfirmasi')->count();
        $view->with('notifikasiCount', $notifikasiCount);
    });
    }
}
