<?php
// database/migrations/..._create_pendaftar_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('id_nilai');
            
            // KUNCI ASING
            // id_pendaftar merujuk ke tabel 'pendaftar'
            $table->foreignId('id_pendaftar')->constrained('pendaftar', 'id_pendaftar')->onDelete('cascade');
            
            // id_penilai merujuk ke tabel 'user_admin'
            $table->foreignId('id_penilai')->constrained('user_admin', 'id_user');
            
            // KRITERIA PENILAIAN
            $table->decimal('nilai_fisik', 5, 2)->default(0);
            $table->decimal('nilai_dribbling', 5, 2)->default(0);
            $table->decimal('nilai_visi', 5, 2)->default(0);
            $table->decimal('nilai_kerjasama', 5, 2)->default(0);
            
            $table->text('komentar_pelatih')->nullable();
            $table->date('tgl_penilaian');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};