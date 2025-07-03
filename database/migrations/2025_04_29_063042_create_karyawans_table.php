<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai')->unique();
            $table->string('nama_lengkap');
            $table->date('tanggal_bergabung');
            $table->string('jabatan');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
