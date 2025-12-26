<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Ubah user_id menjadi tipe data string/varchar
            // Sesuaikan panjangnya dengan panjang maksimal id_user Anda (misal 50)
            $table->string('user_id', 50)->nullable()->change(); 
        });
    }

    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Kembalikan ke tipe integer jika diperlukan
            $table->bigInteger('user_id')->unsigned()->nullable()->change();
        });
    }
};