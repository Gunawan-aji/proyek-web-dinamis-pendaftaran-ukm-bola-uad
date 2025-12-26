<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            
            // Perbaikan untuk kolom yang menyebabkan error 1364
            $table->string('no_telepon', 20)->nullable()->change();
            $table->string('prodi', 100)->nullable()->change();
            $table->unsignedTinyInteger('semester_saat_ini')->nullable()->change();
            $table->date('tgl_lahir')->nullable()->change();
            
            // Data Fisik & Posisi
            $table->unsignedSmallInteger('tinggi_badan_cm')->nullable()->change();
            $table->unsignedSmallInteger('berat_badan_kg')->nullable()->change();
            // Tipe ENUM harus tetap ENUM, hanya boleh nullable()
            $table->enum('posisi_pilihan', ['GK', 'DF', 'MF', 'FW'])->nullable()->change(); 
            $table->enum('kaki_dominan', ['kanan', 'kiri', 'keduanya'])->nullable()->change();
            
            // Dokumen (Path Penyimpanan File)
            $table->string('path_foto', 255)->nullable()->change();         
            $table->string('path_ktm', 255)->nullable()->change();          
            $table->string('path_sk_sehat', 255)->nullable()->change();     
            
            // Perbaiki kolom status_pendaftaran agar hanya menggunakan nilai default
            $table->enum('status_pendaftaran', ['Menunggu Verifikasi Adm.', 'Lulus Adm.', 'Tolak Adm.', 'Menunggu Seleksi Lap.', 'Lulus Akhir', 'Tolak Akhir'])->default('Menunggu Verifikasi Adm.')->change();
        });
    }

    public function down(): void
    {
        // ... (Opsional: logic untuk down)
    }
};