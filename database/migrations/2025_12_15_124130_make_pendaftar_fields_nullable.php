<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            // Data Pribadi Lanjutan
            $table->string('no_telepon', 20)->nullable()->change();
            $table->string('prodi', 100)->nullable()->change();
            $table->tinyInteger('semester_saat_ini')->nullable()->change();
            $table->date('tgl_lahir')->nullable()->change();

            // Data Fisik & Posisi
            $table->integer('tinggi_badan_cm')->nullable()->change();
            $table->integer('berat_badan_kg')->nullable()->change();
            $table->enum('posisi_pilihan', ['GK', 'DF', 'MF', 'FW'])->nullable()->change();
            $table->enum('kaki_dominan', ['kanan', 'kiri', 'keduanya'])->nullable()->change();
            $table->string('riwayat_cedera', 255)->nullable()->change();

            // Path Dokumen
            $table->string('path_foto')->nullable()->change();
            $table->string('path_ktm')->nullable()->change();
            $table->string('path_sk_sehat')->nullable()->change();
            $table->string('path_sertifikat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            // (Opsional) Logika untuk mengembalikan kolom menjadi NOT NULL (kebalikan)
        });
    }
};