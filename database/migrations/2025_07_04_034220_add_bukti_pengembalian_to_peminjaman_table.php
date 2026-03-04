<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('peminjaman', 'bukti_pengembalian')) {
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->string('bukti_pengembalian')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('peminjaman', 'bukti_pengembalian')) {
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->dropColumn('bukti_pengembalian');
            });
        }
    }
};