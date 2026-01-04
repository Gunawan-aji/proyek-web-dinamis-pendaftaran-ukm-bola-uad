<?php

// database/migrations/..._create_pendaftar_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id('id_pendaftar'); // Kunci utama

            // AKUN & DATA PRIBADI
            $table->string('nim', 15)->unique();
            $table->string('nama_lengkap', 150);
            $table->string('email_kampus', 100)->unique();
            $table->string('password_hash', 255);
            $table->string('no_telepon', 20);
            $table->string('prodi', 100);
            $table->unsignedTinyInteger('semester_saat_ini');
            $table->date('tgl_lahir');

            // DATA FISIK & POSISI
            $table->unsignedSmallInteger('tinggi_badan_cm');
            $table->unsignedSmallInteger('berat_badan_kg');
            $table->enum('posisi_pilihan', ['GK', 'DF', 'MF', 'FW']);
            $table->enum('kaki_dominan', ['kanan', 'kiri', 'keduanya']);
            $table->string('riwayat_cedera', 255)->nullable();

            // DOKUMEN (Path Penyimpanan File)
            $table->string('path_foto', 255);
            $table->string('path_ktm', 255);
            $table->string('path_sk_sehat', 255);
            $table->string('path_sertifikat', 255)->nullable();

            // STATUS PENDAFTARAN
            $table->enum('status_pendaftaran', ['Menunggu Verifikasi Adm.', 'Lulus Adm.', 'Tolak Adm.', 'Menunggu Seleksi Lap.', 'Lulus Akhir', 'Tolak Akhir'])->default('Menunggu Verifikasi Adm.');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};
