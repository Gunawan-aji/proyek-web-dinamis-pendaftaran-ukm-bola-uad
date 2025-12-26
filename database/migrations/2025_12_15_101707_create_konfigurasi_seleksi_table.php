<?php
// database/migrations/..._create_pendaftar_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konfigurasi_seleksi', function (Blueprint $table) {
            $table->id(); // Laravel standard ID
            
            $table->date('tgl_daftar_mulai');
            $table->date('tgl_daftar_akhir');
            $table->date('tgl_seleksi_lapangan');
            $table->string('lokasi_seleksi', 255)->nullable();
            $table->text('alamat_lokasi')->nullable();
            $table->unsignedInteger('kuota_max');
            
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_seleksi');
    }
};