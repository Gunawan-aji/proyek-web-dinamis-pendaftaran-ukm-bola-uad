<?php
// database/migrations/..._create_pendaftar_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_admin', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 50)->unique();
            $table->string('password_hash', 255); // Password ter-hash
            $table->string('nama_pengguna', 100)->nullable();
            $table->enum('level', ['admin', 'pelatih']);
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_admin');
    }
};