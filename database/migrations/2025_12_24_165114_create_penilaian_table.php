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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('id_penilaian');
            
            // Menggunakan foreignId agar lebih singkat dan standar Laravel modern
            // constrained() otomatis mencari tabel 'pendaftar' dan kolom 'id_pendaftar'
            $table->foreignId('id_pendaftar')
                  ->constrained('pendaftar', 'id_pendaftar')
                  ->onDelete('cascade');
            
            // Kolom skor nilai (Gunakan unsigned agar tidak ada nilai negatif)
            $table->unsignedInteger('skor_fisik')->default(0);
            $table->unsignedInteger('skor_teknik')->default(0);
            $table->unsignedInteger('skor_visi')->default(0);
            $table->unsignedInteger('skor_kerjasama')->default(0);
            
            // Nilai rata-rata (Total skor / 4)
            $table->decimal('nilai_rata_rata', 5, 2)->default(0.00);
            
            $table->text('catatan_pelatih')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};