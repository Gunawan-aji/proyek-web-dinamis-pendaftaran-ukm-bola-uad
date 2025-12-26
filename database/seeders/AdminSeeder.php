<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon; // Pastikan ini di-import (sudah Anda tambahkan)

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $adminUsername = 'adminuad';

        // 1. Cek apakah Admin dengan username ini sudah ada di database
        if (DB::table('user_admin')->where('username', $adminUsername)->doesntExist()) {
            
            // 2. Jika TIDAK ada, baru masukkan data
            DB::table('user_admin')->insert([
                'username' => $adminUsername,
                'password_hash' => Hash::make('password123'), 
                'nama_pengguna' => 'Admin UKM Bola',
                'level' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Opsional: Tampilkan pesan sukses di konsol
            $this->command->info("Akun Admin '$adminUsername' berhasil dibuat.");
        } else {
            // Opsional: Tampilkan peringatan jika akun sudah ada
            $this->command->warn("Akun Admin '$adminUsername' sudah ada. Seeder dilewati.");
        }
    }
}